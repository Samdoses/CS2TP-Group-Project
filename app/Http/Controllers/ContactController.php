<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(Request $request): View
    {
        $orders = collect();

        if ($request->user()) {
            $orders = $request->user()
                ->orders()
                ->latest('id')
                ->get(['id', 'order_date', 'order_status', 'total_price']);
        }

        return view('contact', [
            'orders' => $orders,
            'contactReasons' => $this->contactReasons(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'contact_reason' => ['required', 'string', 'in:' . implode(',', array_keys($this->contactReasons()))],
            'related_order_id' => ['nullable', 'integer'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $user = $request->user();
        $orderRequiredReasons = ['product_question', 'return_appeal', 'refund_request', 'damaged_product'];

        if (in_array($validated['contact_reason'], $orderRequiredReasons, true)) {
            if (! $user) {
                return back()
                    ->withInput()
                    ->withErrors(['related_order_id' => 'Please sign in before contacting us about a specific order or product.']);
            }

            $request->validate([
                'related_order_id' => [
                    'required',
                    'integer',
                    'exists:orders,id,user_id,' . $user->id,
                ],
            ]);
        } elseif (! empty($validated['related_order_id'])) {
            $request->validate([
                'related_order_id' => [
                    'integer',
                    $user ? 'exists:orders,id,user_id,' . $user->id : 'prohibited',
                ],
            ]);
        }

        ContactMessage::create([
            'user_id' => $user?->id,
            'sender_name' => $user ? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) : ($validated['name'] ?? null),
            'sender_email' => $user?->email ?? ($validated['email'] ?? null),
            'contact_reason' => $validated['contact_reason'],
            'related_order_id' => $validated['related_order_id'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

        return back()->with('status', 'Message sent successfully!');
    }

    private function contactReasons(): array
    {
        return [
            'general_question' => 'General Question',
            'product_question' => 'Question About a Product',
            'order_issue' => 'Order Issue',
            'damaged_product' => 'Damaged or Faulty Product',
            'return_appeal' => 'Return Appeal',
            'refund_request' => 'Refund Request',
        ];
    }
}
