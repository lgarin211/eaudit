<?php
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Pengawasan;

echo "Checking Pengawasan status_LHP values:\n\n";

$pengawasans = Pengawasan::select('id', 'status_LHP', 'updated_at')->get();

foreach ($pengawasans as $pengawasan) {
    echo "ID: {$pengawasan->id} | Status: {$pengawasan->status_LHP} | Updated: {$pengawasan->updated_at}\n";
}

echo "\nDone.\n";
