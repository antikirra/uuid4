<?php

use function Antikirra\uuid4;
use function Antikirra\uuid4_validate;

require __DIR__ . '/vendor/autoload.php';

echo "UUID4 Performance Benchmark\n";
echo "===========================\n\n";

// Benchmark uuid4() generation
$iterations = 100000;
$startTime = microtime(true);

for ($i = 0; $i < $iterations; $i++) {
    uuid4();
}

$endTime = microtime(true);
$duration = $endTime - $startTime;
$generationsPerSecond = (int)($iterations / $duration);

echo "UUID Generation:\n";
echo "  Iterations: " . number_format($iterations) . "\n";
echo "  Duration: " . number_format($duration, 4) . " seconds\n";
echo "  Speed: " . number_format($generationsPerSecond) . " ops/sec\n\n";

// Benchmark uuid4_validate() with valid UUIDs
$validationIterations = 1000000;
$testUuids = [];

// Pre-generate UUIDs for validation testing
for ($i = 0; $i < 1000; $i++) {
    $testUuids[] = uuid4();
}

$startTime = microtime(true);

for ($i = 0; $i < $validationIterations; $i++) {
    uuid4_validate($testUuids[$i % 1000]);
}

$endTime = microtime(true);
$duration = $endTime - $startTime;
$validationsPerSecond = (int)($validationIterations / $duration);

echo "UUID Validation (valid UUIDs):\n";
echo "  Iterations: " . number_format($validationIterations) . "\n";
echo "  Duration: " . number_format($duration, 4) . " seconds\n";
echo "  Speed: " . number_format($validationsPerSecond) . " ops/sec\n\n";

// Summary
echo "Summary:\n";
echo "--------\n";
echo "Generation: " . number_format($generationsPerSecond) . " ops/sec\n";
echo "Validation: " . number_format($validationsPerSecond) . " ops/sec\n";
