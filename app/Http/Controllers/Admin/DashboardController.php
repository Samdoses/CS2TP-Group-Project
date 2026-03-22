<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasketItem;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
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
            ->whereIn('delivery_status', ['Pending', 'Placed', 'Shipped'])
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
        $users = User::with([
            'orders' => fn ($query) => $query->latest('id'),
            'orders.orderDetails.product',
        ])->orderBy('id')->paginate(10);

        $deliveryStatuses = $this->deliveryStatuses();
        $orderDeliveryStatuses = $this->orderDeliveryStatuses();

        return view('admin.users', compact('users', 'deliveryStatuses', 'orderDeliveryStatuses'));
    }

    public function messages(): View
    {
        $messages = ContactMessage::with('user')->latest()->paginate(12);

        return view('admin.messages', compact('messages'));
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

    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
        'status' => ['required', 'string', 'in:' . implode(',', $this->orderDeliveryStatuses())],
        ]);

        $newStatus = $validated['status'];
        //updates the main order with the new status
        $order->update(['order_status' => $newStatus]);

        //only sync items if its a standard order status (everything except the return statuses)
        //so if you mark an order as shipped all items become shipped but if you mark an order as Fully Returned all items become Returned.
        $standardStatuses = ['Pending', 'Placed', 'Shipped', 'Delivered', 'Cancelled'];

        if (in_array($newStatus, $standardStatuses)) {
            $order->orderDetails()->update([
                'delivery_status' => $newStatus
            ]);
        }

        return back()->with('success', 'Order #' . $order->id . ' status updated successfully.');
    }

    public function updateItemStatus(Request $request, OrderDetail $orderItem): RedirectResponse
    {
        //have seperate logic to make sure u cant set an item to pending return without return requests
        $status = $request->input('delivery_status');

        //checks for returning incase its bypassed
        if (in_array($status, ['Pending Return', 'Returned'])) {
            //checks if a return record exists for this specific item
            $hasReturnRequest = \App\Models\ReturnOrder::where('order_id', $orderItem->order_id)->where('product_id', $orderItem->product_id)->exists();

            if (!$hasReturnRequest) {
                return back()->with('error', "Cannot set status to '{$status}' because no actual return request exists for this item.");
            }
        }
        $orderItem->update($request->validate([
            'delivery_status' => ['required', 'in:' . implode(',', $this->deliveryStatuses())],
        ]));

        $order = $orderItem->order;
        if ($order) {
            $newStatus = $orderItem->order->updateStatusBasedOnItems();
            return back()->with('success', "Item updated. Order status: {$newStatus}");
        }

        dd($orderItem->order);
        return back()->with('error', "Order not found.");
    }

    //there are different statuses depending on if an order is being handled or an order item
    private function deliveryStatuses(): array
    {
        return ['Pending', 'Placed', 'Shipped', 'Delivered', 'Cancelled', 'Pending Return', 'Returned'];
    }

    private function orderDeliveryStatuses(): array
    {
        return ['Pending', 'Placed', 'Shipped', 'Delivered', 'Cancelled', 'Pending Full Return', 'Pending Partial Return', 'Fully Returned', 'Partially Returned'];
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
