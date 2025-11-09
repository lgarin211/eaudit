<?php

namespace App\Http\Controllers\AdminTL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jenis_temuan;
use App\Models\Pengawasan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserControlController extends Controller
{
    /**
     * Display list of users - List User menu
     */
    public function listUser()
    {
        try {
            $users = User::with('userDataAccess')
                ->orderBy('name', 'asc')
                ->get();

            return view('AdminTL.user-control.list-user', compact('users'));
        } catch (\Exception $e) {
            Log::error('Error loading user list: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data pengguna.');
        }
    }

    /**
     * Show form for creating new user
     */
    public function createUser()
    {
        return view('AdminTL.user-control.create-user');
    }

    /**
     * Store new user
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,pemeriksa,obrik'
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            // Create default access control (all access)
            DB::table('user_data_access')->insert([
                'user_id' => $user->id,
                'access_type' => 'all',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('admin.user-control.list-user')
                ->with('success', 'Pengguna berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating user: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat pengguna.');
        }
    }

    /**
     * Show form for editing user
     */
    public function editUser($id)
    {
        try {
            $user = User::with('userDataAccess')->findOrFail($id);
            return view('AdminTL.user-control.edit-user', compact('user'));
        } catch (\Exception $e) {
            Log::error('Error loading user for edit: ' . $e->getMessage());
            return redirect()->route('admin.user-control.list-user')
                ->with('error', 'Pengguna tidak ditemukan.');
        }
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,pemeriksa,obrik'
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'name' => $request->name,
                'username' => $request->username,
                'role' => $request->role,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            DB::commit();

            return redirect()->route('admin.user-control.list-user')
                ->with('success', 'Pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating user: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui pengguna.');
        }
    }

    /**
     * Delete user
     */
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);

            // Don't allow deletion of current user
            if ($user->id == auth()->id()) {
                return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri.');
            }

            $user->delete();

            return redirect()->route('admin.user-control.list-user')
                ->with('success', 'Pengguna berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus pengguna.');
        }
    }

    /**
     * Display user data access management - User Data menu
     */
    public function userData()
    {
        try {
            $users = User::with(['userDataAccess'])
                // ->join('user_data_access', 'users.id', '=', 'user_data_access.user_id')
                ->orderBy('name', 'asc')
                ->get();
            // dd($users);

            // Get all jenis temuan and build multi-level hierarchical structure
            $jenisTemuans = Jenis_temuan::orderBy('id_parent')->orderBy('id')->get();

            // Get pengawasan data with penugasan info for display
            $pengawasanData = [];
            $uniquePengawasanIds = $jenisTemuans->pluck('id_pengawasan')->unique();

            foreach ($uniquePengawasanIds as $pengawasanId) {
                $pengawasan = Pengawasan::find($pengawasanId);
                if ($pengawasan) {
                    // Try to get penugasan data via API
                    $penugasanInfo = null;
                    try {
                        $token = session('ctoken');
                        if ($token && $pengawasan->id_penugasan) {
                            $response = \Illuminate\Support\Facades\Http::get("http://127.0.0.1:8000/api/penugasan-edit/{$pengawasan->id_penugasan}", [
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

                    $pengawasanData[$pengawasanId] = [
                        'pengawasan' => $pengawasan,
                        'penugasan_info' => $penugasanInfo,
                        'display_name' => $this->buildDisplayName($pengawasan, $penugasanInfo)
                    ];
                }
            }

            $jenisTemuansHierarchy = [];
            foreach ($jenisTemuans as $item) {
                if ($item->id == $item->id_parent) {
                    // Initialize parent with empty children array
                    $jenisTemuansHierarchy[$item->id_pengawasan][$item->id] = [
                        'parent' => $item,
                        'children' => [],
                        'nama_temuan' => $item->nama_temuan
                    ];
                } else {
                    // Ensure parent exists before adding children
                    if (!isset($jenisTemuansHierarchy[$item->id_pengawasan][$item->id_parent])) {
                        $jenisTemuansHierarchy[$item->id_pengawasan][$item->id_parent] = [
                            'parent' => null,
                            'children' => [],
                            'nama_temuan' => ''
                        ];
                    }
                    
                    // Ensure children is array before adding
                    if (!is_array($jenisTemuansHierarchy[$item->id_pengawasan][$item->id_parent]['children'])) {
                        $jenisTemuansHierarchy[$item->id_pengawasan][$item->id_parent]['children'] = [];
                    }
                    
                    $jenisTemuansHierarchy[$item->id_pengawasan][$item->id_parent]['children'][] = $item;
                }
            }

            // Keep the flat version for compatibility
            $jenisTemuansGrouped = $jenisTemuans->groupBy('id_parent');

            // dd($jenisTemuansHierarchy);

            return view('AdminTL.user-control.user-data', compact('users', 'jenisTemuans', 'jenisTemuansGrouped', 'jenisTemuansHierarchy', 'pengawasanData'));
        } catch (\Exception $e) {
            Log::error('Error loading user data access: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data akses pengguna.');
        }
    }

    /**
     * Update user data access
     */
    public function updateUserDataAccess(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'access_type' => 'required|in:all,specific',
            'pengawasan_ids' => 'nullable|array',
            'pengawasan_ids.*' => 'exists:pengawasans,id',
            'notes' => 'nullable|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            // If specific access, get all jenis_temuan_ids from selected pengawasan
            $jenisTemuanIds = [];
            if ($request->access_type === 'specific' && !empty($request->pengawasan_ids)) {
                $jenisTemuanIds = Jenis_temuan::whereIn('id_pengawasan', $request->pengawasan_ids)
                    ->pluck('id')
                    ->toArray();
            }

            $accessData = [
                'access_type' => $request->access_type,
                'jenis_temuan_ids' => $request->access_type === 'specific' ? json_encode($jenisTemuanIds) : null,
                'notes' => $request->notes,
                'updated_at' => now(),
            ];

            DB::table('user_data_access')
                ->updateOrInsert(
                    ['user_id' => $request->user_id],
                    array_merge($accessData, ['created_at' => now()])
                );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Akses data pengguna berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating user data access: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui akses data pengguna.'
            ]);
        }
    }

    /**
     * Toggle user access status
     */
    public function toggleUserAccess($userId)
    {
        try {
            DB::beginTransaction();

            $access = DB::table('user_data_access')->where('user_id', $userId)->first();

            if ($access) {
                DB::table('user_data_access')
                    ->where('user_id', $userId)
                    ->update([
                        'is_active' => !$access->is_active,
                        'updated_at' => now()
                    ]);
            } else {
                // Create default access if doesn't exist
                DB::table('user_data_access')->insert([
                    'user_id' => $userId,
                    'access_type' => 'all',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status akses pengguna berhasil diubah.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error toggling user access: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengubah status akses.'
            ]);
        }
    }

    /**
     * Build children tree recursively for multi-level hierarchy
     */
    private function buildChildrenTree($jenisTemuans, $parentId, $level = 0, $maxLevel = 3)
    {
        if ($level >= $maxLevel) {
            return collect(); // Prevent infinite recursion
        }

        $children = collect();
        $directChildren = $jenisTemuans->where('id_parent', $parentId)->where('id', '!=', $parentId);

        foreach ($directChildren as $child) {
            // Create child object with its own children
            $childData = (object) [
                'id' => $child->id,
                'id_parent' => $child->id_parent,
                'nama_temuan' => $child->nama_temuan,
                'kode_temuan' => $child->kode_temuan,
                'rekomendasi' => $child->rekomendasi,
                'level' => $level + 1,
                'children' => $this->buildChildrenTree($jenisTemuans, $child->id, $level + 1, $maxLevel)
            ];

            $children->push($childData);
        }

        return $children;
    }

    /**
     * Count all descendants recursively
     */
    private function countAllDescendants($children)
    {
        $count = $children->count();
        foreach ($children as $child) {
            $count += $this->countAllDescendants($child->children);
        }
        return $count;
    }

    /**
     * Build display name for pengawasan section
     */
    private function buildDisplayName($pengawasan, $penugasanInfo)
    {
        $displayParts = [];

        // Add obrik name if available
        if ($penugasanInfo && isset($penugasanInfo['nama_obrik'])) {
            $displayParts[] = $penugasanInfo['nama_obrik'];
        } elseif ($penugasanInfo && isset($penugasanInfo['obrik'])) {
            $displayParts[] = $penugasanInfo['obrik'];
        } elseif ($pengawasan->wilayah) {
            $displayParts[] = $pengawasan->wilayah;
        }

        // Add penugasan name if available
        if ($penugasanInfo && isset($penugasanInfo['nama_penugasan'])) {
            $displayParts[] = $penugasanInfo['nama_penugasan'];
        } elseif ($penugasanInfo && isset($penugasanInfo['judul'])) {
            $displayParts[] = $penugasanInfo['judul'];
        } elseif ($penugasanInfo && isset($penugasanInfo['title'])) {
            $displayParts[] = $penugasanInfo['title'];
        }

        // Fallback to basic info if no penugasan data
        if (empty($displayParts)) {
            $displayParts[] = 'Pengawasan ID: ' . $pengawasan->id;
            if ($pengawasan->id_penugasan) {
                $displayParts[] = 'Penugasan ID: ' . $pengawasan->id_penugasan;
            }
        }

        return implode(' - ', $displayParts);
    }
}
