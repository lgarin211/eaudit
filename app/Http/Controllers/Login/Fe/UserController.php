<?php

namespace App\Http\Controllers\Login\Fe;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $request->validate([
            'username' => "required",
            'password' => "required",
        ]);

        $params = [
            'username' => $username,
            'password' => $password
        ];

        $response = Http::post("http://127.0.0.1:8000" . ('/api/login'), $params)->json();
        // dd($response);
        if ($response['code'] != 200) {
            return back()->with('error', $response['message']);
        }
        $token = $response['token'];
        $name = $response['user_data']['name'];
        $username = $response['user_data']['username'];
        $level = $response['user_data']['level'];

        $newsession = ['ctoken' => $token, 'sdata' => date('Y'), 'name' => $name, 'level' => $level, 'username' => $username];
        session($newsession);

        // Find user in database and login to Laravel Auth system
        $user = User::where('username', $username)->first();
        if ($user) {
            auth()->login($user);

            // Redirect based on user role
            if ($user->role === 'OpdTL') {
                return redirect()->route('opdTL.dashboard');
            }
        }

        // Default redirect from API response
        return redirect(url($response['data']));
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['id', 'name', 'username', 'level']);
        $request->session()->flush();

        return redirect('/');
    }
}
