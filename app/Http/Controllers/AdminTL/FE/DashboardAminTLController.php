<?php

namespace App\Http\Controllers\AdminTL\FE;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Pengawasan;
use App\Models\Jenis_temuan;
use App\Models\DataDukung;
use App\Models\User;
use App\Models\UserDataAccess;

class DashboardAminTLController extends Controller
{
    /**
     * Update pengawasan status to 'Di Proses' with forced timestamp update
     */
    private function updateStatusToDiProses($id_pengawasan, $context = 'file upload')
    {
        try {
            $pengawasan = Pengawasan::find($id_pengawasan);
            if (!$pengawasan) {
                Log::error('Pengawasan not found for status update', [
                    'id_pengawasan' => $id_pengawasan,
                    'context' => $context
                ]);
                return false;
            }

            $currentStatus = $pengawasan->status_LHP;

            // Force update using direct DB query to ensure timestamp update
            $updated = DB::table('pengawasans')
                ->where('id', $id_pengawasan)
                ->update([
                    'status_LHP' => 'Di Proses',
                    'updated_at' => now()
                ]);

            if ($updated) {
                Log::info('Status successfully updated to Di Proses', [
                    'id_pengawasan' => $id_pengawasan,
                    'previous_status' => $currentStatus,
                    'context' => $context,
                    'timestamp' => now()
                ]);
                return true;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Failed to update status to Di Proses', [
                'id_pengawasan' => $id_pengawasan,
                'context' => $context,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function index()
    {
        return view('adminTL.index');
    }


    public function pkpt(Request $request)
    {
        $client = new Client();
        $token = session('ctoken');
        $url = "http://127.0.0.1:8000/api/penugasanArsip?token=" . $token;
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        $data['data'] = $data;

        $url2 = "http://127.0.0.1:8000/api/pengawasan?token=" . $token;
        $response = $client->request('GET', $url2);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data2 = $contentArray['data'];

        $datanew = $data2;


        return view('adminTL.pkpt', ['data' => $data, 'datanew' => $datanew]);
    }

    public function pkptedit($id)
    {
        $token = session('ctoken');
        $pengawasan = Http::get("http://127.0.0.1:8000/api/pengawasan-edit/$id", ['token' => $token])['data'];
        return view('adminTL.pkpt_edit', compact('pengawasan'));
    }

    public function arsipCari(Request $request)
    {
        $params = $request->except(['_token', '_method']);
        $filteredParams = array_filter($params, function ($value) {
            return !is_null($value) && $value !== '';
        });

        // dd($filteredParams);

        // Query langsung ke database sesuai pola arsipobrik
        $query = DB::table('v_demo3');

        // Filter bulan jika ada
        if ($request->has('tanggalAwalPenugasan') && !empty($request->tanggalAwalPenugasan)) {
            $query->whereRaw('MONTH(tanggalAwalPenugasan) = ?', [$request->tanggalAwalPenugasan]);
        }

        // Filter Tahun jika ada
        if ($request->has('tanggalAwalPenugasan_tahun') && !empty($request->tanggalAwalPenugasan_tahun)) {
            $query->whereRaw('YEAR(tanggalAwalPenugasan) = ?', [$request->tanggalAwalPenugasan_tahun]);
        }

        // Filter lain
        foreach ($filteredParams as $key => $value) {
            if (($key !== 'tanggalAwalPenugasan') && ($key !== 'tanggalAwalPenugasan_tahun')) {
                $query->where($key, 'LIKE', '%' . $value . '%');
            }
        }

        $penugasan = $query->orderBy('tanggalAwalPenugasan', 'DESC')
            ->orderBy('noSurat', 'DESC')
            ->get()->toArray();

        foreach ($penugasan as $key => $st) {
            # code...
            $st->detail_petugas = json_decode($st->detail_petugas);
        }
        $penugasan['data'] = $penugasan;


        // Kirim data ke view
        // return view('admin.arsip_cari', ['data' =>$penugasan]);
        return response()->json(['data' => $penugasan]);
    }

    public function pkptcreate($id)
    {
        $token = session('ctoken');
        $penugasan = Http::get("http://127.0.0.1:8000/api/penugasan-edit/$id", ['token' => $token])['data'];
        return view('adminTL.pkpt_create', compact('penugasan'));
    }

    public function pkptstore(Request $request, $id)
    {
        $parameter = [
            'id_penugasan' => $request->id_penugasan,
            'tglkeluar' => $request->tglkeluar,
            'tipe' => $request->tipe,
            'jenis' => $request->jenis,
            'wilayah' => $request->wilayah,
            'pemeriksa' => $request->pemeriksa,
            'status_LHP' => 'Belum Jadi'
        ];

        $client = new Client();
        $token = session('ctoken');
        $url = "http://127.0.0.1:8000/api/pengawasan?token=" . $token;
        $response = $client->request('POST', $url, [
            'headers' => ['Content-type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        if ($contentArray['status'] != true) {
            # code...
            $error = $contentArray['data'];
            return redirect()->to('adminTL/pkpt')->withErrors($error)->withInput();
        } else {
            return redirect()->to('adminTL/pkpt')->with("success", "Berhasil Memasukkan Data");
        }


    }

    public function pkptupdate(Request $request, $id)
    {
        $parameter = [
            'tglkeluar' => $request->tglkeluar,
            'tipe' => $request->tipe,
            'jenis' => $request->jenis,
            'wilayah' => $request->wilayah,
            'pemeriksa' => $request->pemeriksa,
        ];

        $client = new Client();
        $token = session('ctoken');
        $url = "http://127.0.0.1:8000/api/pengawasan/$id?token=" . $token;
        $response = $client->request('PUT', $url, [
            'headers' => ['Content-type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        if ($contentArray['status'] != true) {
            # code...
            $error = $contentArray['data'];
            return redirect()->to('adminTL/pkpt')->withErrors($error)->withInput();
        } else {
            return redirect()->to('adminTL/pkpt')->with("success", "Berhasil Update Data");
        }
    }


    public function rekom()
    {
        $client = new Client();
        $token = session('ctoken');
        $url = "http://127.0.0.1:8000/api/rekom?token=" . $token;
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        $data['data'] = $data;

        return view('AdminTL.rekom', ['data' => $data]);
    }

    public function rekomEdit($id)
    {
        $token = session('ctoken');
        $pengawasan = Http::get("http://127.0.0.1:8000/api/pengawasan-edit/$id", ['token' => $token])['data'];

        try {
            $getparent = DB::table('jenis_temuans')
                ->where('id_parent', DB::raw('id'))
                ->where('id_pengawasan', $id)
                ->get();

            foreach ($getparent as $key => $value) {
                $value->sub = DB::table('jenis_temuans')
                    ->where('id_parent', $value->id)
                    ->where('id', '!=', $value->id)
                    ->get();

                foreach ($value->sub as $subKey => $subValue) {
                    $subValue->sub = DB::table('jenis_temuans')
                        ->where('id_parent', $subValue->id)
                        ->where('id', '!=', $subValue->id)
                        ->get();
                }
            }
            return view('AdminTL.rekom_edit', ['pengawasan' => $pengawasan, 'data' => $getparent]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Helper function to clean rupiah formatting (kept for backwards compatibility)
     * @deprecated Use cleanPengembalianValue instead
     */
    private function cleanRupiahFormat($value)
    {
        if (empty($value)) {
            return 0;
        }

        // Remove all non-numeric characters (Rp, spaces, dots, commas, etc.)
        $cleaned = preg_replace('/[^0-9]/', '', $value);

        return $cleaned ?: 0;
    }

    public function rekomStore(Request $request)
    {
        try {
            Log::info('rekomStore called with data:', $request->all());

            // Validate required fields
            $request->validate([
                'id_pengawasan' => 'required',
                'id_penugasan' => 'required',
            ]);

            // Get the tipeA data (could be 'tipeA' for new submissions or 'ubahTipeA' for updates)
            $tipeAData = $request->input('tipeA') ? $request->input('tipeA') : $request->input('ubahTipeA');

            if (!$tipeAData || !is_array($tipeAData)) {
                Log::error('Invalid tipeA data:', ['tipeA' => $tipeAData]);
                return back()->with('error', 'Data rekomendasi tidak valid!');
            }

            Log::info('Processing tipeA data:', ['count' => count($tipeAData)]);

            // IMPORTANT: Delete existing rekomendasi data first to prevent duplicates
            // Only delete data for this specific pengawasan to avoid affecting other data
            Log::info('Deleting existing rekomendasi data', [
                'id_pengawasan' => $request->id_pengawasan,
                'id_penugasan' => $request->id_penugasan
            ]);

            $deletedCount = DB::table('jenis_temuans')
                ->where('id_pengawasan', $request->id_pengawasan)
                ->where('id_penugasan', $request->id_penugasan)
                ->delete();

            Log::info('Existing rekomendasi data deleted', ['count' => $deletedCount]);

            foreach ($tipeAData as $item) {
                // Skip empty items
                if (empty(trim($item['rekomendasi'] ?? ''))) {
                    continue;
                }

                // Insert parent recommendation
                $id_parent = DB::table('jenis_temuans')->insertGetId([
                    'rekomendasi' => trim($item['rekomendasi']),
                    'keterangan' => trim($item['keterangan'] ?? ''),
                    'id_pengawasan' => $request->id_pengawasan,
                    'id_penugasan' => $request->id_penugasan,
                    'pengembalian' => $this->cleanPengembalianValue($item['pengembalian'] ?? '0'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Update parent to reference itself
                DB::table('jenis_temuans')
                    ->where('id', $id_parent)
                    ->update(['id_parent' => $id_parent]);

                // Insert sub-recommendations if they exist
                if (isset($item['sub']) && is_array($item['sub'])) {
                    foreach ($item['sub'] as $subItem) {
                        if (empty(trim($subItem['rekomendasi'] ?? ''))) {
                            continue;
                        }

                        $id_child = DB::table('jenis_temuans')->insertGetId([
                            'id_parent' => $id_parent,
                            'rekomendasi' => trim($subItem['rekomendasi']),
                            'keterangan' => trim($subItem['keterangan'] ?? ''),
                            'id_pengawasan' => $request->id_pengawasan,
                            'id_penugasan' => $request->id_penugasan,
                            'pengembalian' => $this->cleanPengembalianValue($subItem['pengembalian'] ?? '0'),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        // Insert nested sub-recommendations if they exist
                        if (isset($subItem['sub']) && is_array($subItem['sub'])) {
                            foreach ($subItem['sub'] as $nestedSubItem) {
                                if (empty(trim($nestedSubItem['rekomendasi'] ?? ''))) {
                                    continue;
                                }

                                $id_nested_child = DB::table('jenis_temuans')->insertGetId([
                                    'id_parent' => $id_child,
                                    'rekomendasi' => trim($nestedSubItem['rekomendasi']),
                                    'keterangan' => trim($nestedSubItem['keterangan'] ?? ''),
                                    'id_pengawasan' => $request->id_pengawasan,
                                    'id_penugasan' => $request->id_penugasan,
                                    'pengembalian' => $this->cleanPengembalianValue($nestedSubItem['pengembalian'] ?? '0'),
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);

                                // Insert level 4 (sub-sub-sub) if they exist
                                if (isset($nestedSubItem['sub']) && is_array($nestedSubItem['sub'])) {
                                    foreach ($nestedSubItem['sub'] as $level4Item) {
                                        if (empty(trim($level4Item['rekomendasi'] ?? ''))) {
                                            continue;
                                        }

                                        DB::table('jenis_temuans')->insert([
                                            'id_parent' => $id_nested_child,
                                            'rekomendasi' => trim($level4Item['rekomendasi']),
                                            'keterangan' => trim($level4Item['keterangan'] ?? ''),
                                            'id_pengawasan' => $request->id_pengawasan,
                                            'id_penugasan' => $request->id_penugasan,
                                            'pengembalian' => $this->cleanPengembalianValue($level4Item['pengembalian'] ?? '0'),
                                            'created_at' => now(),
                                            'updated_at' => now(),
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            Log::info('rekomStore completed successfully');
            return back()->with('success', 'Data berhasil disimpan!');

        } catch (\Exception $e) {
            Log::error('Error storing rekomendasi:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Replace all recommendations for a pengawasan (for bulk operations)
     */
    public function replaceAllRekomendasi(Request $request)
    {
        try {
            Log::info('replaceAllRekomendasi called with data:', $request->all());

            // Delete existing recommendations for this pengawasan (only for bulk replace)
            $deletedRows = DB::table('jenis_temuans')->where('id_pengawasan', $request->id_pengawasan)->delete();
            Log::info('Deleted existing rows for bulk replace:', ['count' => $deletedRows]);

            // Get the tipeA data (could be 'tipeA' for new submissions or 'ubahTipeA' for updates)
            $tipeAData = $request->input('tipeA') ? $request->input('tipeA') : $request->input('ubahTipeA');

            if (!$tipeAData || !is_array($tipeAData)) {
                Log::error('Invalid tipeA data for bulk replace:', ['tipeA' => $tipeAData]);
                return back()->with('error', 'Data rekomendasi tidak valid!');
            }

            Log::info('Processing tipeA data for bulk replace:', ['count' => count($tipeAData)]);

            foreach ($tipeAData as $item) {
                // Insert parent recommendation
                $id_parent = DB::table('jenis_temuans')->insertGetId([
                    'rekomendasi' => $item['rekomendasi'],
                    'keterangan' => $item['keterangan'],
                    'id_pengawasan' => $request->id_pengawasan,
                    'id_penugasan' => $request->id_penugasan,
                    'pengembalian' => str_replace('.', '', $item['pengembalian']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Update parent to reference itself
                DB::table('jenis_temuans')
                    ->where('id', $id_parent)
                    ->update(['id_parent' => $id_parent]);

                // Insert sub-recommendations if they exist
                if (isset($item['sub']) && is_array($item['sub'])) {
                    foreach ($item['sub'] as $subItem) {
                        $id_child = DB::table('jenis_temuans')->insertGetId([
                            'id_parent' => $id_parent,
                            'rekomendasi' => $subItem['rekomendasi'],
                            'keterangan' => $subItem['keterangan'],
                            'id_pengawasan' => $request->id_pengawasan,
                            'id_penugasan' => $request->id_penugasan,
                            'pengembalian' => str_replace('.', '', $subItem['pengembalian']),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        // Insert nested sub-recommendations if they exist
                        if (isset($subItem['sub']) && is_array($subItem['sub'])) {
                            foreach ($subItem['sub'] as $nestedSubItem) {
                                DB::table('jenis_temuans')->insert([
                                    'id_parent' => $id_child,
                                    'rekomendasi' => $nestedSubItem['rekomendasi'],
                                    'keterangan' => $nestedSubItem['keterangan'],
                                    'id_pengawasan' => $request->id_pengawasan,
                                    'id_penugasan' => $request->id_penugasan,
                                    'pengembalian' => str_replace('.', '', $nestedSubItem['pengembalian']),
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            }
                        }
                    }
                }
            }

            return back()->with('success', 'Semua rekomendasi berhasil diganti!');

        } catch (\Exception $e) {
            Log::error('Error replacing all rekomendasi:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat mengganti data: ' . $e->getMessage());
        }
    }

    public function temurekom()
    {
        try {
            // Get current user's data access configuration
            $currentUser = auth()->user();
            $userDataAccess = UserDataAccess::where('user_id', $currentUser->id)->first();

            // Get data from API
            $client = new Client();
            $token = session('ctoken');
            $url = "http://127.0.0.1:8000/api/temuan?token=" . $token;
            $response = $client->request('GET', $url);
            $content = $response->getBody()->getContents();
            $contentArray = json_decode($content, true);
            $data = $contentArray['data'];

            // Apply data access filtering if user has restrictions
            if ($userDataAccess && $userDataAccess->is_active) {
                if ($userDataAccess->access_type === 'specific') {
                    // User has restricted access - filter data
                    $allowedJenisTemuanIds = $userDataAccess->jenis_temuan_ids ?? [];

                    if (!empty($allowedJenisTemuanIds) && is_array($allowedJenisTemuanIds)) {
                        // Filter the data to only show allowed jenis_temuan
                        $filteredData = [];

                        foreach ($data as $item) {
                            // Check if this item's related jenis_temuan is in the allowed list
                            // We need to check if there are any jenis_temuan records for this pengawasan
                            // that match the user's allowed IDs
                            $hasAllowedJenisTemuan = DB::table('jenis_temuans')
                                ->where('id_pengawasan', $item['id'] ?? 0)
                                ->whereIn('id', $allowedJenisTemuanIds)
                                ->exists();

                            if ($hasAllowedJenisTemuan) {
                                $filteredData[] = $item;
                            }
                        }

                        $data = $filteredData;

                        Log::info('Data filtered for user access', [
                            'user_id' => $currentUser->id,
                            'allowed_ids' => $allowedJenisTemuanIds,
                            'original_count' => count($contentArray['data']),
                            'filtered_count' => count($data)
                        ]);
                    } else {
                        // No allowed IDs specified - show empty result
                        $data = [];
                        Log::info('No data shown - user has no allowed jenis temuan IDs', [
                            'user_id' => $currentUser->id
                        ]);
                    }
                }
                // If access_type is 'all', show all data (no filtering)
            } else {
                // User has no data access configuration or inactive - restrict all access
                $data = [];
                Log::info('No data shown - user has no active data access configuration', [
                    'user_id' => $currentUser->id
                ]);
            }

            $data['data'] = $data;
            return view('AdminTL.temuan_rekom', ['data' => $data]);

        } catch (\Exception $e) {
            Log::error('Error in temurekom with data access filtering:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            // In case of error, show empty data for security
            return view('AdminTL.temuan_rekom', ['data' => ['data' => []]]);
        }
    }

    public function temuanStore(Request $request)
    {
        // Debug logging
        Log::info('temuanStore Called', [
            'has_add_new_records' => $request->has('add_new_records'),
            'add_new_records_value' => $request->get('add_new_records'),
            'request_keys' => array_keys($request->all())
        ]);

        // Check if this is from modal add new record
        if ($request->has('add_new_records')) {
            Log::info('Routing to handleModalAddRecord');
            return $this->handleModalAddRecord($request);
        }

        Log::info('Processing regular form submission');

        $data = $request->all();

        // Debug: Log request data (only in development)
        if (config('app.debug')) {
            Log::info('Temuan Store Request Data:', $data);
        }

        // Get temuan data from either 'tipeB' (hierarchy component) or 'temuan' (old format)
        $temuanData = null;
        if (isset($data['tipeB']) && is_array($data['tipeB'])) {
            $temuanData = $data['tipeB'];
            Log::info('Using tipeB data format');
        } elseif (isset($data['temuan']) && is_array($data['temuan'])) {
            $temuanData = $data['temuan'];
            Log::info('Using temuan data format');
        } else {
            // Use proper URL for redirect - fallback to back() if id_pengawasan is not available
            if (isset($data['id_pengawasan'])) {
                $redirectUrl = url("adminTL/temuan_rekom_edit/{$data['id_pengawasan']}/edit");
                return redirect()->to($redirectUrl)->with('error', 'Format data temuan tidak valid!');
            } else {
                return redirect()->back()->with('error', 'Format data temuan tidak valid!');
            }
        }

        // Validate required fields
        $request->validate([
            'id_pengawasan' => 'required',
            'id_penugasan' => 'required',
        ], [
            'id_pengawasan.required' => 'ID pengawasan harus diisi',
            'id_penugasan.required' => 'ID penugasan harus diisi',
        ]);

        try {
            // Use database transaction to ensure data integrity
            // If any error occurs, all changes will be rolled back
            Log::info('Starting database transaction for temuan data save');

            $savedCount = DB::transaction(function () use ($data, $temuanData) {
                // IMPORTANT: Delete existing data first to prevent duplicates
                // Only delete data for this specific pengawasan to avoid affecting other data
                Log::info('Deleting existing temuan data', [
                    'id_pengawasan' => $data['id_pengawasan'],
                    'id_penugasan' => $data['id_penugasan']
                ]);

                $deletedCount = DB::table('jenis_temuans')
                    ->where('id_pengawasan', $data['id_pengawasan'])
                    ->where('id_penugasan', $data['id_penugasan'])
                    ->delete();

                Log::info('Existing data deleted', ['count' => $deletedCount]);

                $savedCount = 0;

                foreach ($temuanData as $temuanIndex => $temuan) {
                    // Skip completely empty temuan entries
                    if (empty(trim($temuan['nama_temuan'] ?? '')) && empty(trim($temuan['kode_temuan'] ?? ''))) {
                        continue;
                    }

                    // Process main temuan item
                    $processedCount = $this->processTemuanItem(
                        $temuan,
                        $data['id_pengawasan'],
                        $data['id_penugasan']
                    );

                    $savedCount += $processedCount;

                    Log::info('Processed temuan item', [
                        'index' => $temuanIndex,
                        'kode_temuan' => $temuan['kode_temuan'] ?? '',
                        'processed_count' => $processedCount
                    ]);
                }

                Log::info('Transaction completed successfully', ['total_saved' => $savedCount]);
                return $savedCount;
            });

            if ($savedCount === 0) {
                if (isset($data['id_pengawasan'])) {
                    $redirectUrl = url("adminTL/temuan_rekom_edit/{$data['id_pengawasan']}/edit");
                    return redirect()->to($redirectUrl)->with('error', 'Tidak ada data yang disimpan. Pastikan semua field terisi dengan benar!');
                } else {
                    return redirect()->back()->with('error', 'Tidak ada data yang disimpan. Pastikan semua field terisi dengan benar!');
                }
            }

            // Ensure redirect stays on the same route with proper URL
            if (isset($data['id_pengawasan'])) {
                $redirectUrl = url("adminTL/temuan_rekom_edit/{$data['id_pengawasan']}/edit");
                return redirect()->to($redirectUrl)->with('success', "Data temuan berhasil disimpan! ($savedCount item tersimpan)");
            } else {
                return redirect()->back()->with('success', "Data temuan berhasil disimpan! ($savedCount item tersimpan)");
            }

        } catch (\Exception $e) {
            Log::error('Temuan Store Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $data ?? null
            ]);
            // Ensure redirect stays on the same route even for errors
            if (isset($data['id_pengawasan'])) {
                $redirectUrl = url("adminTL/temuan_rekom_edit/{$data['id_pengawasan']}/edit");
                return redirect()->to($redirectUrl)->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            } else {
                return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
    }

    /**
     * Handle modal add new record submission
     */
    private function handleModalAddRecord(Request $request)
    {
        try {
            // Debug logging
            Log::info('Modal Add Record Called', [
                'request_data' => $request->all(),
                'has_add_new_records' => $request->has('add_new_records'),
                'add_new_records_value' => $request->get('add_new_records')
            ]);

            // Validate modal form data
            $request->validate([
                'id_pengawasan' => 'required',
                'id_penugasan' => 'required',
                'kode_temuan' => 'required|string',
                'records' => 'required|array|min:1',
            ], [
                'records.required' => 'Minimal harus ada satu rekomendasi yang diisi',
                'records.min' => 'Minimal harus ada satu rekomendasi yang diisi',
            ]);

            $data = $request->all();
            $savedCount = 0;

            // Get temuan data from request
            $kodeTemuan = $data['kode_temuan'];

            // Find nama temuan from existing data
            $namaTemuan = '';
            $pengawasan = Pengawasan::find($data['id_pengawasan']);
            if ($pengawasan && $pengawasan->id_penugasan == $data['id_penugasan']) {
                // Get nama temuan from first recommendation in the same kode_temuan group
                $existingRekom = Jenis_temuan::where('id_pengawasan', $data['id_pengawasan'])
                    ->where('id_penugasan', $data['id_penugasan'])
                    ->where('kode_temuan', $kodeTemuan)
                    ->first();

                if ($existingRekom) {
                    $namaTemuan = $existingRekom->nama_temuan;
                }
            }

            if (empty($namaTemuan)) {
                if (isset($data['id_pengawasan'])) {
                    $redirectUrl = url("adminTL/temuan_rekom_edit/{$data['id_pengawasan']}/edit");
                    return redirect()->to($redirectUrl)->with('error', 'Data temuan tidak ditemukan!');
                } else {
                    return redirect()->back()->with('error', 'Data temuan tidak ditemukan!');
                }
            }

            // Use database transaction to ensure data integrity for modal records
            Log::info('Starting database transaction for modal record save');

            $savedCount = DB::transaction(function () use ($data, $namaTemuan, $kodeTemuan) {
                $savedCount = 0;

                // Process each record from modal
                foreach ($data['records'] as $recordIndex => $record) {
                    // Skip empty records
                    if (empty(trim($record['rekomendasi'] ?? ''))) {
                        continue;
                    }

                    // Save main recommendation
                    $mainRekom = $this->saveRekomendasi(
                        $record,
                        $data['id_pengawasan'],
                        $data['id_penugasan'],
                        $namaTemuan,
                        $kodeTemuan,
                        null // no parent
                    );

                    if ($mainRekom) {
                        $savedCount++;
                        Log::info('Modal record saved', ['record_index' => $recordIndex, 'main_id' => $mainRekom->id]);

                        // Process sub-recommendations if any
                        if (isset($record['sub']) && is_array($record['sub'])) {
                            foreach ($record['sub'] as $subIndex => $subRecord) {
                                if (!empty(trim($subRecord['rekomendasi'] ?? ''))) {
                                    $subRekom = $this->saveRekomendasi(
                                        $subRecord,
                                        $data['id_pengawasan'],
                                        $data['id_penugasan'],
                                        $namaTemuan,
                                        $kodeTemuan,
                                        $mainRekom->id
                                    );
                                    if ($subRekom) {
                                        $savedCount++;
                                        Log::info('Modal sub-record saved', [
                                            'sub_index' => $subIndex,
                                            'sub_id' => $subRekom->id,
                                            'parent_id' => $mainRekom->id
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }

                Log::info('Modal transaction completed successfully', ['total_saved' => $savedCount]);
                return $savedCount;
            });

            if ($savedCount === 0) {
                if (isset($data['id_pengawasan'])) {
                    $redirectUrl = url("adminTL/temuan_rekom_edit/{$data['id_pengawasan']}/edit");
                    return redirect()->to($redirectUrl)->with('error', 'Tidak ada data yang disimpan. Pastikan ada rekomendasi yang diisi!');
                } else {
                    return redirect()->back()->with('error', 'Tidak ada data yang disimpan. Pastikan ada rekomendasi yang diisi!');
                }
            }

            // Ensure redirect stays on the same route with proper URL
            if (isset($data['id_pengawasan'])) {
                $redirectUrl = url("adminTL/temuan_rekom_edit/{$data['id_pengawasan']}/edit");
                return redirect()->to($redirectUrl)->with('success', "Data rekomendasi berhasil ditambahkan! ($savedCount rekomendasi tersimpan)");
            } else {
                return redirect()->back()->with('success', "Data rekomendasi berhasil ditambahkan! ($savedCount rekomendasi tersimpan)");
            }

        } catch (\Exception $e) {
            Log::error('Modal Add Record Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            // Ensure redirect stays on the same route even for errors
            if (isset($data['id_pengawasan'])) {
                $redirectUrl = url("adminTL/temuan_rekom_edit/{$data['id_pengawasan']}/edit");
                return redirect()->to($redirectUrl)->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            } else {
                return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
    }

    /**
     * Save individual recommendation record
     */
    private function saveRekomendasi($rekomData, $id_pengawasan, $id_penugasan, $nama_temuan, $kode_temuan, $parent_id = null)
    {
        // Clean and validate pengembalian value
        $pengembalian = 0;
        if (!empty($rekomData['pengembalian'])) {
            $cleanNumber = preg_replace('/[^0-9,.]/', '', $rekomData['pengembalian']);
            $cleanNumber = str_replace(['.', ','], ['', '.'], $cleanNumber);
            $pengembalian = floatval($cleanNumber);
        }

        $record = Jenis_temuan::create([
            'id_pengawasan' => $id_pengawasan,
            'id_penugasan' => $id_penugasan,
            'nama_temuan' => $nama_temuan,
            'kode_temuan' => $kode_temuan,
            'rekomendasi' => trim($rekomData['rekomendasi']),
            'keterangan' => trim($rekomData['keterangan'] ?? ''),
            'pengembalian' => $pengembalian,
            'id_parent' => $parent_id,
        ]);

        // If this is a parent record (no parent_id), update id_parent to its own id
        if ($parent_id === null && $record) {
            $record->update(['id_parent' => $record->id]);
        }

        return $record;
    }

    /**
     * Process temuan item from hierarchy component format (tipeB)
     */
    private function processTemuanItem($temuan, $id_pengawasan, $id_penugasan)
    {
        $count = 0;

        // Extract basic temuan data (parent level - hanya kode_temuan dan nama_temuan)
        $kode_temuan = trim($temuan['kode_temuan'] ?? '');
        $nama_temuan = trim($temuan['nama_temuan'] ?? '');

        // Debug logging for parent temuan
        Log::info('Processing temuan item (parent level)', [
            'kode_temuan' => $kode_temuan,
            'nama_temuan' => $nama_temuan,
            'has_sub_items' => isset($temuan['sub']) && is_array($temuan['sub'])
        ]);

        // If there's no kode_temuan or nama_temuan, skip this item
        if (empty($kode_temuan) || empty($nama_temuan)) {
            return 0;
        }

        // Create parent temuan record (without rekomendasi data - that goes to child records)
        $parentId = DB::table('jenis_temuans')->insertGetId([
            'id_pengawasan' => $id_pengawasan,
            'id_penugasan' => $id_penugasan,
            'nama_temuan' => $nama_temuan,
            'kode_temuan' => $kode_temuan,
            'kode_rekomendasi' => null, // Parent level tidak memiliki kode rekomendasi
            'rekomendasi' => null,      // Parent level tidak memiliki rekomendasi
            'keterangan' => null,       // Parent level tidak memiliki keterangan
            'pengembalian' => 0,        // Parent level tidak memiliki pengembalian
            'id_parent' => null, // Will be updated to self
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Update id_parent to point to itself (this makes it a parent record)
        DB::table('jenis_temuans')
            ->where('id', $parentId)
            ->update(['id_parent' => $parentId]);

        $count++;

        Log::info('Created parent temuan record', [
            'parent_id' => $parentId,
            'kode_temuan' => $kode_temuan,
            'nama_temuan' => $nama_temuan
        ]);

        // Process sub-recommendations (child records dengan kode_rekomendasi)
        if (isset($temuan['sub']) && is_array($temuan['sub'])) {
            foreach ($temuan['sub'] as $subIndex => $subRekom) {
                $count += $this->processSubRekomendasi(
                    $subRekom,
                    $id_pengawasan,
                    $id_penugasan,
                    $nama_temuan,
                    $kode_temuan,
                    $parentId
                );
            }
        }

        return $count;
    }

    /**
     * Process sub-recommendation (hierarchy level 2 and 3)
     */
    private function processSubRekomendasi($subRekom, $id_pengawasan, $id_penugasan, $nama_temuan, $kode_temuan, $parent_id)
    {
        $count = 0;

        $kode_rekomendasi = trim($subRekom['kode_rekomendasi'] ?? '');
        $rekomendasi = trim($subRekom['rekomendasi'] ?? '');
        $keterangan = trim($subRekom['keterangan'] ?? '');
        $pengembalian = $this->cleanPengembalianValue($subRekom['pengembalian'] ?? '0');

        // Skip empty sub-recommendations
        if (empty($rekomendasi)) {
            return 0;
        }

        // Create sub-recommendation record
        $subId = DB::table('jenis_temuans')->insertGetId([
            'id_pengawasan' => $id_pengawasan,
            'id_penugasan' => $id_penugasan,
            'nama_temuan' => $nama_temuan,
            'kode_temuan' => $kode_temuan,
            'kode_rekomendasi' => $kode_rekomendasi,
            'rekomendasi' => $rekomendasi,
            'keterangan' => $keterangan,
            'pengembalian' => $pengembalian,
            'id_parent' => $parent_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $count++;

        // Process nested sub-sub-recommendations if they exist
        if (isset($subRekom['sub']) && is_array($subRekom['sub'])) {
            foreach ($subRekom['sub'] as $nestedRekom) {
                $count += $this->processSubRekomendasi(
                    $nestedRekom,
                    $id_pengawasan,
                    $id_penugasan,
                    $nama_temuan,
                    $kode_temuan,
                    $subId // This sub becomes parent for nested sub-sub
                );
            }
        }

        return $count;
    }

    /**
     * Clean and validate pengembalian value
     */
    private function cleanPengembalianValue($value)
    {
        if (empty($value)) {
            return 0;
        }

        // Remove currency formatting: 1.000.000 -> 1000000
        $cleaned = preg_replace('/[^0-9]/', '', $value);
        return intval($cleaned ?: 0);
    }

    /**
     * Process recommendations recursively to handle nested sub-recommendations
     */
    private function processRekomendasi($rekomendasi, $id_pengawasan, $id_penugasan, $nama_temuan, $kode_temuan, $parent_id = null, $fullData = [])
    {
        $count = 0;

        foreach ($rekomendasi as $rekomIndex => $rekom) {
            // Skip empty recommendations
            if (empty(trim($rekom['rekomendasi'] ?? ''))) {
                continue;
            }

            // Clean and validate pengembalian value
            $pengembalian = $this->cleanPengembalianValue($rekom['pengembalian'] ?? '0');

            // Insert main recommendation first
            $rekomId = DB::table('jenis_temuans')->insertGetId([
                'id_parent' => $parent_id, // Will be updated for top-level items
                'id_penugasan' => $id_penugasan,
                'id_pengawasan' => $id_pengawasan,
                'nama_temuan' => $nama_temuan,
                'kode_temuan' => $kode_temuan,
                'rekomendasi' => trim($rekom['rekomendasi']),
                'pengembalian' => $pengembalian,
                'keterangan' => trim($rekom['keterangan'] ?? ''),
                'kode_rekomendasi' => null,
                'Rawdata' => json_encode($fullData),
                'password' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // If this is a top-level recommendation (parent_id is null),
            // update id_parent to point to itself
            if ($parent_id === null) {
                DB::table('jenis_temuans')
                    ->where('id', $rekomId)
                    ->update(['id_parent' => $rekomId]);
            }

            $count++;

            // Process nested sub-recommendations if they exist
            if (isset($rekom['sub']) && is_array($rekom['sub'])) {
                $count += $this->processRekomendasi(
                    $rekom['sub'],
                    $id_pengawasan,
                    $id_penugasan,
                    $nama_temuan,
                    $kode_temuan,
                    $rekomId, // This recommendation becomes parent for sub-recommendations
                    $fullData
                );
            }
        }

        return $count;
    }

    public function temuanrekomEdit(Request $request, $id)
    {
        $token = session('ctoken');
        $pengawasan = Http::get("http://127.0.0.1:8000/api/pengawasan-edit/$id", ['token' => $token])['data'];

        try {
            // Use the same approach as datadukungrekomEdit method
            $getparent = DB::table('jenis_temuans')
                ->where('id_parent', DB::raw('id'))
                ->where('id_pengawasan', $id)
                ->get();

            foreach ($getparent as $key => $value) {
                $value->sub = DB::table('jenis_temuans')
                    ->where('id_parent', $value->id)
                    ->where('id', '!=', $value->id)
                    ->get();

                foreach ($value->sub as $subKey => $subValue) {
                    $subValue->sub = DB::table('jenis_temuans')
                        ->where('id_parent', $subValue->id)
                        ->where('id', '!=', $subValue->id)
                        ->get();

                    // Get level 4 data (sub-sub-sub)
                    foreach ($subValue->sub as $nestedKey => $nestedValue) {
                        $nestedValue->sub = DB::table('jenis_temuans')
                            ->where('id_parent', $nestedValue->id)
                            ->where('id', '!=', $nestedValue->id)
                            ->get();
                    }
                }
            }

            // Convert to format expected by the temuan component
            $formattedData = [];
            foreach ($getparent as $parentItem) {
                $children = array();

                if (isset($parentItem->sub)) {
                    foreach ($parentItem->sub as $subItem) {
                        $subChildren = array();
                        if (isset($subItem->sub)) {
                            foreach ($subItem->sub as $nestedItem) {
                                $subSubChildren = array();
                                if (isset($nestedItem->sub)) {
                                    foreach ($nestedItem->sub as $subNestedItem) {
                                        $subSubChildren[] = (object) array(
                                            'id' => $subNestedItem->id,
                                            'kode_rekomendasi' => $subNestedItem->kode_rekomendasi,
                                            'rekomendasi' => $subNestedItem->rekomendasi,
                                            'keterangan' => $subNestedItem->keterangan,
                                            'pengembalian' => $subNestedItem->pengembalian,
                                        );
                                    }
                                }

                                $subChildren[] = (object) array(
                                    'id' => $nestedItem->id,
                                    'kode_rekomendasi' => $nestedItem->kode_rekomendasi,
                                    'rekomendasi' => $nestedItem->rekomendasi,
                                    'keterangan' => $nestedItem->keterangan,
                                    'pengembalian' => $nestedItem->pengembalian,
                                    'children' => $subSubChildren
                                );
                            }
                        }

                        $children[] = (object) array(
                            'id' => $subItem->id,
                            'kode_rekomendasi' => $subItem->kode_rekomendasi,
                            'rekomendasi' => $subItem->rekomendasi,
                            'keterangan' => $subItem->keterangan,
                            'pengembalian' => $subItem->pengembalian,
                            'children' => $subChildren
                        );
                    }
                }

                $formattedData[] = (object) array(
                    'id' => $parentItem->id,
                    'kode_temuan' => $parentItem->kode_temuan,
                    'nama_temuan' => $parentItem->nama_temuan,
                    'kode_rekomendasi' => $parentItem->kode_rekomendasi,
                    'rekomendasi' => $parentItem->rekomendasi,
                    'keterangan' => $parentItem->keterangan,
                    'pengembalian' => $parentItem->pengembalian,
                    'recommendations' => $children
                );
            }

            return view('AdminTL.temuan_rekom_edit', [
                'pengawasan' => $pengawasan,
                'existingData' => collect($formattedData)
            ]);

        } catch (\Exception $e) {
            Log::error('Error loading temuan data:', [
                'error' => $e->getMessage(),
                'id_pengawasan' => $id
            ]);

            return view('AdminTL.temuan_rekom_edit', [
                'pengawasan' => $pengawasan,
                'existingData' => collect([])
            ]);
        }
    }

    /**
     * Build recommendation hierarchy from flat array
     */
    private function buildRecommendationHierarchy($recommendations)
    {
        // Create lookup array
        $lookup = [];
        foreach ($recommendations as $item) {
            $lookup[$item->id] = $item;
            $item->children = [];
        }

        // Build hierarchy
        $roots = [];
        foreach ($recommendations as $item) {
            if ($item->id_parent == $item->id) {
                // This is a root item (self-referencing)
                $roots[] = $item;
            } else {
                // This is a child item
                if (isset($lookup[$item->id_parent])) {
                    $lookup[$item->id_parent]->children[] = $item;
                }
            }
        }

        return $roots;
    }

    /**
     * Check if a child item is descendant of a parent item
     */
    private function isDescendantOf($child, $parentId, $allData)
    {
        // Direct child check
        if ($child->id_parent == $parentId) {
            return true;
        }

        // Recursive check for indirect descendants
        $currentParentId = $child->id_parent;
        $visited = []; // Prevent infinite loops

        while ($currentParentId != null && !in_array($currentParentId, $visited)) {
            $visited[] = $currentParentId;

            // Find parent item
            $parentItem = null;
            foreach ($allData as $item) {
                if ($item->id == $currentParentId) {
                    $parentItem = $item;
                    break;
                }
            }

            if (!$parentItem) {
                break; // Parent not found
            }

            // Check if this parent is the target parent
            if ($parentItem->id == $parentId) {
                return true;
            }

            // Check if this parent is a root (id = id_parent)
            if ($parentItem->id == $parentItem->id_parent) {
                break; // Reached root, not a descendant
            }

            // Move to next level up
            $currentParentId = $parentItem->id_parent;
        }

        return false;
    }

    public function indexdatadukungrekom()
    {
        $client = new Client();
        $token = session('ctoken');
        $url = "http://127.0.0.1:8000/api/rekom?token=" . $token;
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        $data['data'] = $data;
        return view('AdminTL.datadukungrekom', ['data' => $data]);
    }

    public function indexdatadukungtemuan()
    {
        $client = new Client();
        $token = session('ctoken');
        $url = "http://127.0.0.1:8000/api/temuan?token=" . $token;
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        $data['data'] = $data;
        return view('AdminTL.datadukungtemuan', ['data' => $data]);
    }

    public function datadukungrekomEdit($id)
    {
        $token = session('ctoken');
        $pengawasan = Http::get("http://127.0.0.1:8000/api/pengawasan-edit/$id", ['token' => $token])['data'];

        try {
            // Ambil semua data dari database
            $allData = DB::table('jenis_temuans')
                ->where('id_pengawasan', $id)
                ->orderBy('id')
                ->get();

            Log::info('Retrieved rekomendasi data from database:', [
                'count' => count($allData),
                'all_data' => $allData->toArray()
            ]);

            // Build hierarchical structure menggunakan method khusus
            $hierarchicalData = $this->buildHierarchicalStructure($allData);

            Log::info('Built hierarchical structure:', [
                'structure_count' => count($hierarchicalData)
            ]);

            return view('AdminTL.datadukungrekom_upload', [
                'pengawasan' => $pengawasan,
                'existingData' => collect($hierarchicalData)
            ]);

        } catch (\Exception $e) {
            Log::error('Error in datadukungrekomEdit:', [
                'error' => $e->getMessage(),
                'id_pengawasan' => $id
            ]);

            return view('AdminTL.datadukungrekom_upload', [
                'pengawasan' => $pengawasan,
                'existingData' => collect([])
            ]);
        }
    }

    /**
     * Build hierarchical structure for rekomendasi data
     * Supports multi-level hierarchy: Parent > Sub > Sub-Sub
     */
    private function buildHierarchicalStructure($allData)
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
            $hierarchyItem = $this->buildItemHierarchy($root, $dataArray, 0);
            if ($hierarchyItem) {
                $result[] = $hierarchyItem;
            }
        }

        return $result;
    }

    /**
     * Recursively build hierarchy for a single item
     */
    private function buildItemHierarchy($item, $allData, $level = 0)
    {
        // Add uploaded files for this item
        $item->uploadedFiles = DataDukung::where('id_jenis_temuan', $item->id)->get();

        // Find children of this item
        $children = [];
        foreach ($allData as $potentialChild) {
            // Child is an item where id_parent points to current item's id
            // but id != id_parent (not a root item)
            if ($potentialChild->id_parent == $item->id && $potentialChild->id != $potentialChild->id_parent) {
                $childHierarchy = $this->buildItemHierarchy($potentialChild, $allData, $level + 1);
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

    public function datadukungtemuanEdit($id)
    {
        $token = session('ctoken');
        $pengawasan = Http::get("http://127.0.0.1:8000/api/pengawasan-edit/$id", ['token' => $token])['data'];

        try {
            // Ambil semua data dari database
            $allData = DB::table('jenis_temuans')
                ->where('id_pengawasan', $id)
                ->orderBy('id')
                ->get();

            Log::info('Retrieved temuan data from database:', [
                'count' => count($allData),
                'all_data' => $allData->toArray()
            ]);

            // Build hierarchical structure menggunakan method khusus
            $hierarchicalData = $this->buildHierarchicalStructure($allData);

            Log::info('Built hierarchical structure for temuan:', [
                'structure_count' => count($hierarchicalData)
            ]);

            return view('AdminTL.datadukungtemuan_upload', [
                'pengawasan' => $pengawasan,
                'existingData' => collect($hierarchicalData)
            ]);

        } catch (\Exception $e) {
            Log::error('Error in datadukungtemuanEdit:', [
                'error' => $e->getMessage(),
                'id_pengawasan' => $id
            ]);

            return view('AdminTL.datadukungtemuan_upload', [
                'pengawasan' => $pengawasan,
                'existingData' => collect([])
            ]);
        }
    }

    /**
     * Update recommendation
     */
    public function updateRekomendasi(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
                'kode_rekomendasi' => 'nullable|string|max:50',
                'rekomendasi' => 'required|string|max:1000',
                'keterangan' => 'nullable|string|max:500',
                'pengembalian' => 'nullable|numeric|min:0'
            ]);

            $updated = DB::table('jenis_temuans')
                ->where('id', $request->id)
                ->update([
                    'kode_rekomendasi' => $request->kode_rekomendasi,
                    'rekomendasi' => $request->rekomendasi,
                    'keterangan' => $request->keterangan,
                    'pengembalian' => $request->pengembalian ?: 0,
                    'updated_at' => now()
                ]);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rekomendasi berhasil diperbarui'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

        } catch (\Exception $e) {
            Log::error('Error updating rekomendasi:', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete recommendation
     */
    public function deleteRekomendasi($id)
    {
        try {
            Log::info('Delete request received for ID: ' . $id);

            // Validate ID
            if (!is_numeric($id) || $id <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID tidak valid'
                ], 400);
            }

            // Check if record exists
            $record = DB::table('jenis_temuans')->where('id', $id)->first();
            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            Log::info('Record found for deletion:', ['record' => $record]);

            // Check if this recommendation has children
            $hasChildren = DB::table('jenis_temuans')
                ->where('id_parent', $id)
                ->where('id', '!=', $id)
                ->exists();

            if ($hasChildren) {
                $childrenCount = DB::table('jenis_temuans')
                    ->where('id_parent', $id)
                    ->where('id', '!=', $id)
                    ->count();

                Log::warning('Cannot delete record with children:', ['id' => $id, 'children_count' => $childrenCount]);

                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus rekomendasi yang memiliki ' . $childrenCount . ' sub-rekomendasi. Hapus sub-rekomendasi terlebih dahulu.'
                ], 400);
            }

            // Perform deletion
            $deleted = DB::table('jenis_temuans')
                ->where('id', $id)
                ->delete();

            if ($deleted) {
                Log::info('Record deleted successfully:', ['id' => $id]);
                return response()->json([
                    'success' => true,
                    'message' => 'Rekomendasi berhasil dihapus'
                ]);
            } else {
                Log::error('Delete operation failed for ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus data'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Error deleting rekomendasi:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'id' => $id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add new sub-recommendation
     */
    public function addSubRekomendasi(Request $request)
    {
        try {
            $request->validate([
                'parent_id' => 'required|integer|exists:jenis_temuans,id',
                'rekomendasi' => 'required|string|max:1000',
                'keterangan' => 'nullable|string|max:500',
                'pengembalian' => 'nullable|numeric|min:0',
                'id_pengawasan' => 'required|integer',
                'id_penugasan' => 'required|integer'
            ]);

            // Check if parent exists
            $parent = DB::table('jenis_temuans')->where('id', $request->parent_id)->first();
            if (!$parent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parent rekomendasi tidak ditemukan'
                ], 404);
            }

            // Insert new sub-recommendation
            $newId = DB::table('jenis_temuans')->insertGetId([
                'id_parent' => $request->parent_id,
                'rekomendasi' => $request->rekomendasi,
                'keterangan' => $request->keterangan,
                'pengembalian' => $request->pengembalian ?: 0,
                'id_pengawasan' => $request->id_pengawasan,
                'id_penugasan' => $request->id_penugasan,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($newId) {
                // Get the newly created record for response
                $newRecord = DB::table('jenis_temuans')->where('id', $newId)->first();

                return response()->json([
                    'success' => true,
                    'message' => 'Sub-rekomendasi berhasil ditambahkan',
                    'data' => $newRecord
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan sub-rekomendasi'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Error adding sub-rekomendasi:', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete main item and all its children (sub and sub-sub items)
     */
    public function deleteMainItem(Request $request)
    {
        try {
            Log::info('Delete main item request received', [
                'request_data' => $request->all()
            ]);

            // Validate request
            $request->validate([
                'item_id' => 'required|integer'
            ]);

            $itemId = $request->item_id;

            // Check if item exists
            $mainItem = DB::table('jenis_temuans')->where('id', $itemId)->first();
            if (!$mainItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item tidak ditemukan'
                ], 404);
            }

            Log::info('Main item found:', ['item' => $mainItem]);

            // Start transaction
            DB::beginTransaction();

            try {
                // Find all children (recursive delete)
                $allChildrenIds = $this->getAllChildrenIds($itemId);
                $allItemsToDelete = array_merge([$itemId], $allChildrenIds);

                Log::info('Items to delete:', [
                    'main_item_id' => $itemId,
                    'children_ids' => $allChildrenIds,
                    'total_items' => count($allItemsToDelete)
                ]);

                // Delete associated files first
                $deletedFiles = 0;
                foreach ($allItemsToDelete as $id) {
                    $files = DB::table('datadukungs')->where('id_jenis_temuan', $id)->get();
                    foreach ($files as $file) {
                        // Delete physical file
                        if (file_exists(public_path($file->nama_file))) {
                            unlink(public_path($file->nama_file));
                        }
                        // Delete file record
                        DB::table('datadukungs')->where('id', $file->id)->delete();
                        $deletedFiles++;
                    }
                }

                // Delete all items (children first, then parent)
                $deletedCount = DB::table('jenis_temuans')
                    ->whereIn('id', $allItemsToDelete)
                    ->delete();

                DB::commit();

                Log::info('Delete operation completed successfully:', [
                    'deleted_items' => $deletedCount,
                    'deleted_files' => $deletedFiles,
                    'main_item_rekomendasi' => $mainItem->rekomendasi ?? 'N/A'
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Item dan semua sub-item berhasil dihapus',
                    'deleted_count' => $deletedCount,
                    'deleted_files' => $deletedFiles
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in deleteMainItem:', [
                'errors' => $e->errors()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error deleting main item:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'item_id' => $request->item_id ?? 'not provided'
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all children IDs recursively
     */
    private function getAllChildrenIds($parentId)
    {
        $children = DB::table('jenis_temuans')
            ->where('id_parent', $parentId)
            ->where('id', '!=', $parentId) // Exclude self-referencing items
            ->get();

        $allChildrenIds = [];

        foreach ($children as $child) {
            $allChildrenIds[] = $child->id;
            // Recursively get children of this child
            $grandChildren = $this->getAllChildrenIds($child->id);
            $allChildrenIds = array_merge($allChildrenIds, $grandChildren);
        }

        return $allChildrenIds;
    }

    /**
     * Delete entire temuan with all its recommendations and sub-recommendations
     */
    public function deleteTemuanWithAllRekomendasi($kode_temuan)
    {
        try {
            Log::info('Delete temuan request received for kode: ' . $kode_temuan);

            // Validate kode_temuan
            if (empty($kode_temuan)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode temuan tidak valid'
                ], 400);
            }

            // Check if temuan exists
            $temuanExists = DB::table('jenis_temuans')
                ->where('kode_temuan', $kode_temuan)
                ->exists();

            if (!$temuanExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Temuan dengan kode "' . $kode_temuan . '" tidak ditemukan'
                ], 404);
            }

            // Get all records related to this temuan (including nested children)
            $allRecords = DB::table('jenis_temuans')
                ->where('kode_temuan', $kode_temuan)
                ->get();

            $recordCount = $allRecords->count();

            Log::info('Found records to delete:', [
                'kode_temuan' => $kode_temuan,
                'total_records' => $recordCount,
                'records' => $allRecords->toArray()
            ]);

            // Start transaction
            DB::beginTransaction();

            try {
                // Delete all records with this kode_temuan
                $deletedCount = DB::table('jenis_temuans')
                    ->where('kode_temuan', $kode_temuan)
                    ->delete();

                if ($deletedCount > 0) {
                    DB::commit();

                    Log::info('Temuan and all recommendations deleted successfully:', [
                        'kode_temuan' => $kode_temuan,
                        'deleted_count' => $deletedCount
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Temuan "' . $kode_temuan . '" beserta ' . $deletedCount . ' rekomendasi berhasil dihapus'
                    ]);
                } else {
                    DB::rollback();
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak ada data yang berhasil dihapus'
                    ], 500);
                }

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Error deleting temuan with all recommendations:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'kode_temuan' => $kode_temuan
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload file with AJAX
     */
    public function uploadFile(Request $request)
    {
        try {
            Log::info('Upload request received', [
                'has_file' => $request->hasFile('file'),
                'id_pengawasan' => $request->id_pengawasan,
                'id_penugasan' => $request->id_penugasan
            ]);

            // Validate file
            $request->validate([
                'file' => 'required|file|max:10240', // Max 10MB
                'id_pengawasan' => 'required',
                'id_penugasan' => 'required',
            ]);

            $file = $request->file('file');

            // Validate file object
            if (!$file || !$file->isValid()) {
                Log::error('Invalid file object', [
                    'file_exists' => $file ? 'yes' : 'no',
                    'is_valid' => $file ? $file->isValid() : 'unknown',
                    'error' => $file ? $file->getError() : 'file is null'
                ]);
                throw new \Exception('Invalid file uploaded');
            }

            Log::info('File validation passed', [
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getClientMimeType()
            ]);

            // Check file extension
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'svg', 'zip', 'docx', 'xlsx', 'doc', 'xls', 'ppt', 'pptx'];
            $fileExtension = strtolower($file->getClientOriginalExtension());

            if (!in_array($fileExtension, $allowedExtensions)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File type not allowed: ' . $fileExtension
                ], 400);
            }

            // Get file information BEFORE moving the file
            $originalName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $fileMimeType = $file->getClientMimeType();

            // Generate random filename
            $randomName = uniqid() . '_' . time() . '.' . $fileExtension;

            // Create upload directory if not exists
            $uploadPath = 'uploads/data_dukung/' . $request->id_pengawasan;
            $fullUploadPath = public_path($uploadPath);

            Log::info('Directory check', [
                'upload_path' => $uploadPath,
                'full_path' => $fullUploadPath,
                'exists' => file_exists($fullUploadPath),
                'public_path' => public_path()
            ]);

            if (!file_exists($fullUploadPath)) {
                if (!mkdir($fullUploadPath, 0777, true)) {
                    throw new \Exception('Failed to create upload directory: ' . $fullUploadPath);
                }
                Log::info('Directory created successfully: ' . $fullUploadPath);
            }

            // Validate directory is writable (skip on Windows as it's often unreliable)
            $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
            if (!$isWindows && !is_writable($fullUploadPath)) {
                throw new \Exception('Upload directory is not writable: ' . $fullUploadPath);
            }

            // Log before move
            Log::info('About to move file', [
                'temp_path' => $file->getPathname(),
                'destination' => $fullUploadPath . '/' . $randomName,
                'temp_exists' => file_exists($file->getPathname())
            ]);

            // Move file to upload directory
            $file->move($fullUploadPath, $randomName);

            // Verify file was moved successfully
            $finalPath = $fullUploadPath . '/' . $randomName;
            if (!file_exists($finalPath)) {
                throw new \Exception('File was not moved successfully to: ' . $finalPath);
            }

            Log::info('File moved successfully', [
                'final_path' => $finalPath,
                'file_size_after_move' => filesize($finalPath)
            ]);

            // Save to database sesuai skema tabel datadukung
            Log::info('Attempting to save to database', [
                'id_pengawasan' => $request->id_pengawasan,
                'nama_file' => $uploadPath . '/' . $randomName
            ]);

            $dataDukung = DataDukung::create([
                'id_pengawasan' => $request->id_pengawasan,
                'nama_file' => $uploadPath . '/' . $randomName, // path file untuk database
            ]);

            Log::info('Database save successful', [
                'id' => $dataDukung->id,
                'created_at' => $dataDukung->created_at
            ]);

            // Log file data
            // Update status_LHP to 'Di Proses' when file is uploaded
            $this->updateStatusToDiProses($request->id_pengawasan, 'global file upload');
            Log::info('File uploaded and saved to database successfully', [
                'id' => $dataDukung->id,
                'id_pengawasan' => $request->id_pengawasan,
                'nama_file' => $uploadPath . '/' . $randomName,
                'original_name' => $originalName,
                'stored_name' => $randomName,
                'file_size' => $fileSize,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'file_id' => $dataDukung->id,
                'stored_name' => $randomName,
                'path' => $uploadPath . '/' . $randomName,
                'size' => $fileSize,
                'original_name' => $originalName,
                'database_id' => $dataDukung->id
            ]);

        } catch (\Exception $e) {
            Log::error('File Upload Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => [
                    'id_pengawasan' => $request->id_pengawasan,
                    'id_penugasan' => $request->id_penugasan,
                    'has_file' => $request->hasFile('file')
                ]
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete uploaded file
     */
    public function deleteFile(Request $request)
    {
        try {
            $request->validate([
                'file_id' => 'required',
            ]);

            // Find file record in database
            $dataDukung = DataDukung::find($request->file_id);

            if (!$dataDukung) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found in database'
                ], 404);
            }

            // Store file info before deletion
            $namaFile = $dataDukung->nama_file;

            // Get file path
            $filePath = public_path($namaFile);

            // Delete physical file if exists
            if (file_exists($filePath)) {
                unlink($filePath);
                Log::info('Physical file deleted: ' . $filePath);
            }

            // Delete from database
            $dataDukung->delete();

            Log::info('File deleted successfully', [
                'file_id' => $request->file_id,
                'nama_file' => $namaFile
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('File Delete Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Delete failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload file for specific rekomendasi
     */
    public function uploadFileRekomendasi(Request $request)
    {
        try {
            Log::info('Upload file rekomendasi request received', [
                'has_file' => $request->hasFile('file'),
                'id_pengawasan' => $request->id_pengawasan,
                'id_jenis_temuan' => $request->id_jenis_temuan
            ]);

            // Validate request
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'file' => 'required|file|max:10240', // Max 10MB
                'id_pengawasan' => 'required',
                'id_jenis_temuan' => 'required',
                'keterangan_file' => 'nullable|string|max:255'
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed', [
                    'errors' => $validator->errors()->toArray()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'The given data was invalid.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $file = $request->file('file');

            if (!$file || !$file->isValid()) {
                throw new \Exception('Invalid file uploaded');
            }

            // Create directory if not exists
            $uploadPath = public_path('uploads/datadukung');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Generate unique filename
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $filepath = 'uploads/datadukung/' . $filename;

            // Move file
            $file->move($uploadPath, $filename);

            // Save to database
            $dataDukung = DataDukung::create([
                'id_pengawasan' => $request->id_pengawasan,
                'id_jenis_temuan' => $request->id_jenis_temuan,
                'nama_file' => $filepath,
                'keterangan_file' => $request->keterangan_file
            ]);

            // Update status_LHP to 'Di Proses' when file is uploaded
            $this->updateStatusToDiProses($request->id_pengawasan, 'rekomendasi file upload');
            Log::info('File uploaded successfully for rekomendasi', [
                'file_id' => $dataDukung->id,
                'original_name' => $originalName,
                'stored_path' => $filepath,
                'id_jenis_temuan' => $request->id_jenis_temuan
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File berhasil diupload',
                'file_id' => $dataDukung->id,
                'stored_name' => $filename,
                'path' => $filepath
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation exception in upload file rekomendasi', [
                'errors' => $e->errors(),
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'The given data was invalid.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Upload file rekomendasi failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete file for specific rekomendasi
     */
    public function deleteFileRekomendasi(Request $request)
    {
        try {
            Log::info('Delete file rekomendasi request received', [
                'file_id' => $request->file_id
            ]);

            // Validate request
            $request->validate([
                'file_id' => 'required|exists:datadukung,id'
            ]);

            $file = DataDukung::findOrFail($request->file_id);

            // Delete physical file
            $filePath = public_path($file->nama_file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete from database
            $file->delete();

            Log::info('File deleted successfully for rekomendasi', [
                'file_id' => $request->file_id,
                'deleted_path' => $file->nama_file
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Delete file rekomendasi failed', [
                'error' => $e->getMessage(),
                'file_id' => $request->file_id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Delete failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
