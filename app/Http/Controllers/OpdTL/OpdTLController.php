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
}
