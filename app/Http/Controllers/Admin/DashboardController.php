<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasketItem;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ReturnOrder;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $ordersPastHour = Order::query()->where('order_date', '>=', now()->subHour())->count();
        $ordersPastWeek = Order::query()->where('order_date', '>=', now()->subWeek())->count();
        $ordersPastMonth = Order::query()->where('order_date', '>=', now()->subMonth())->count();
        $totalSales = (float) Order::query()->sum('total_price');
        $totalUsers = User::query()->count();
        $totalMessages = ContactMessage::query()->count();
        $averageOrderValue = (float) Order::query()->avg('total_price');
        $openDeliveryItems = OrderDetail::query()
            ->whereIn('delivery_status', ['Pending', 'Packed', 'Shipped', 'Out for Delivery'])
            ->count();

        $salesChart = $this->salesChart();
        $signupChart = $this->signupChart();
        $topProductsChart = $this->topProductsChart();
        $basketChart = $this->basketChart();
        $orderStatusChart = $this->orderStatusChart();
        $recentMessages = ContactMessage::with('user')->latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'ordersPastHour',
            'ordersPastWeek',
            'ordersPastMonth',
            'totalSales',
            'totalUsers',
            'totalMessages',
            'averageOrderValue',
            'openDeliveryItems',
            'salesChart',
            'signupChart',
            'topProductsChart',
            'basketChart',
            'orderStatusChart',
            'recentMessages'
        ));
    }

    public function products(): View
    {
        $products = Product::with('category')->latest('id')->paginate(12);
        $categories = Category::orderBy('category_name')->get();

        return view('admin.products', compact('products', 'categories'));
    }

    public function users(): View
    {
        $search = trim((string) request('search', ''));

        $users = User::with([
            'orders' => fn ($query) => $query->latest('id'),
            'orders.orderDetails.product',
        ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($userQuery) use ($search) {
                    $userQuery->where('email', 'like', '%' . $search . '%')
                        ->orWhereHas('orders', function ($orderQuery) use ($search) {
                            if (ctype_digit($search)) {
                                $orderQuery->where('id', (int) $search)
                                    ->orWhereHas('orderDetails', function ($detailQuery) use ($search) {
                                        $detailQuery->where('product_id', (int) $search);
                                    });
                            }
                        });
                });
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        $deliveryStatuses = $this->deliveryStatuses();

        return view('admin.users', compact('users', 'deliveryStatuses', 'search'));
    }

    public function orders(Request $request): View
    {
        $filter = $request->string('filter')->toString() ?: 'open';

        $openStatuses = ['Placed', 'Packed', 'Shipped', 'Out for Delivery'];

        $orders = Order::query()
            ->with(['user', 'orderDetails.product'])
            ->when($filter === 'open', fn ($query) => $query->whereIn('order_status', $openStatuses))
            ->when($filter !== 'all' && $filter !== 'open', fn ($query) => $query->where('order_status', ucfirst($filter)))
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        $orderStatuses = $this->orderStatuses();
        $orderStats = [
            'open' => Order::query()->whereIn('order_status', $openStatuses)->count(),
            'all' => Order::query()->count(),
            'delivered' => Order::query()->where('order_status', 'Delivered')->count(),
            'refunded' => Order::query()->where('order_status', 'Refunded')->count(),
        ];

        return view('admin.orders', compact('orders', 'filter', 'orderStatuses', 'orderStats'));
    }

    public function messages(Request $request): View
    {
        $filter = $request->string('filter')->toString() ?: 'all';
        $messages = ContactMessage::with('user')
            ->with('order')
            ->when($filter === 'new', fn ($query) => $query->whereNull('admin_read_at'))
            ->when($filter === 'unreplied', fn ($query) => $query->whereNull('admin_reply'))
            ->when($filter === 'replied', fn ($query) => $query->whereNotNull('admin_reply'))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $messageStats = [
            'all' => ContactMessage::query()->count(),
            'new' => ContactMessage::query()->whereNull('admin_read_at')->count(),
            'unreplied' => ContactMessage::query()->whereNull('admin_reply')->count(),
            'replied' => ContactMessage::query()->whereNotNull('admin_reply')->count(),
        ];

        return view('admin.messages', compact('messages', 'filter', 'messageStats'));
    }

    public function showMessage(ContactMessage $message): View
    {
        if (! $message->admin_read_at) {
            $message->forceFill(['admin_read_at' => now()])->save();
        }

        return view('admin.message-show', [
            'message' => $message->load(['user', 'order']),
        ]);
    }

    public function replyToMessage(Request $request, ContactMessage $message): RedirectResponse
    {
        $validated = $request->validate([
            'admin_reply' => ['required', 'string', 'max:5000'],
        ]);

        $message->update([
            'admin_read_at' => $message->admin_read_at ?? now(),
            'admin_reply' => $validated['admin_reply'],
            'admin_replied_at' => now(),
            'customer_seen_reply' => false,
        ]);

        return redirect()
            ->route('admin.messages.show', $message)
            ->with('success', 'Reply sent to customer message.');
    }

    public function returns(Request $request): View
    {
        $filter = $request->string('filter')->toString() ?: 'processing';

        $returns = ReturnOrder::query()
            ->with(['user', 'order', 'product'])
            ->when($filter !== 'all', fn ($query) => $query->where('return_status', ucfirst($filter)))
            ->latest('created_at')
            ->paginate(12)
            ->withQueryString();

        $returnStats = [
            'all' => ReturnOrder::query()->count(),
            'processing' => ReturnOrder::query()->where('return_status', 'Processing')->count(),
            'approved' => ReturnOrder::query()->where('return_status', 'Approved')->count(),
            'rejected' => ReturnOrder::query()->where('return_status', 'Rejected')->count(),
            'refunded' => ReturnOrder::query()->where('return_status', 'Refunded')->count(),
        ];

        return view('admin.returns', compact('returns', 'filter', 'returnStats'));
    }

    public function storeProduct(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'product_model' => ['nullable', 'string', 'max:255'],
            'product_price' => ['required', 'integer', 'min:0'],
            'product_part' => ['required', 'string', 'max:255'],
            'product_description' => ['required', 'string'],
            'product_tagline' => ['required', 'string', 'max:255'],
            'product_image' => ['nullable', 'image', 'max:4096'],
            'product_stock' => ['required', 'integer', 'min:0'],
            'product_colour' => ['required', 'string', 'max:50'],
            'category_id' => ['required', 'exists:product_category,id'],
        ]);

        if ($request->hasFile('product_image')) {
            $path = $request->file('product_image')->store('products', 'public');
            $data['product_image'] = Storage::disk('public')->url($path);
        }

        $data['product_createdate'] = now();

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully.');
    }

    public function destroyProduct(Product $product): RedirectResponse
    {
        if ($product->orderDetails()->exists()) {
            return redirect()->route('admin.products.index')
                ->with('error', 'This product is linked to existing orders and cannot be deleted.');
        }

        $this->deleteStoredProductImage($product->product_image);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product removed successfully.');
    }

    public function updateDeliveryStatus(Request $request, OrderDetail $orderDetail): RedirectResponse
    {
        $validated = $request->validate([
            'delivery_status' => ['required', 'string', 'in:' . implode(',', $this->deliveryStatuses())],
        ]);

        $orderDetail->update([
            'delivery_status' => $validated['delivery_status'],
        ]);

        return back()->with('success', 'Delivery status updated.');
    }

    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'order_status' => ['required', 'string', 'in:' . implode(',', $this->orderStatuses())],
        ]);

        $order->update([
            'order_status' => $validated['order_status'],
        ]);

        $mappedDeliveryStatus = match ($validated['order_status']) {
            'Placed' => 'Pending',
            'Packed' => 'Packed',
            'Shipped' => 'Shipped',
            'Out for Delivery' => 'Out for Delivery',
            'Delivered' => 'Delivered',
            'Cancelled', 'Refunded' => 'Cancelled',
            default => null,
        };

        if ($mappedDeliveryStatus) {
            $order->orderDetails()->update([
                'delivery_status' => $mappedDeliveryStatus,
            ]);
        }

        return back()->with('success', 'Order status updated.');
    }

    public function updateReturnStatus(Request $request, ReturnOrder $returnOrder): RedirectResponse
    {
        $validated = $request->validate([
            'return_status' => ['required', 'in:Approved,Rejected'],
            'admin_comment' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($returnOrder->return_status !== 'Processing') {
            return back()->with('error', 'This return request has already been processed.');
        }

        DB::transaction(function () use ($returnOrder, $validated) {
            $shouldRestoreStock = $validated['return_status'] === 'Approved';

            if ($shouldRestoreStock) {
                $product = $returnOrder->product()->lockForUpdate()->first();
                if ($product) {
                    $product->increment('product_stock', $returnOrder->return_quantity);
                }
            }

            $returnOrder->update([
                'return_status' => $validated['return_status'],
                'admin_comment' => $validated['admin_comment'] ?? null,
                'admin_processed_at' => now(),
                'stock_restored' => $shouldRestoreStock,
            ]);

            $this->syncReturnOrderStatus($returnOrder->order);
        });

        return back()->with('success', 'Return request updated.');
    }

    public function resolveSupportItem(Request $request, Order $order, OrderDetail $orderDetail): RedirectResponse
    {
        $validated = $request->validate([
            'resolution' => ['required', 'in:return,refund'],
            'admin_comment' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($orderDetail->order_id !== $order->id) {
            abort(404);
        }

        if ($order->order_status !== 'Delivered') {
            return back()->with('error', 'Support returns or refunds can only be created for delivered items.');
        }

        $existingResolvedQuantity = ReturnOrder::query()
            ->where('order_id', $order->id)
            ->where('product_id', $orderDetail->product_id)
            ->whereIn('return_status', ['Processing', 'Approved', 'Refunded'])
            ->sum('return_quantity');

        $remainingQuantity = max(0, $orderDetail->quantity - $existingResolvedQuantity);

        if ($remainingQuantity < 1) {
            return back()->with('error', 'This item already has a full return or refund resolution recorded.');
        }

        DB::transaction(function () use ($validated, $order, $orderDetail, $remainingQuantity) {
            $isReturn = $validated['resolution'] === 'return';

            ReturnOrder::create([
                'order_id' => $order->id,
                'product_id' => $orderDetail->product_id,
                'user_id' => $order->user_id,
                'return_date' => now(),
                'reason' => $isReturn ? 'Admin-approved support return.' : 'Admin-issued support refund.',
                'admin_comment' => $validated['admin_comment'] ?? null,
                'admin_processed_at' => now(),
                'return_status' => $isReturn ? 'Approved' : 'Refunded',
                'return_quantity' => $remainingQuantity,
                'stock_restored' => $isReturn,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($isReturn && $orderDetail->product) {
                $orderDetail->product->increment('product_stock', $remainingQuantity);
                $this->syncReturnOrderStatus($order);
            }
        });

        return back()->with('success', 'Support resolution saved for the selected item.');
    }

    private function deliveryStatuses(): array
    {
        return ['Pending', 'Packed', 'Shipped', 'Out for Delivery', 'Delivered', 'Cancelled'];
    }

    private function orderStatuses(): array
    {
        return ['Placed', 'Packed', 'Shipped', 'Out for Delivery', 'Delivered', 'Cancelled', 'Refunded'];
    }

    private function syncReturnOrderStatus(Order $order): void
    {
        $totalOrdered = $order->orderDetails()->sum('quantity');
        $totalApproved = $order->returns()->where('return_status', 'Approved')->sum('return_quantity');
        $totalProcessing = $order->returns()->where('return_status', 'Processing')->sum('return_quantity');

        if ($totalApproved >= $totalOrdered && $totalOrdered > 0) {
            $order->update(['order_status' => 'Fully Returned']);
            return;
        }

        if (($totalApproved + $totalProcessing) >= $totalOrdered && $totalOrdered > 0) {
            $order->update(['order_status' => 'Pending Full Return']);
            return;
        }

        if ($totalProcessing > 0) {
            $order->update(['order_status' => 'Pending Partial Return']);
            return;
        }

        if ($totalApproved > 0) {
            $order->update(['order_status' => 'Partially Returned']);
            return;
        }

        $order->update(['order_status' => 'Delivered']);
    }

    private function salesChart(): array
    {
        $start = now()->startOfDay()->subDays(6);
        $orders = Order::query()
            ->where('order_date', '>=', $start)
            ->get(['order_date', 'total_price']);

        $totalsByDay = [];
        foreach ($orders as $order) {
            $key = $order->order_date?->format('Y-m-d');
            if (! $key) {
                continue;
            }
            $totalsByDay[$key] = ($totalsByDay[$key] ?? 0) + (float) $order->total_price;
        }

        $labels = [];
        $values = [];
        for ($offset = 0; $offset < 7; $offset++) {
            $day = $start->copy()->addDays($offset);
            $key = $day->format('Y-m-d');
            $labels[] = $day->format('D');
            $values[] = round($totalsByDay[$key] ?? 0, 2);
        }

        return ['labels' => $labels, 'values' => $values];
    }

    private function signupChart(): array
    {
        $start = now()->startOfMonth()->subMonths(5);
        $users = User::query()->get(['id', 'created_at', 'email_verified_at']);

        $totalsByMonth = [];
        foreach ($users as $user) {
            $registeredAt = $user->created_at ?? $user->email_verified_at;
            if (! $registeredAt) {
                continue;
            }

            $registeredAt = $registeredAt->copy()->startOfMonth();
            if ($registeredAt->lt($start)) {
                continue;
            }

            $key = $registeredAt->format('Y-m');
            $totalsByMonth[$key] = ($totalsByMonth[$key] ?? 0) + 1;
        }

        $labels = [];
        $values = [];
        for ($offset = 0; $offset < 6; $offset++) {
            $month = $start->copy()->addMonths($offset);
            $key = $month->format('Y-m');
            $labels[] = $month->format('M Y');
            $values[] = $totalsByMonth[$key] ?? 0;
        }

        return ['labels' => $labels, 'values' => $values];
    }

    private function topProductsChart(): array
    {
        $topProducts = OrderDetail::query()
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->select('products.product_name', DB::raw('SUM(order_details.quantity) as total_quantity'))
            ->groupBy('products.id', 'products.product_name')
            ->orderByDesc('total_quantity')
            ->limit(8)
            ->get();

        return [
            'labels' => $topProducts->pluck('product_name')->values(),
            'values' => $topProducts->pluck('total_quantity')->map(fn ($value) => (int) $value)->values(),
        ];
    }

    private function basketChart(): array
    {
        $basketPopularity = BasketItem::query()
            ->join('products', 'products.id', '=', 'basket_items.product_id')
            ->select('products.product_name', DB::raw('SUM(basket_items.quantity) as popularity'))
            ->groupBy('products.id', 'products.product_name')
            ->orderByDesc('popularity')
            ->limit(8)
            ->get();

        return [
            'items' => $basketPopularity,
            'labels' => $basketPopularity->pluck('product_name')->values(),
            'values' => $basketPopularity->pluck('popularity')->map(fn ($value) => (int) $value)->values(),
        ];
    }

    private function orderStatusChart(): array
    {
        $statuses = Order::query()
            ->select('order_status', DB::raw('COUNT(*) as total'))
            ->groupBy('order_status')
            ->orderByDesc('total')
            ->get();

        return [
            'labels' => $statuses->pluck('order_status')->values(),
            'values' => $statuses->pluck('total')->map(fn ($value) => (int) $value)->values(),
        ];
    }

    private function deleteStoredProductImage(?string $imageUrl): void
    {
        if (! $imageUrl) {
            return;
        }

        $imagePath = parse_url($imageUrl, PHP_URL_PATH) ?: $imageUrl;

        if (! str_starts_with($imagePath, '/storage/')) {
            return;
        }

        $storagePath = ltrim(substr($imagePath, strlen('/storage/')), '/');

        if ($storagePath !== '') {
            Storage::disk('public')->delete($storagePath);
        }
    }
}
