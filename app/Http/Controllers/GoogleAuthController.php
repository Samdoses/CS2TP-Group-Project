<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('status', 'Google authentication failed.');
        }

        // Check if user already exists
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Split name into first and last
            $nameParts = explode(' ', $googleUser->getName(), 2);
            $firstName = $nameParts[0];
            $lastName = $nameParts[1] ?? '';

            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $googleUser->getEmail(),
                                 'google_id' => $googleUser->getId(),
                                 'password' => Hash::make(Str::random(16)), // Random password
            ]);
        } else {
            // Update google_id if it's missing (for existing email users)
            if (!$user->google_id) {
                $user->update(['google_id' => $googleUser->getId()]);
            }
        }

        // Login the user
        Auth::login($user, true);

        return redirect()->intended(route('profile.index'));
    }
}
