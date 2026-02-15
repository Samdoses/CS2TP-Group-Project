<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;

class ProfileController extends Controller
{

    // display users details
    public function index()
    {
        $user = Auth::user();

        $orders = $user->orders()->latest()->paginate(10);

        return view('profile.edit', [
            'user' => $user,
            'orders' => $orders
        ]);
    }

    // Order page
    public function orders()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);

        return view('profile.edit', [
            'user' => Auth::user(),
            'orders' => $orders
        ]);
    }

    public function viewOrder($orderId) {

        $order = Order::with('orderDetails.product')->findOrFail($orderId);
        return view('profile.partials.view-past-order-details', compact('order'));
    }


    public function security()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }


    public function update(Request $request)
    {
        $user = $request->user();

        // 1. Validate Input
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        // 2. Update Basic Info (Name) immediately
        $user->update([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
        ]);

        // 3. Check if Email is being changed
        if ($validated['email'] !== $user->email) {

            // Generate a 6-digit code
            $code = rand(100000, 999999);

            // Store the NEW email and the CODE in Cache for 10 minutes
            // Key is unique to the user
            Cache::put('email_update_' . $user->id, [
                'new_email' => $validated['email'],
                'code' => $code
            ], 600);

            // Send email to the EXISTING (Current) email
            Mail::raw("Your email update verification code is: $code", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Verify Email Change');
            });

            // Redirect to the verification page
            return redirect()->route('profile.verify-email');
        }

        return back()->with('status', 'Profile updated successfully!');
    }

    // Show the OTP Entry Form
    public function verifyEmailPage()
    {
        return view('profile.partials.verify-email');
    }

    // Process the OTP
    public function verifyEmailAction(Request $request)
    {
        $request->validate([
            'code' => ['required', 'numeric', 'digits:6'],
        ]);

        $userId = Auth::id();
        $cacheKey = 'email_update_' . $userId;
        $cachedData = Cache::get($cacheKey);

        // Check if code exists and matches
        if (!$cachedData || $cachedData['code'] != $request->code) {
            return back()->withErrors(['code' => 'Invalid or expired verification code.']);
        }

        // Update the User's Email
        Auth::user()->update([
            'email' => $cachedData['new_email']
        ]);

        // Clear the cache
        Cache::forget($cacheKey);

        return redirect()->route('profile.security')->with('status', 'Email updated successfully!');
    }

    public function editPassword()
    {
        return view('profile.change-password');
    }

    //update password
    public function updatePassword(Request $request)
    {
        $validated = $request->validateWithBag('password_update', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'current_password.current_password' => 'The provided password does not match your current password.',
            'password.confirmed' => 'The new password confirmation does not match.',
        ]);


        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);


        return back()->with('status', 'password-updated');
    }


}
