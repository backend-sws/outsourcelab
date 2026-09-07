<?php

$content = file_get_contents('d:/lab/lab/resources/views/welcome.blade.php');
$lines = explode("\n", $content);
foreach ($lines as $i => $line) {
    if (stripos($line, 'chevron') !== false || stripos($line, 'fa-arrow') !== false || stripos($line, 'swiper-button') !== false || stripos($line, 'prev') !== false || stripos($line, 'next') !== false) {
        echo "Line " . ($i + 1) . ": " . trim($line) . PHP_EOL;
    }
}
