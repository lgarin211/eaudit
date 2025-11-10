<?php
// Simple test script to verify route generation
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Boot the application
$app->bootstrapWith([
    \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
    \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
    \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
    \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
    \Illuminate\Foundation\Bootstrap\SetRequestForConsole::class,
    \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
    \Illuminate\Foundation\Bootstrap\BootProviders::class,
]);

try {
    echo "Testing route generation:\n";
    echo "opdTL.menuA1: " . route('opdTL.menuA1') . "\n";
    echo "opdTL.menuA1.detail with ID 1: " . route('opdTL.menuA1.detail', 1) . "\n";
    echo "opdTL.menuA1.detail with ID 123: " . route('opdTL.menuA1.detail', 123) . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}