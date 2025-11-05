<?php
// Debug script untuk cek data kode_rekomendasi
require_once 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== DEBUG KODE_REKOMENDASI ===\n\n";

try {
    // Cek data yang ada di database dengan id_pengawasan = 316 (dari screenshot)
    $id_pengawasan = 316;

    echo "1. Mengambil data dari database untuk id_pengawasan = $id_pengawasan\n";
    echo "-----------------------------------------------------------\n";

    $rawData = DB::table('jenis_temuans')
        ->where('id_pengawasan', $id_pengawasan)
        ->select('id', 'kode_temuan', 'nama_temuan', 'kode_rekomendasi', 'rekomendasi', 'id_parent')
        ->orderBy('id')
        ->get();

    if ($rawData->count() == 0) {
        echo "❌ Tidak ada data ditemukan untuk id_pengawasan = $id_pengawasan\n";

        // Cek data lain yang ada
        $otherData = DB::table('jenis_temuans')
            ->select('id_pengawasan')
            ->distinct()
            ->get();

        echo "\nID pengawasan yang tersedia:\n";
        foreach ($otherData as $item) {
            echo "- {$item->id_pengawasan}\n";
        }

    } else {
        echo "✅ Ditemukan {$rawData->count()} record\n\n";

        foreach ($rawData as $item) {
            echo "ID: {$item->id}\n";
            echo "Kode Temuan: {$item->kode_temuan}\n";
            echo "Nama Temuan: {$item->nama_temuan}\n";
            echo "Kode Rekomendasi: " . ($item->kode_rekomendasi ?? 'NULL') . "\n";
            echo "Rekomendasi: {$item->rekomendasi}\n";
            echo "ID Parent: {$item->id_parent}\n";
            echo "---\n";
        }
    }

    echo "\n2. Test grouping logic (seperti di controller)\n";
    echo "----------------------------------------------\n";

    $groupedData = [];

    foreach ($rawData as $item) {
        $key = $item->kode_temuan . '|' . $item->nama_temuan;

        if (!isset($groupedData[$key])) {
            $groupedData[$key] = [
                'kode_temuan' => $item->kode_temuan,
                'nama_temuan' => $item->nama_temuan,
                'recommendations' => []
            ];
        }

        $groupedData[$key]['recommendations'][] = $item;
    }

    echo "Grouped data:\n";
    foreach ($groupedData as $key => $group) {
        echo "Group: $key\n";
        echo "  - Recommendations count: " . count($group['recommendations']) . "\n";

        foreach ($group['recommendations'] as $rekom) {
            echo "    * ID: {$rekom->id}, kode_rekomendasi: " . ($rekom->kode_rekomendasi ?? 'NULL') . "\n";
        }
        echo "\n";
    }

    echo "\n3. Test buildRecommendationHierarchy\n";
    echo "-----------------------------------\n";

    // Simulasi hierarchy building (seperti di controller)
    foreach ($groupedData as $group) {
        $recommendations = $group['recommendations'];

        // Build lookup array
        $lookup = [];
        foreach ($recommendations as $item) {
            $lookup[$item->id] = $item;
            $lookup[$item->id]->children = [];
        }

        // Build hierarchy
        $roots = [];
        foreach ($recommendations as $item) {
            if ($item->id_parent == $item->id) {
                // Root item
                $roots[] = $item;
            } else {
                // Child item
                if (isset($lookup[$item->id_parent])) {
                    $lookup[$item->id_parent]->children[] = $item;
                }
            }
        }

        echo "Hierarchy untuk group: {$group['kode_temuan']} | {$group['nama_temuan']}\n";
        foreach ($roots as $root) {
            echo "Root: ID {$root->id}, kode_rekomendasi: " . ($root->kode_rekomendasi ?? 'NULL') . "\n";

            if (!empty($root->children)) {
                foreach ($root->children as $child) {
                    echo "  Child: ID {$child->id}, kode_rekomendasi: " . ($child->kode_rekomendasi ?? 'NULL') . "\n";
                }
            }
        }
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== END DEBUG ===\n";
?>