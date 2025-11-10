<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== User Data Access Table ===\n";
$users = DB::table('user_data_access')->get();

if ($users->isEmpty()) {
    echo "No user access data found!\n";
} else {
    foreach ($users as $user) {
        echo "User ID: {$user->user_id}\n";
        echo "Access Type: {$user->access_type}\n";
        echo "Is Active: " . ($user->is_active ? 'Yes' : 'No') . "\n";
        echo "Jenis Temuan IDs: {$user->jenis_temuan_ids}\n";
        echo "Notes: {$user->notes}\n";
        echo "---\n";
    }
}

echo "\n=== All Users ===\n";
$allUsers = DB::table('users')->select('id', 'name', 'username', 'role')->get();
foreach ($allUsers as $user) {
    echo "ID: {$user->id}, Name: {$user->name}, Username: {$user->username}, Role: {$user->role}\n";
}

echo "\n=== Sample Jenis Temuan IDs ===\n";
$jenisTemuans = DB::table('jenis_temuans')->select('id', 'id_pengawasan', 'nama_temuan', 'rekomendasi')->limit(10)->get();
foreach ($jenisTemuans as $jenis) {
    echo "ID: {$jenis->id}, Pengawasan: {$jenis->id_pengawasan}, Nama: {$jenis->nama_temuan}, Rekom: {$jenis->rekomendasi}\n";
}

echo "\n=== Checking User 5 (Dinkes) Access IDs ===\n";
$userAccessIds = ["20", "21", "22", "23", "40", "41", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57"];
$accessibleJenisTemuans = DB::table('jenis_temuans')
    ->select('id', 'id_pengawasan', 'nama_temuan', 'rekomendasi')
    ->whereIn('id', $userAccessIds)
    ->get();

if ($accessibleJenisTemuans->isEmpty()) {
    echo "NO JENIS TEMUAN FOUND with User 5's access IDs!\n";
    echo "User has access to IDs: " . implode(', ', $userAccessIds) . "\n";

    echo "\nAll existing jenis_temuan IDs:\n";
    $allIds = DB::table('jenis_temuans')->pluck('id')->toArray();
    echo implode(', ', array_slice($allIds, 0, 20)) . " (showing first 20)\n";
} else {
    echo "Found " . $accessibleJenisTemuans->count() . " accessible jenis temuan:\n";
    foreach ($accessibleJenisTemuans as $jenis) {
        echo "ID: {$jenis->id}, Pengawasan: {$jenis->id_pengawasan}, Nama: {$jenis->nama_temuan}, Rekom: {$jenis->rekomendasi}\n";
    }
}

echo "\n=== Checking Pengawasan Schema ===\n";
try {
    $pengawasanColumns = DB::select("DESCRIBE pengawasans");
    echo "Pengawasans table columns:\n";
    foreach ($pengawasanColumns as $col) {
        echo "- {$col->Field} ({$col->Type})\n";
    }
} catch (Exception $e) {
    echo "Error checking schema: " . $e->getMessage() . "\n";
}

echo "\n=== Sample Pengawasan Data ===\n";
$pengawasans = DB::table('pengawasans')->select('id')->limit(5)->get();
foreach ($pengawasans as $pengawasan) {
    echo "Pengawasan ID: {$pengawasan->id}\n";
}