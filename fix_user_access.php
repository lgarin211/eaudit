<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Fixing User 5 (Dinkes) Access ===\n";

// Get all jenis_temuan IDs grouped by pengawasan
$allJenisTemuans = DB::table('jenis_temuans')
    ->select('id', 'id_pengawasan', 'nama_temuan', 'rekomendasi')
    ->get()
    ->groupBy('id_pengawasan');

echo "Available jenis_temuan by pengawasan:\n";
foreach ($allJenisTemuans as $pengawasanId => $jenisTemuans) {
    echo "Pengawasan $pengawasanId: ";
    $ids = $jenisTemuans->pluck('id')->toArray();
    echo implode(', ', $ids) . "\n";
}

// Let's update user 5 to have access to some real IDs
// For example, give access to pengawasan 1 and 3
$newAccessIds = [];
if (isset($allJenisTemuans[1])) {
    $newAccessIds = array_merge($newAccessIds, $allJenisTemuans[1]->pluck('id')->toArray());
}
if (isset($allJenisTemuans[3])) {
    $newAccessIds = array_merge($newAccessIds, $allJenisTemuans[3]->pluck('id')->toArray());
}

if (!empty($newAccessIds)) {
    echo "\nUpdating User 5 access to IDs: " . implode(', ', $newAccessIds) . "\n";

    DB::table('user_data_access')
        ->where('user_id', 5)
        ->update([
            'jenis_temuan_ids' => json_encode($newAccessIds),
            'updated_at' => now()
        ]);

    echo "✅ User 5 access updated successfully!\n";

    // Verify update
    $updated = DB::table('user_data_access')->where('user_id', 5)->first();
    echo "New access: {$updated->jenis_temuan_ids}\n";
} else {
    echo "❌ No jenis_temuan found to assign access\n";
}
