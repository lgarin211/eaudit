<?php

namespace App\Http\Controllers\AdminTL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jenis_temuan;
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
            // $jenisTemuans = DB::table('jenis_temuans')->orderBy('id_parent')->orderBy('id')->get();
            $jenisTemuansHierarchy = [];
            foreach ($jenisTemuans as $item) {
                if ($item->id == $item->id_parent) {
                    $jenisTemuansHierarchy[$item->id_pengawasan][$item->id] = [
                        'parent' => $item,
                        'children' => [],
                        'nama_temuan' => $item->nama_temuan
                    ];
                } else {
                    $jenisTemuansHierarchy[$item->id_pengawasan][$item->id_parent]['children'][$item->id] = $item;
                }
            }

            // Keep the flat version for compatibility
            $jenisTemuansGrouped = $jenisTemuans->groupBy('id_parent');

            // dd($jenisTemuansHierarchy);

            return view('AdminTL.user-control.user-data', compact('users', 'jenisTemuans', 'jenisTemuansGrouped', 'jenisTemuansHierarchy'));
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
            'jenis_temuan_ids' => 'nullable|array',
            'jenis_temuan_ids.*' => 'exists:jenis_temuans,id',
            'notes' => 'nullable|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            $accessData = [
                'access_type' => $request->access_type,
                'jenis_temuan_ids' => $request->access_type === 'specific' ? json_encode($request->jenis_temuan_ids ?? []) : null,
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
}
