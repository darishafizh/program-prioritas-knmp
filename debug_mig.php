<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$log = "Starting migration...\n";
try {
    \Illuminate\Support\Facades\Artisan::call('migrate');
    $log .= \Illuminate\Support\Facades\Artisan::output();
} catch (\Throwable $e) {
    $log .= "EXCEPTION: " . $e->getMessage() . "\n";
    $log .= "FILE: " . $e->getFile() . ":" . $e->getLine() . "\n";
    $log .= "TRACE:\n" . $e->getTraceAsString() . "\n";
}
file_put_contents('mig_log_clean.txt', $log);
