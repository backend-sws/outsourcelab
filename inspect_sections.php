<?php

$content = file_get_contents('d:/lab/lab/resources/views/welcome.blade.php');
$lines = explode("\n", $content);

$targets = [230, 450, 650, 1270];
foreach ($targets as $target) {
    echo "=== Section Around Line $target ===" . PHP_EOL;
    for ($i = max(0, $target - 10); $i <= min(count($lines) - 1, $target + 30); $i++) {
        echo ($i + 1) . ": " . $lines[$i] . PHP_EOL;
    }
}
