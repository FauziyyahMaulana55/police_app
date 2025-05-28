<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:8|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[@$!%*?&]/'
        ], [
            'name.required'     => 'Nama wajib diisi',

            'email.required'    => 'Email wajib diisi',
            'email.email'       => 'Email tidak valid',
            'email.unique'      => 'Email sudah terdaftar',

            'password.required' => 'Password wajib diisi',
            'password.min'      => 'Password minimal 8 karakter',
            'password.regex'    => 'Password harus terdiri dari huruf besar, huruf kecil, angka, dan karakter khusus',
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
        ]);

        if (!$user) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Gagal membuat akun',
                'data'      => []
            ], 400);
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Pendaftaran berhasil',
            'data'      => []
        ], 200);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'  => 'required|email',
            'password'  => 'required'

        ], [
            'email.required'  => 'Email wajib diisi',
            'email.email'  => 'Email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Email atau password salah',
                'data'      => []
            ], 401);
        }

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'status'    => 'success',
            'message'   => 'Login berhasil',
            'data'      => [
                'user'  => $user,
                'token' => $token
            ],
        ], 200)->withCookie(cookie('token', $token, 60, null, null, true, false));
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'    => 'success',
            'message'   => 'Logout berhasil',
            'data'      => []
        ], 200);
    }

    public function profile(Request $request)
    {
        return response()->json([
            'status'    => 'success',
            'message'   => 'Data user ditemukan',
            'data'      => $request->user(),
        ], 200);
    }

    public function index()
    {
        return view('login');
    }

    public function registerPage()
    {
        return view('register');
    }
}
