<?php

namespace App\Http\Controllers\Login\Api;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $path = '';
        $token = null;


        $cekuser = User::where("username", $username)->first();
        // dd($cekuser);
        if (!$cekuser) {
            return response()->json([
                'code' => 404,
                'message' => 'User tidak ditemukan',
                'data' => null
            ], 404);
        }
        // Cek password
        if (!Hash::check($password, $cekuser->password)) {
            // Password salah
            return response()->json([
                'code' => 401,
                'message' => 'Password salah',
                'data' => null
            ], 401);
        }

        // Generate token
        $token = Hash::make(Carbon::now()->toDayDateTimeString() . $cekuser->username);
        $cekuser->remember_token = $token;
        $cekuser->save();

        // Tentukan path berdasarkan level user
        $levelPaths = [
            'admineaudit' => 'skpd',
            'adminTL'     => 'adminTL',
            'PemeriksaTL' => 'Pemeriksa',
            'OpdTL'       => 'OPD',
        ];

        $path = $levelPaths[$cekuser->level] ?? '/';
        // Response sukses
        return response()->json([
            'code'  => 200,
            'token' => $token,
            'data'  => $path,
            'user_data'=>[
                'name'=>$cekuser->name,
                'username'=>$cekuser->username,
                'level'=>$cekuser->level
            ]
        ]);
    }
}
