<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->latest()->paginate(10);

        return $this->profileView([
            'user' => $user,
            'orders' => $orders,
        ]);
    }

    public function orders()
    {
        return $this->profileView([
            'user' => Auth::user(),
            'orders' => Auth::user()->orders()->latest()->paginate(10),
        ]);
    }

    public function viewOrder($orderId)
    {
        $order = Order::where('user_id', Auth::id())->with('orderDetails.product')->findOrFail($orderId);
        $returns = $order->returns()->with('product')->latest()->get();

        return view('profile.partials.view-past-order-details', compact('order', 'returns'));
    }

    public function reviews()
    {
        $user = Auth::user();
        $reviews = Review::where('user_id', $user->id)->with('product')->latest()->paginate(4);

        return $this->profileView([
            'user' => $user,
            'reviews' => $reviews,
        ]);
    }

    public function security()
    {
        return $this->profileView([
            'user' => Auth::user(),
        ]);
    }

    public function messages()
    {
        $user = Auth::user();

        ContactMessage::query()
            ->where('user_id', $user->id)
            ->whereNotNull('admin_reply')
            ->where('customer_seen_reply', false)
            ->update(['customer_seen_reply' => true]);

        return $this->profileView([
            'user' => $user,
            'messages' => ContactMessage::query()
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
        ]);

        if ($validated['email'] !== $user->email) {
            $code = rand(100000, 999999);

            Cache::put('email_update_' . $user->id, [
                'new_email' => $validated['email'],
                'code' => $code,
            ], 600);

            Mail::raw("Your email update verification code is: $code", function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Verify Email Change');
            });

            return redirect()->route('profile.verify-email');
        }

        return back()->with('status', 'Profile updated successfully!');
    }

    public function verifyEmailPage()
    {
        return view('profile.partials.verify-email');
    }

    public function verifyEmailAction(Request $request)
    {
        $request->validate([
            'code' => ['required', 'numeric', 'digits:6'],
        ]);

        $userId = Auth::id();
        $cacheKey = 'email_update_' . $userId;
        $cachedData = Cache::get($cacheKey);

        if (! $cachedData || $cachedData['code'] != $request->code) {
            return back()->withErrors(['code' => 'Invalid or expired verification code.']);
        }

        Auth::user()->update([
            'email' => $cachedData['new_email'],
        ]);

        Cache::forget($cacheKey);

        return redirect()->route('profile.security')->with('status', 'Email updated successfully!');
    }

    public function editPassword()
    {
        return view('profile.change-password');
    }

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

    private function profileView(array $data)
    {
        $user = $data['user'] ?? Auth::user();
        $data['unreadReplyCount'] = $user
            ? $user->contactMessages()
                ->whereNotNull('admin_reply')
                ->where('customer_seen_reply', false)
                ->count()
            : 0;

        return view('profile.edit', $data);
    }
}
