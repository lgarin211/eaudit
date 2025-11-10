<?php

namespace App\Http\Controllers\OpdTL;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Pengawasan;
use App\Models\Jenis_temuan;
use App\Models\DataDukung;
use App\Models\DataDukungRekom;
use App\Models\User;
use App\Models\UserDataAccess;

class OpdTLController extends Controller
{
    /**
     * Display dashboard for OpdTL users
     */
    public function index()
    {
        return view('OpdTL.index');
    }

    /**
     * Display Menu A1 - Data Dukung Rekomendasi (Read Only)
     */
    public function menuA1()
    {
        try {
            // Get current user's data access configuration
            $currentUser = auth()->user();
            $userDataAccess = UserDataAccess::where('user_id', $currentUser->id)->first();

            // Get data from API
            $client = new Client();
            $token = session('ctoken');
            $url = "http://127.0.0.1:8000/api/rekom?token=" . $token;
            $response = $client->request('GET', $url);
            $content = $response->getBody()->getContents();
            $contentArray = json_decode($content, true);
            $data = $contentArray['data'];

            // Apply data access filtering
            if ($userDataAccess && $userDataAccess->is_active) {
                if ($userDataAccess->access_type === 'specific') {
                    $allowedJenisTemuanIds = $userDataAccess->jenis_temuan_ids ?? [];

                    if (!empty($allowedJenisTemuanIds) && is_array($allowedJenisTemuanIds)) {
                        $filteredData = [];

                        foreach ($data as $item) {
                            $hasAllowedJenisTemuan = DB::table('jenis_temuans')
                                ->where('id_pengawasan', $item['id'] ?? 0)
                                ->whereIn('id', $allowedJenisTemuanIds)
                                ->exists();

                            if ($hasAllowedJenisTemuan) {
                                $filteredData[] = $item;
                            }
                        }

                        $data = $filteredData;
                    } else {
                        $data = [];
                    }
                }
            } else {
                $data = [];
            }

            $data['data'] = $data;
            // dd($data);
            return view('OpdTL.menu_a1', ['data' => $data]);

        } catch (\Exception $e) {
            Log::error('Error in OpdTL menuA1:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return view('OpdTL.menu_a1', ['data' => ['data' => []]]);
        }
    }

    /**
     * Display Menu A1 Detail - Read Only with Upload Only
     */
    public function menuA1Detail($id)
    {
        try {
            // Get current user's data access configuration
            $currentUser = auth()->user();
            $userDataAccess = UserDataAccess::where('user_id', $currentUser->id)->first();

            $token = session('ctoken');
            $pengawasan = Http::get("http://127.0.0.1:8000/api/pengawasan-edit/$id", ['token' => $token])['data'];

            // Get uploaded files from database
            $uploadedFiles = DataDukung::where('id_pengawasan', $id)->get();

            // Start with base query
            $query = DB::table('jenis_temuans')
                ->where('id_parent', DB::raw('id'))
                ->where('id_pengawasan', $id);

            // Apply data access filtering
            if ($userDataAccess && $userDataAccess->is_active) {
                if ($userDataAccess->access_type === 'specific') {
                    $allowedJenisTemuanIds = $userDataAccess->jenis_temuan_ids ?? [];

                    if (!empty($allowedJenisTemuanIds) && is_array($allowedJenisTemuanIds)) {
                        $query->whereIn('id', $allowedJenisTemuanIds);
                    } else {
                        $query->whereRaw('1=0'); // Force empty result
                    }
                }
            } else {
                $query->whereRaw('1=0'); // Force empty result
            }

            $getparent = $query->get();

            // Build hierarchy for allowed data only
            foreach ($getparent as $key => $value) {
                $subQuery = DB::table('jenis_temuans')
                    ->where('id_parent', $value->id)
                    ->where('id', '!=', $value->id);

                // Apply same filtering to sub-items
                if ($userDataAccess && $userDataAccess->is_active && $userDataAccess->access_type === 'specific') {
                    $allowedJenisTemuanIds = $userDataAccess->jenis_temuan_ids ?? [];
                    if (!empty($allowedJenisTemuanIds) && is_array($allowedJenisTemuanIds)) {
                        $subQuery->whereIn('id', $allowedJenisTemuanIds);
                    }
                }

                $value->sub = $subQuery->get();

                // Build nested hierarchy for sub-items
                foreach ($value->sub as $subKey => $subValue) {
                    $nestedQuery = DB::table('jenis_temuans')
                        ->where('id_parent', $subValue->id)
                        ->where('id', '!=', $subValue->id);

                    if ($userDataAccess && $userDataAccess->is_active && $userDataAccess->access_type === 'specific') {
                        $allowedJenisTemuanIds = $userDataAccess->jenis_temuan_ids ?? [];
                        if (!empty($allowedJenisTemuanIds) && is_array($allowedJenisTemuanIds)) {
                            $nestedQuery->whereIn('id', $allowedJenisTemuanIds);
                        }
                    }

                    $subValue->sub = $nestedQuery->get();
                }
            }

            // dd($getparent);
            return view('OpdTL.menu_a1_detail', [
                'pengawasan' => $pengawasan,
                'uploadedFiles' => $uploadedFiles,
                'data' => $getparent
            ]);

        } catch (\Exception $e) {
            Log::error('Error in OpdTL menuA1Detail:', [
                'error' => $e->getMessage(),
                'id' => $id,
                'user_id' => auth()->id()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data');
        }
    }

    /**
     * Display Menu A2 - Data Dukung Rekomendasi List (Read Only)
     */
    public function menuA2()
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

            // dd($data);

            // Apply data access filtering
            if ($userDataAccess && $userDataAccess->is_active) {
                if ($userDataAccess->access_type === 'specific') {
                    $allowedJenisTemuanIds = $userDataAccess->jenis_temuan_ids ?? [];

                    if (!empty($allowedJenisTemuanIds) && is_array($allowedJenisTemuanIds)) {
                        $filteredData = [];

                        foreach ($data as $item) {
                            // Check if this pengawasan has any jenis_temuan that user has access to
                            $hasAllowedJenisTemuan = DB::table('jenis_temuans')
                                ->where('id_pengawasan', $item['id'] ?? 0)
                                ->whereIn('id', $allowedJenisTemuanIds)
                                ->exists();

                            if ($hasAllowedJenisTemuan) {
                                $filteredData[] = $item;
                            }
                        }

                        $data = $filteredData;
                    } else {
                        $data = [];
                    }
                }
            } else {
                $data = [];
            }

            // dd($data);

            return view('OpdTL.menu_a2', ['data' => $data]);

        } catch (\Exception $e) {
            Log::error('Error in OpdTL menuA2:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return view('OpdTL.menu_a2', ['data' => []]);
        }
    }

    /**
     * Display Menu A2 Detail - Read Only Detail View
     */
    public function menuA2Detail($id)
    {
        try {
            // Get current user's data access configuration
            $currentUser = auth()->user();
            $userDataAccess = UserDataAccess::where('user_id', $currentUser->id)->first();

            // Check if user has access to this specific data
            if ($userDataAccess && $userDataAccess->is_active && $userDataAccess->access_type === 'specific') {
                $allowedJenisTemuanIds = $userDataAccess->jenis_temuan_ids ?? [];

                if (!empty($allowedJenisTemuanIds) && is_array($allowedJenisTemuanIds)) {
                    $hasAccess = DB::table('jenis_temuans')
                        ->where('id_pengawasan', $id)
                        ->whereIn('id', $allowedJenisTemuanIds)
                        ->exists();

                    if (!$hasAccess) {
                        return redirect()->route('opdTL.menuA2')->with('error', 'Anda tidak memiliki akses untuk melihat data ini.');
                    }
                } else {
                    return redirect()->route('opdTL.menuA2')->with('error', 'Anda tidak memiliki akses untuk melihat data ini.');
                }
            }

            $token = session('ctoken');
            $pengawasan = Http::get("http://127.0.0.1:8000/api/pengawasan-edit/$id", ['token' => $token])['data'];

            // Get uploaded files from database
            $uploadedFiles = DataDukung::where('id_pengawasan', $id)->get();

            // Start with base query for allowed data only
            $query = DB::table('jenis_temuans')
                ->where('id_parent', DB::raw('id'))
                ->where('id_pengawasan', $id);

            // Apply data access filtering
            if ($userDataAccess && $userDataAccess->is_active && $userDataAccess->access_type === 'specific') {
                $allowedJenisTemuanIds = $userDataAccess->jenis_temuan_ids ?? [];
                if (!empty($allowedJenisTemuanIds) && is_array($allowedJenisTemuanIds)) {
                    $query->whereIn('id', $allowedJenisTemuanIds);
                } else {
                    $query->whereRaw('1=0'); // Force empty result
                }
            }

            $getparent = $query->get();

            // Build hierarchy for allowed data only
            foreach ($getparent as $key => $value) {
                $subQuery = DB::table('jenis_temuans')
                    ->where('id_parent', $value->id)
                    ->where('id', '!=', $value->id);

                // Apply same filtering to sub-items
                if ($userDataAccess && $userDataAccess->is_active && $userDataAccess->access_type === 'specific') {
                    $allowedJenisTemuanIds = $userDataAccess->jenis_temuan_ids ?? [];
                    if (!empty($allowedJenisTemuanIds) && is_array($allowedJenisTemuanIds)) {
                        $subQuery->whereIn('id', $allowedJenisTemuanIds);
                    }
                }

                $value->sub = $subQuery->get();

                // Build nested hierarchy for sub-items
                foreach ($value->sub as $subKey => $subValue) {
                    $nestedQuery = DB::table('jenis_temuans')
                        ->where('id_parent', $subValue->id)
                        ->where('id', '!=', $subValue->id);

                    if ($userDataAccess && $userDataAccess->is_active && $userDataAccess->access_type === 'specific') {
                        $allowedJenisTemuanIds = $userDataAccess->jenis_temuan_ids ?? [];
                        if (!empty($allowedJenisTemuanIds) && is_array($allowedJenisTemuanIds)) {
                            $nestedQuery->whereIn('id', $allowedJenisTemuanIds);
                        }
                    }

                    $subValue->sub = $nestedQuery->get();
                }
            }

            return view('OpdTL.menu_a2_detail', [
                'pengawasan' => $pengawasan,
                'uploadedFiles' => $uploadedFiles,
                'data' => $getparent
            ]);

        } catch (\Exception $e) {
            Log::error('Error in OpdTL menuA2Detail:', [
                'error' => $e->getMessage(),
                'id' => $id,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('opdTL.menuA2')->with('error', 'Terjadi kesalahan saat memuat data');
        }
    }

    /**
     * Upload file (only functionality allowed for OpdTL)
     */
    public function uploadFile(Request $request)
    {
        try {
            // Validate file
            $request->validate([
                'file' => 'required|file|max:10240', // Max 10MB
                'id_pengawasan' => 'required',
            ]);

            $file = $request->file('file');

            if (!$file || !$file->isValid()) {
                throw new \Exception('Invalid file uploaded');
            }

            // Check file extension
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'svg', 'zip', 'docx', 'xlsx', 'doc', 'xls', 'ppt', 'pptx'];
            $fileExtension = strtolower($file->getClientOriginalExtension());

            if (!in_array($fileExtension, $allowedExtensions)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File type not allowed: ' . $fileExtension
                ], 400);
            }

            // Generate random filename
            $randomName = uniqid() . '_' . time() . '.' . $fileExtension;

            // Create upload directory
            $uploadPath = 'uploads/data_dukung/' . $request->id_pengawasan;
            $fullUploadPath = public_path($uploadPath);

            if (!file_exists($fullUploadPath)) {
                mkdir($fullUploadPath, 0777, true);
            }

            // Move file
            $file->move($fullUploadPath, $randomName);

            // Save to database
            $dataDukung = DataDukung::create([
                'id_pengawasan' => $request->id_pengawasan,
                'nama_file' => $uploadPath . '/' . $randomName,
            ]);

            // Update status_LHP to 'Di Proses' when file is uploaded
            try {
                DB::table('pengawasans')
                    ->where('id', $request->id_pengawasan)
                    ->update([
                        'status_LHP' => 'Di Proses',
                        'updated_at' => now()
                    ]);

                Log::info('Status force updated to Di Proses for OpdTL upload', [
                    'id_pengawasan' => $request->id_pengawasan,
                    'timestamp' => now()
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to update status for OpdTL', [
                    'id_pengawasan' => $request->id_pengawasan,
                    'error' => $e->getMessage()
                ]);
            }

            Log::info('OpdTL file uploaded successfully', [
                'user_id' => auth()->id(),
                'file_id' => $dataDukung->id,
                'pengawasan_id' => $request->id_pengawasan
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'file_id' => $dataDukung->id,
                'stored_name' => $randomName,
                'path' => $uploadPath . '/' . $randomName
            ]);

        } catch (\Exception $e) {
            Log::error('OpdTL File Upload Error:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display Menu A3 - List Rekomendasi dengan Upload Access (Grouped by Pengawasan)
     */
    public function menuA3()
    {
        try {
            // Get current user's data access configuration
            $currentUser = auth()->user();
            $userDataAccess = UserDataAccess::where('user_id', $currentUser->id)->first();

            // Apply data access filtering to get allowed jenis_temuan IDs
            if (!$userDataAccess || !$userDataAccess->is_active || $userDataAccess->access_type !== 'specific') {
                return view('OpdTL.menu_a3', ['data' => []]);
            }

            $allowedJenisTemuanIds = $userDataAccess->jenis_temuan_ids ?? [];
            if (empty($allowedJenisTemuanIds) || !is_array($allowedJenisTemuanIds)) {
                return view('OpdTL.menu_a3', ['data' => []]);
            }

            // Get pengawasan IDs that contain allowed jenis_temuan with rekomendasi
            $pengawasanIds = DB::table('jenis_temuans')
                ->whereIn('id', $allowedJenisTemuanIds)
                ->where('rekomendasi', '!=', '')
                ->whereNotNull('rekomendasi')
                ->distinct()
                ->pluck('id_pengawasan')
                ->toArray();

            if (empty($pengawasanIds)) {
                return view('OpdTL.menu_a3', ['data' => []]);
            }

            // Get pengawasan data similar to AdminTL verifikasi pattern
            $pengawasanData = DB::table('pengawasans as p')
                ->select(
                    'p.id',
                    'p.id_penugasan',
                    'p.tipe',
                    'p.jenis',
                    'p.wilayah',
                    'p.pemeriksa',
                    'p.status_LHP',
                    'p.created_at',
                    'p.updated_at'
                )
                ->whereIn('p.id', $pengawasanIds)
                ->orderByRaw("CASE
                    WHEN p.status_LHP = 'Di Proses' THEN 1
                    WHEN p.status_LHP = 'Belum Jadi' THEN 2
                    WHEN p.status_LHP = 'Diterima' THEN 3
                    WHEN p.status_LHP = 'Ditolak' THEN 4
                    ELSE 5
                END")
                ->orderBy('p.updated_at', 'desc')
                ->get();

            // Enrich with penugasan info and rekomendasi count
            $enrichedData = [];
            foreach ($pengawasanData as $pengawasan) {
                // Get penugasan info via API
                $penugasanInfo = null;
                try {
                    $token = session('ctoken');
                    if ($token && $pengawasan->id_penugasan) {
                        $response = Http::get("http://127.0.0.1:8000/api/penugasan-edit/{$pengawasan->id_penugasan}", [
                            'token' => $token
                        ]);

                        if ($response->successful()) {
                            $apiData = $response->json();
                            $penugasanInfo = $apiData['data'] ?? null;
                        }
                    }
                } catch (\Exception $e) {
                    Log::warning('Could not fetch penugasan data for ID: ' . $pengawasan->id_penugasan);
                }

                // Count rekomendasi that user has access to in this pengawasan
                $rekomendasiCount = DB::table('jenis_temuans')
                    ->where('id_pengawasan', $pengawasan->id)
                    ->whereIn('id', $allowedJenisTemuanIds)
                    ->where('rekomendasi', '!=', '')
                    ->whereNotNull('rekomendasi')
                    ->count();

                // Count uploaded files for this pengawasan (from user's accessible rekomendasi)
                $fileCount = DB::table('datadukung_rekoms as dr')
                    ->join('jenis_temuans as jt', 'dr.id_jenis_temuan', '=', 'jt.id')
                    ->where('jt.id_pengawasan', $pengawasan->id)
                    ->whereIn('jt.id', $allowedJenisTemuanIds)
                    ->count();

                $enrichedData[] = [
                    'id' => $pengawasan->id,
                    'id_penugasan' => $pengawasan->id_penugasan,
                    'tipe' => $pengawasan->tipe,
                    'jenis' => $pengawasan->jenis,
                    'wilayah' => $pengawasan->wilayah,
                    'pemeriksa' => $pengawasan->pemeriksa,
                    'status_LHP' => $pengawasan->status_LHP,
                    'created_at' => $pengawasan->created_at,
                    'updated_at' => $pengawasan->updated_at,
                    'penugasan_info' => $penugasanInfo,
                    'rekomendasi_count' => $rekomendasiCount,
                    'file_count' => $fileCount
                ];
            }

            return view('OpdTL.menu_a3', ['data' => $enrichedData]);

        } catch (\Exception $e) {
            Log::error('Error in OpdTL menuA3:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return view('OpdTL.menu_a3', ['data' => []]);
        }
    }

    /**
     * Display Menu A3 Detail - Pengawasan Detail with Upload (Pengawasan-based)
     */
    public function menuA3Detail($pengawasanId)
    {
        try {
            // Get current user's data access configuration
            $currentUser = auth()->user();
            $userDataAccess = UserDataAccess::where('user_id', $currentUser->id)->first();

            // Check if user has access
            if (!$userDataAccess || !$userDataAccess->is_active || $userDataAccess->access_type !== 'specific') {
                return redirect()->route('opdTL.menuA3')->with('error', 'Anda tidak memiliki akses untuk melihat data ini.');
            }

            $allowedJenisTemuanIds = $userDataAccess->jenis_temuan_ids ?? [];
            if (empty($allowedJenisTemuanIds) || !is_array($allowedJenisTemuanIds)) {
                return redirect()->route('opdTL.menuA3')->with('error', 'Anda tidak memiliki akses untuk melihat data ini.');
            }

            // Get pengawasan details
            $pengawasan = DB::table('pengawasans')
                ->select(
                    'id',
                    'id_penugasan',
                    'tipe',
                    'jenis',
                    'wilayah',
                    'pemeriksa',
                    'status_LHP',
                    'created_at',
                    'updated_at'
                )
                ->where('id', $pengawasanId)
                ->first();

            if (!$pengawasan) {
                return redirect()->route('opdTL.menuA3')->with('error', 'Pengawasan tidak ditemukan.');
            }

            // Check if user has access to any rekomendasi in this pengawasan
            $accessibleRekomendasi = DB::table('jenis_temuans')
                ->where('id_pengawasan', $pengawasanId)
                ->whereIn('id', $allowedJenisTemuanIds)
                ->where('rekomendasi', '!=', '')
                ->whereNotNull('rekomendasi')
                ->count();

            if ($accessibleRekomendasi === 0) {
                return redirect()->route('opdTL.menuA3')->with('error', 'Anda tidak memiliki akses ke rekomendasi dalam pengawasan ini.');
            }

            // Get penugasan info via API
            $penugasanInfo = null;
            try {
                $token = session('ctoken');
                if ($token && $pengawasan->id_penugasan) {
                    $response = Http::get("http://127.0.0.1:8000/api/penugasan-edit/{$pengawasan->id_penugasan}", [
                        'token' => $token
                    ]);

                    if ($response->successful()) {
                        $apiData = $response->json();
                        $penugasanInfo = $apiData['data'] ?? null;
                    }
                }
            } catch (\Exception $e) {
                Log::warning('Could not fetch penugasan data for ID: ' . $pengawasan->id_penugasan);
            }

            // Get rekomendasi that user has access to in this pengawasan
            $rekomendasiList = DB::table('jenis_temuans')
                ->select(
                    'id',
                    'nama_temuan',
                    'rekomendasi',
                    'kode_temuan'
                )
                ->where('id_pengawasan', $pengawasanId)
                ->whereIn('id', $allowedJenisTemuanIds)
                ->where('rekomendasi', '!=', '')
                ->whereNotNull('rekomendasi')
                ->orderBy('id')
                ->get();

            // Get uploaded files for all accessible rekomendasi in this pengawasan
            $uploadedFiles = DB::table('datadukung_rekoms as dr')
                ->join('jenis_temuans as jt', 'dr.id_jenis_temuan', '=', 'jt.id')
                ->select(
                    'dr.*',
                    'jt.nama_temuan',
                    'jt.kode_temuan'
                )
                ->where('jt.id_pengawasan', $pengawasanId)
                ->whereIn('jt.id', $allowedJenisTemuanIds)
                ->orderBy('dr.created_at', 'desc')
                ->get();

            // Check if upload is allowed (status_LHP is 'Di Proses')
            $allowUpload = ($pengawasan->status_LHP === 'Di Proses');

            return view('OpdTL.menu_a3_detail', [
                'pengawasan' => $pengawasan,
                'penugasanInfo' => $penugasanInfo,
                'rekomendasiList' => $rekomendasiList,
                'uploadedFiles' => $uploadedFiles,
                'allowUpload' => $allowUpload
            ]);

        } catch (\Exception $e) {
            Log::error('Error in OpdTL menuA3Detail:', [
                'error' => $e->getMessage(),
                'pengawasan_id' => $pengawasanId,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('opdTL.menuA3')->with('error', 'Terjadi kesalahan saat memuat data');
        }
    }

    /**
     * Upload file for specific rekomendasi
     */
    public function uploadFileRekomendasi(Request $request)
    {
        try {
            // Validate file and required data
            $request->validate([
                'file' => 'required|file|max:10240', // Max 10MB
                'id_jenis_temuan' => 'required|exists:jenis_temuans,id',
            ]);

            // Check user access to this jenis_temuan
            $currentUser = auth()->user();
            $userDataAccess = UserDataAccess::where('user_id', $currentUser->id)->first();

            if (!$userDataAccess || !$userDataAccess->is_active || $userDataAccess->access_type !== 'specific') {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk mengupload file'
                ], 403);
            }

            $allowedJenisTemuanIds = $userDataAccess->jenis_temuan_ids ?? [];
            if (!in_array($request->id_jenis_temuan, $allowedJenisTemuanIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk mengupload file ke rekomendasi ini'
                ], 403);
            }

            // Check if pengawasan status allows upload
            $jenisTemuan = DB::table('jenis_temuans as jt')
                ->join('pengawasans as p', 'jt.id_pengawasan', '=', 'p.id')
                ->select('p.status_LHP')
                ->where('jt.id', $request->id_jenis_temuan)
                ->first();

            if (!$jenisTemuan || $jenisTemuan->status_LHP !== 'Di Proses') {
                return response()->json([
                    'success' => false,
                    'message' => 'Upload tidak diizinkan. Status LHP bukan "Di Proses"'
                ], 403);
            }

            $file = $request->file('file');

            if (!$file || !$file->isValid()) {
                throw new \Exception('Invalid file uploaded');
            }

            // Check file extension
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'svg', 'zip', 'docx', 'xlsx', 'doc', 'xls', 'ppt', 'pptx'];
            $fileExtension = strtolower($file->getClientOriginalExtension());

            if (!in_array($fileExtension, $allowedExtensions)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File type not allowed: ' . $fileExtension
                ], 400);
            }

            // Generate random filename
            $randomName = uniqid() . '_' . time() . '.' . $fileExtension;

            // Create upload directory
            $uploadPath = 'uploads/rekom_files/' . $request->id_jenis_temuan;
            $fullUploadPath = public_path($uploadPath);

            if (!file_exists($fullUploadPath)) {
                mkdir($fullUploadPath, 0777, true);
            }

            // Move file
            $file->move($fullUploadPath, $randomName);

            // Save to database
            $dataDukungRekom = DB::table('datadukung_rekoms')->insert([
                'id_jenis_temuan' => $request->id_jenis_temuan,
                'nama_file' => $uploadPath . '/' . $randomName,
                'original_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getClientMimeType(),
                'uploaded_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Log::info('OpdTL rekomendasi file uploaded successfully', [
                'user_id' => auth()->id(),
                'jenis_temuan_id' => $request->id_jenis_temuan,
                'file_name' => $randomName
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'stored_name' => $randomName,
                'path' => $uploadPath . '/' . $randomName
            ]);

        } catch (\Exception $e) {
            Log::error('OpdTL Rekomendasi File Upload Error:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete uploaded file for rekomendasi
     */
    public function deleteFileRekomendasi(Request $request)
    {
        try {
            $request->validate([
                'file_id' => 'required|exists:datadukung_rekoms,id',
            ]);

            // Get file info and check access
            $fileRecord = DB::table('datadukung_rekoms')->where('id', $request->file_id)->first();

            if (!$fileRecord) {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak ditemukan'
                ], 404);
            }

            // Check user access
            $currentUser = auth()->user();
            $userDataAccess = UserDataAccess::where('user_id', $currentUser->id)->first();

            if (!$userDataAccess || !$userDataAccess->is_active || $userDataAccess->access_type !== 'specific') {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk menghapus file'
                ], 403);
            }

            $allowedJenisTemuanIds = $userDataAccess->jenis_temuan_ids ?? [];
            if (!in_array($fileRecord->id_jenis_temuan, $allowedJenisTemuanIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk menghapus file ini'
                ], 403);
            }

            // Delete physical file
            $filePath = public_path($fileRecord->nama_file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete from database
            DB::table('datadukung_rekoms')->where('id', $request->file_id)->delete();

            Log::info('OpdTL rekomendasi file deleted successfully', [
                'user_id' => auth()->id(),
                'file_id' => $request->file_id,
                'jenis_temuan_id' => $fileRecord->id_jenis_temuan
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('OpdTL Rekomendasi File Delete Error:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Delete failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
