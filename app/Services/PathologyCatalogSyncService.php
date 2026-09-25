<?php

namespace App\Services;

use App\Models\Package;
use App\Models\Test;
use App\Models\TestCategory;

class PathologyCatalogSyncService
{
    public function __construct(
        protected PathologyApiService $api
    ) {}

    /**
     * Run full catalog synchronization.
     *
     * @return array{success: bool, message: string, departments: int, tests: int, packages: int}
     */
    public function syncAll(bool $overwritePricing = false): array
    {
        if (! $this->api->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Pathology API is not configured. Please enter API URL and Key in settings.',
                'departments' => 0,
                'tests' => 0,
                'packages' => 0,
            ];
        }

        $departmentsCount = $this->syncDepartments();
        $packagesCount = $this->syncPackages($overwritePricing);
        $testsCount = $this->syncTests($overwritePricing);

        return [
            'success' => true,
            'message' => "Sync completed: {$testsCount} tests, {$packagesCount} packages, {$departmentsCount} departments updated.",
            'departments' => $departmentsCount,
            'tests' => $testsCount,
            'packages' => $packagesCount,
        ];
    }

    /**
     * Sync departments to TestCategory.
     */
    public function syncDepartments(): int
    {
        $departments = $this->api->getDepartments();
        $count = 0;

        foreach ($departments as $dept) {
            $name = trim($dept['name'] ?? '');
            if (empty($name)) {
                continue;
            }

            TestCategory::firstOrCreate(['name' => $name]);
            $count++;
        }

        return $count;
    }

    /**
     * Extract parameter names from a raw LIS parameters array.
     * LIS returns: [{"name": "Hemoglobin", "unit": "g/dL", "ref_range": ""}, ...]
     *
     * @return string[]
     */
    protected function extractParamNames(mixed $rawParams): array
    {
        if (! is_array($rawParams) || empty($rawParams)) {
            return [];
        }

        $names = [];
        foreach ($rawParams as $param) {
            if (is_array($param)) {
                $name = trim($param['name'] ?? '');
            } else {
                $name = trim((string) $param);
            }
            if (! empty($name)) {
                $names[] = $name;
            }
        }

        return $names;
    }

    /**
     * Sync tests catalog — including parameters, department, sample type, TAT.
     */
    public function syncTests(bool $overwritePricing = false): int
    {
        $data = $this->api->getTests(['per_page' => 500]);

        // API may return paginated {tests: [...]} or bare array
        $tests = $data['tests'] ?? $data;
        if (! is_array($tests)) {
            return 0;
        }

        $count = 0;

        foreach ($tests as $item) {
            $lisId = (int) ($item['id'] ?? 0);
            $testCode = trim($item['test_code'] ?? '');
            $name = trim($item['name'] ?? '');
            $lisPrice = (float) ($item['price'] ?? 0);
            $tatHours = isset($item['tat_hours']) ? (int) $item['tat_hours'] : null;
            $sampleType = $item['sample_type'] ?? null;
            $fastingRequired = ! empty($item['fasting_required']);

            // LIS uses "department" (not "department_name")
            $deptName = trim($item['department'] ?? $item['department_name'] ?? '');

            // Extract parameters — LIS returns objects [{name, unit, ref_range}]
            $parameterNames = $this->extractParamNames($item['parameters'] ?? []);

            if (empty($name)) {
                continue;
            }

            // Match or create department
            $testCategoryId = null;
            if ($deptName !== '') {
                $category = TestCategory::firstOrCreate(['name' => $deptName]);
                $testCategoryId = $category->id;
            }

            // Find existing test by lis_test_id → test_code → name
            $test = null;
            if ($lisId > 0) {
                $test = Test::where('lis_test_id', $lisId)->first();
            }
            if (! $test && ! empty($testCode)) {
                $test = Test::where('test_code', $testCode)->first();
            }
            if (! $test) {
                $test = Test::where('name', $name)->first();
            }

            if ($test) {
                $test->lis_test_id = $lisId ?: $test->lis_test_id;
                $test->test_code = $testCode ?: $test->test_code;
                $test->lis_price = $lisPrice;
                $test->sample_type = $sampleType ?: $test->sample_type;
                $test->tat_hours = $tatHours ?: $test->tat_hours;
                $test->fasting_required = $fastingRequired;

                // Assign department if not already set
                if ($testCategoryId && ! $test->test_category_id) {
                    $test->test_category_id = $testCategoryId;
                }

                // Update parameters from LIS or fallback to single parameter [name]
                if (! empty($parameterNames)) {
                    $test->parameters = $parameterNames;
                } elseif (empty($test->parameters)) {
                    $test->parameters = [$test->name];
                }

                $test->lis_synced_at = now();

                // Only overwrite selling price if not locked and no custom price yet
                if (! $test->lock_pricing && ($overwritePricing || empty($test->price) || $test->price == 0)) {
                    $test->price = $lisPrice;
                }

                $test->save();
            } else {
                // Create new Test record
                $test = new Test;
                $test->name = $name;
                $test->test_code = $testCode;
                $test->lis_test_id = $lisId;
                $test->lis_price = $lisPrice;
                $test->price = $lisPrice;
                $test->sample_type = $sampleType;
                $test->tat_hours = $tatHours;
                $test->fasting_required = $fastingRequired;
                $test->test_category_id = $testCategoryId;
                $test->parameters = ! empty($parameterNames) ? $parameterNames : [$name];
                $test->is_active = true;
                $test->home_collection_available = true;
                $test->report_delivery_time = $tatHours
                    ? ($tatHours >= 24 ? round($tatHours / 24).' Day(s)' : "{$tatHours} Hours")
                    : 'Within 24 Hours';
                $test->preparation_instructions = $fastingRequired
                    ? 'Requires 8 to 10 hours overnight fasting.'
                    : null;
                $test->lis_synced_at = now();
                $test->save();
            }

            $count++;
        }

        return $count;
    }

    /**
     * Sync health packages — including nested tests and their individual parameters.
     *
     * Package->parameters stores a flat list like:
     *   ["Blood Sugar Fasting: Blood Sugar (Fasting)", "HbA1c: HbA1c", "HbA1c: Estimated Average Glucose", ...]
     *
     * This enables getGroupedParameters() to group by test name on the frontend.
     */
    public function syncPackages(bool $overwritePricing = false): int
    {
        $packages = $this->api->getPackages();
        if (! is_array($packages)) {
            return 0;
        }

        $count = 0;

        foreach ($packages as $pkg) {
            $lisId = (int) ($pkg['id'] ?? 0);
            $pkgCode = trim($pkg['test_code'] ?? '');
            $name = trim($pkg['name'] ?? '');
            $lisPrice = (float) ($pkg['price'] ?? 0);
            $tatHours = isset($pkg['tat_hours']) ? (int) $pkg['tat_hours'] : null;
            $sampleType = $pkg['sample_type'] ?? null;
            $description = $pkg['description'] ?? null;

            if (empty($name)) {
                continue;
            }

            // Fetch package detail with included_tests and their parameters
            $details = null;
            if ($lisId > 0) {
                $details = $this->api->getPackageDetails($lisId);
            }

            $parametersList = [];
            $totalParams = (int) ($pkg['tests_count'] ?? 1);
            $includedTestsData = []; // [{id, name, test_code, parameters:[{name,unit},...]}]

            if ($details && ! empty($details['included_tests'])) {
                $totalParams = (int) ($details['total_parameters_count'] ?? $totalParams);
                $includedTestsData = $details['included_tests'];

                foreach ($includedTestsData as $incTest) {
                    $testTitle = trim($incTest['name'] ?? 'Test');
                    $rawParams = $incTest['parameters'] ?? [];
                    $paramNames = $this->extractParamNames($rawParams);
                    $incTestId = (int) ($incTest['id'] ?? 0);
                    $incTestCode = trim($incTest['test_code'] ?? '');
                    $incDept = trim($incTest['department'] ?? '');
                    $incSampleType = trim($incTest['sample_type'] ?? '');

                    if (! empty($paramNames)) {
                        foreach ($paramNames as $paramName) {
                            $parametersList[] = "{$testTitle}: {$paramName}";
                        }
                    } else {
                        // Single-marker test — just the test name
                        $parametersList[] = $testTitle;
                    }

                    // Synchronize this individual test into the tests table so it has its parameters
                    $matchedTest = null;
                    if ($incTestId > 0) {
                        $matchedTest = Test::where('lis_test_id', $incTestId)->first();
                    }
                    if (! $matchedTest && ! empty($incTestCode)) {
                        $matchedTest = Test::where('test_code', $incTestCode)->first();
                    }
                    if (! $matchedTest && ! empty($testTitle)) {
                        $matchedTest = Test::where('name', $testTitle)->first();
                    }
                    if (! $matchedTest && ! empty($testTitle)) {
                        $baseName = trim(preg_replace('/\(.*?\)/', '', $testTitle));
                        if (strlen($baseName) > 3) {
                            $matchedTest = Test::where('name', 'like', $baseName.'%')->first();
                        }
                    }
                    if (! $matchedTest && preg_match('/\((.*?)\)/', $testTitle, $m)) {
                        $acronym = trim($m[1]);
                        if (strlen($acronym) >= 2) {
                            $matchedTest = Test::where('name', 'like', "%({$acronym}%")->first();
                        }
                    }

                    $deptId = null;
                    if (! empty($incDept)) {
                        $cat = TestCategory::firstOrCreate(['name' => $incDept]);
                        $deptId = $cat->id;
                    }

                    if ($matchedTest) {
                        if ($incTestId > 0 && empty($matchedTest->lis_test_id)) {
                            $matchedTest->lis_test_id = $incTestId;
                        }
                        if (! empty($incTestCode) && empty($matchedTest->test_code)) {
                            $matchedTest->test_code = $incTestCode;
                        }
                        if (! empty($paramNames)) {
                            $matchedTest->parameters = $paramNames;
                        } elseif (empty($matchedTest->parameters)) {
                            $matchedTest->parameters = [$matchedTest->name];
                        }
                        if ($deptId && ! $matchedTest->test_category_id) {
                            $matchedTest->test_category_id = $deptId;
                        }
                        if ($incSampleType && ! $matchedTest->sample_type) {
                            $matchedTest->sample_type = $incSampleType;
                        }
                        $matchedTest->lis_synced_at = now();
                        $matchedTest->save();
                    } else {
                        $newTest = new Test;
                        $newTest->name = $testTitle;
                        $newTest->test_code = $incTestCode ?: null;
                        $newTest->lis_test_id = $incTestId ?: null;
                        $newTest->parameters = ! empty($paramNames) ? $paramNames : [$testTitle];
                        $newTest->test_category_id = $deptId;
                        $newTest->sample_type = $incSampleType ?: 'Blood';
                        $newTest->price = (float) ($pkg['price'] ?? 499);
                        $newTest->is_active = true;
                        $newTest->home_collection_available = true;
                        $newTest->report_delivery_time = 'Within 24 Hours';
                        $newTest->lis_synced_at = now();
                        $newTest->save();
                    }
                }
            }

            // Find existing package
            $package = null;
            if ($lisId > 0) {
                $package = Package::where('lis_package_id', $lisId)->first();
            }
            if (! $package && ! empty($pkgCode)) {
                $package = Package::where('package_code', $pkgCode)->first();
            }
            if (! $package) {
                $package = Package::where('name', $name)->first();
            }

            if ($package) {
                $package->lis_package_id = $lisId ?: $package->lis_package_id;
                $package->package_code = $pkgCode ?: $package->package_code;
                $package->lis_price = $lisPrice;
                $package->sample_type = $sampleType ?: $package->sample_type;
                $package->tat_hours = $tatHours ?: $package->tat_hours;
                $package->description = $description ?: $package->description;
                $package->lis_synced_at = now();

                if (! empty($parametersList)) {
                    $package->parameters = $parametersList;
                    $package->total_parameters = $totalParams > 0 ? $totalParams : count($parametersList);
                }

                if (! $package->lock_pricing && ($overwritePricing || empty($package->price) || $package->price == 0)) {
                    $package->price = $lisPrice;
                }

                $package->save();
            } else {
                $package = new Package;
                $package->name = $name;
                $package->package_code = $pkgCode;
                $package->lis_package_id = $lisId;
                $package->lis_price = $lisPrice;
                $package->price = $lisPrice;
                $package->sample_type = $sampleType;
                $package->tat_hours = $tatHours;
                $package->description = $description;
                $package->parameters = $parametersList;
                $package->total_parameters = $totalParams > 0 ? $totalParams : count($parametersList);
                $package->is_active = true;
                $package->type = 'general';
                $package->display_sections = ['top_booked'];
                $package->lis_synced_at = now();
                $package->save();
            }

            $count++;
        }

        return $count;
    }
}
