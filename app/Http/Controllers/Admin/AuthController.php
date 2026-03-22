<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $admin = Admin::query()
            ->where('email', $credentials['login'])
            ->orWhere('admin_username', $credentials['login'])
            ->first();

        $plainPasswordMatch = $admin && hash_equals($admin->admin_password, $credentials['password']);
        $hashedPasswordMatch = $admin && Hash::check($credentials['password'], $admin->admin_password);

        if (! $admin || (! $plainPasswordMatch && ! $hashedPasswordMatch)) {
            return back()
                ->withErrors(['login' => 'Invalid admin credentials.'])
                ->onlyInput('login');
        }

        if ($plainPasswordMatch && ! $hashedPasswordMatch) {
            $admin->update([
                'admin_password' => Hash::make($credentials['password']),
            ]);
        }

        Auth::guard('admin')->login($admin, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
