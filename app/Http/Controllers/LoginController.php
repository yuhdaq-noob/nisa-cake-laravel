<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display the login form
     */
    public function index(): View
    {
        return view('login');
    }

    /**
     * Authenticate user credentials
     */
    public function authenticate(Request $request): JsonResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'status' => 'success',
                'message' => 'Login successful. Initializing...',
                'redirect' => route('kasir'),
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials provided.',
        ], 401);
    }

    /**
     * Log out the authenticated user
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
