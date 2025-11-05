<?php

namespace App\Http\Controllers\AdminTL\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengawasan;
use App\Models\DataDukung;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class VerifikasiController extends Controller
{
    /**
     * Display verification data list (Legacy - redirect to rekomendasi)
     */
    public function index()
    {
        return redirect()->route('adminTL.verifikasi.rekomendasi');
    }

    /**
     * Display verification data list for Rekomendasi
     */
    public function indexRekomendasi()
    {
        try {
            // Get all data but prioritize 'Di Proses' status at the top
            $data = Pengawasan::with([
                'dataDukung' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                }
            ])
                ->where(function ($query) {
                    // Filter untuk data yang terkait dengan rekomendasi
                    $query->where('jenis', 'LIKE', '%rekomendasi%')
                        ->orWhere('tipe', 'LIKE', '%rekomendasi%')
                        ->orWhereHas('dataDukung', function ($q) {
                        $q->whereNull('id_jenis_temuan');
                    });
                })
                // Order by: Di Proses first, then others by updated_at desc
                ->orderByRaw("CASE
                    WHEN status_LHP = 'Di Proses' THEN 1
                    WHEN status_LHP = 'Belum Jadi' THEN 2
                    WHEN status_LHP = 'Diterima' THEN 3
                    WHEN status_LHP = 'Ditolak' THEN 4
                    ELSE 5
                END")
                ->orderBy('updated_at', 'desc')
                ->paginate(10);

            $pageType = 'rekomendasi';
            $pageTitle = 'Verifikasi Data - Rekomendasi';

            return view('AdminTL.verifikasi.index', compact('data', 'pageType', 'pageTitle'));
        } catch (\Exception $e) {
            Log::error('Error loading verification rekomendasi data', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Gagal memuat data verifikasi rekomendasi');
        }
    }

    /**
     * Display verification data list for Temuan dan Rekomendasi
     */
    public function indexTemuan()
    {
        try {
            // Get all data but prioritize 'Di Proses' status at the top
            $data = Pengawasan::with([
                'dataDukung' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                }
            ])
                ->where(function ($query) {
                    // Filter untuk data yang terkait dengan temuan dan rekomendasi
                    $query->where('jenis', 'LIKE', '%temuan%')
                        ->orWhere('tipe', 'LIKE', '%temuan%')
                        ->orWhereHas('dataDukung', function ($q) {
                        $q->whereNotNull('id_jenis_temuan');
                    });
                })
                // Order by: Di Proses first, then others by updated_at desc
                ->orderByRaw("CASE
                    WHEN status_LHP = 'Di Proses' THEN 1
                    WHEN status_LHP = 'Belum Jadi' THEN 2
                    WHEN status_LHP = 'Diterima' THEN 3
                    WHEN status_LHP = 'Ditolak' THEN 4
                    ELSE 5
                END")
                ->orderBy('updated_at', 'desc')
                ->paginate(10);

            $pageType = 'temuan';
            $pageTitle = 'Verifikasi Data - Temuan dan Rekomendasi';

            return view('AdminTL.verifikasi.index', compact('data', 'pageType', 'pageTitle'));
        } catch (\Exception $e) {
            Log::error('Error loading verification temuan data', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Gagal memuat data verifikasi temuan');
        }
    }

    /**
     * Show detail verification data with files
     */
    public function show($type, $id)
    {
        try {
            $pengawasan = Pengawasan::with([
                'dataDukung' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                }
            ])->findOrFail($id);

            // Show all data regardless of status (for viewing purposes)
            // But disable status update for completed data
            $canUpdateStatus = in_array($pengawasan->status_LHP, ['Belum Jadi', 'Di Proses']);

            // Build hierarchical data structure for detailed display
            $hierarchicalData = $this->buildHierarchicalDataForVerification($id);

            // Get additional pengawasan data via API
            $penugasanData = null;
            try {
                $token = session('ctoken');
                if ($token) {
                    $response = \Illuminate\Support\Facades\Http::get("http://127.0.0.1:8000/api/pengawasan-edit/{$id}", [
                        'token' => $token
                    ]);

                    if ($response->successful()) {
                        $penugasanData = $response->json()['data'] ?? null;
                    }
                }
            } catch (\Exception $e) {
                Log::warning('Could not fetch penugasan data: ' . $e->getMessage());
            }

            $pageType = $type;
            $pageTitle = $type === 'rekomendasi' ? 'Detail Verifikasi - Rekomendasi' : 'Detail Verifikasi - Temuan dan Rekomendasi';

            return view('AdminTL.verifikasi.show', compact('pengawasan', 'pageType', 'pageTitle', 'canUpdateStatus', 'hierarchicalData', 'penugasanData'));
        } catch (\Exception $e) {
            Log::error('Error loading verification detail', [
                'type' => $type,
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            $redirectRoute = $type === 'rekomendasi' ? 'adminTL.verifikasi.rekomendasi' : 'adminTL.verifikasi.temuan';
            return redirect()->route($redirectRoute)
                ->with('error', 'Data tidak ditemukan');
        }
    }

    /**
     * Update status with reason
     */
    public function updateStatus(Request $request, $type, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'status_LHP' => 'required|in:Di Proses,Diterima,Ditolak',
                'alasan_verifikasi' => 'required|string|max:1000'
            ], [
                'status_LHP.required' => 'Status harus dipilih',
                'status_LHP.in' => 'Status tidak valid',
                'alasan_verifikasi.required' => 'Alasan verifikasi harus diisi',
                'alasan_verifikasi.max' => 'Alasan verifikasi maksimal 1000 karakter'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $pengawasan = Pengawasan::findOrFail($id);

            // Validate current status
            if (!in_array($pengawasan->status_LHP, ['Belum Jadi', 'Di Proses'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status saat ini tidak dapat diubah'
                ], 400);
            }

            // Validate status transition
            $validTransitions = [
                'Belum Jadi' => ['Di Proses'],
                'Di Proses' => ['Diterima', 'Ditolak']
            ];

            $currentStatus = $pengawasan->status_LHP;
            $newStatus = $request->status_LHP;

            if (!in_array($newStatus, $validTransitions[$currentStatus])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transisi status tidak valid dari ' . $currentStatus . ' ke ' . $newStatus
                ], 400);
            }

            // Update status with reason
            $updated = DB::table('pengawasans')
                ->where('id', $id)
                ->update([
                    'status_LHP' => $newStatus,
                    'alasan_verifikasi' => $request->alasan_verifikasi,
                    'tgl_verifikasi' => now(),
                    'updated_at' => now()
                ]);

            if ($updated) {
                Log::info('Status verifikasi berhasil diupdate', [
                    'id_pengawasan' => $id,
                    'old_status' => $currentStatus,
                    'new_status' => $newStatus,
                    'alasan' => $request->alasan_verifikasi,
                    'user' => auth()->user()->name ?? 'Unknown'
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Status berhasil diupdate ke ' . $newStatus,
                    'data' => [
                        'status_LHP' => $newStatus,
                        'alasan_verifikasi' => $request->alasan_verifikasi,
                        'tgl_verifikasi' => now()->format('d/m/Y H:i:s')
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate status'
            ], 500);

        } catch (\Exception $e) {
            Log::error('Error updating verification status', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem'
            ], 500);
        }
    }

    /**
     * Get available status options for current status
     */
    public function getStatusOptions($type, $id)
    {
        try {
            $pengawasan = Pengawasan::findOrFail($id);

            $statusOptions = [
                'Belum Jadi' => [
                    ['value' => 'Di Proses', 'label' => 'Di Proses']
                ],
                'Di Proses' => [
                    ['value' => 'Diterima', 'label' => 'Diterima'],
                    ['value' => 'Ditolak', 'label' => 'Ditolak']
                ]
            ];

            $options = $statusOptions[$pengawasan->status_LHP] ?? [];

            return response()->json([
                'success' => true,
                'current_status' => $pengawasan->status_LHP,
                'options' => $options
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading status options'
            ], 500);
        }
    }

    /**
     * Build hierarchical data structure for verification display
     * Same as DashboardAminTLController but for read-only purposes
     */
    private function buildHierarchicalDataForVerification($id_pengawasan)
    {
        try {
            // Ambil semua data dari database
            $allData = DB::table('jenis_temuans')
                ->where('id_pengawasan', $id_pengawasan)
                ->orderBy('id')
                ->get();

            if ($allData->isEmpty()) {
                return collect([]);
            }

            // Build hierarchical structure
            $hierarchicalData = $this->buildHierarchicalStructureForVerification($allData);

            return collect($hierarchicalData);

        } catch (\Exception $e) {
            Log::error('Error building hierarchical data for verification:', [
                'error' => $e->getMessage(),
                'id_pengawasan' => $id_pengawasan
            ]);

            return collect([]);
        }
    }

    /**
     * Build hierarchical structure for rekomendasi data (read-only version)
     * Supports multi-level hierarchy: Parent > Sub > Sub-Sub
     */
    private function buildHierarchicalStructureForVerification($allData)
    {
        // Convert to array for easier manipulation
        $dataArray = $allData->toArray();

        // Find root items (items where id = id_parent)
        $rootItems = [];
        foreach ($dataArray as $item) {
            if ($item->id == $item->id_parent) {
                $rootItems[] = $item;
            }
        }

        // Build hierarchy for each root item
        $result = [];
        foreach ($rootItems as $root) {
            $hierarchyItem = $this->buildItemHierarchyForVerification($root, $dataArray, 0);
            if ($hierarchyItem) {
                $result[] = $hierarchyItem;
            }
        }

        return $result;
    }

    /**
     * Recursively build hierarchy for a single item (verification version)
     */
    private function buildItemHierarchyForVerification($item, $allData, $level = 0)
    {
        // Add uploaded files for this item (read-only)
        $item->uploadedFiles = \App\Models\DataDukung::where('id_jenis_temuan', $item->id)->get();

        // Find children of this item
        $children = [];
        foreach ($allData as $potentialChild) {
            // Child is an item where id_parent points to current item's id
            // but id != id_parent (not a root item)
            if ($potentialChild->id_parent == $item->id && $potentialChild->id != $potentialChild->id_parent) {
                $childHierarchy = $this->buildItemHierarchyForVerification($potentialChild, $allData, $level + 1);
                if ($childHierarchy) {
                    $children[] = $childHierarchy;
                }
            }
        }

        // Create hierarchy object
        $hierarchyItem = (object) [
            'id' => $item->id,
            'kode_temuan' => $item->kode_temuan ?? null,
            'nama_temuan' => $item->nama_temuan ?? null,
            'rekomendasi' => $item->rekomendasi ?? null,
            'kode_rekomendasi' => $item->kode_rekomendasi ?? null,
            'keterangan' => $item->keterangan ?? null,
            'pengembalian' => $item->pengembalian ?? 0,
            'level' => $level,
            'uploadedFiles' => $item->uploadedFiles,
            'children' => $children
        ];

        return $hierarchyItem;
    }
}
