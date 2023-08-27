<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\UserRole;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'create']);
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $order = $request->validate([
            'recipient_address' => 'required',
            'shipping_address' => 'required',
            'shipping_date' => 'required|date|after:now'
        ]);

        $order['user_id'] = $request->user()->id;
        $order['order_number'] = (string) Str::ulid();
        $order['expected_delivery_date'] = Carbon::parse($order['shipping_date'])->addDays(3);
        $order['status'] = OrderStatus::PENDING;

        $newOrder = Order::create($order);

        return view('orders.create-success', ['customerName' => $request->user()->name, 'order' => $newOrder]);
    }

    public function index(Request $request)
    {
        $isShippingStaff = auth()->user()?->role === UserRole::SHIPPING_STAFF;

        if ($query = $request->query()) {
            $searchText = $query['search-text'];
            $searchShippingDate = $query['search-shipping-date'];

            $orders = Order::query()->select([
                'orders.id',
                'name',
                'order_number',
                'shipping_date',
                'expected_delivery_date' 
            ])
                ->join('users', 'user_id', 'users.id')
                ->when($isShippingStaff, function ($query) {
                    $query->where('status', OrderStatus::PENDING);
                })
                ->when($searchText, function ($query, $searchText) {
                    $query->where(function ($q) use ($searchText) {
                        $q->where('order_number', 'like', "%$searchText%")
                            ->orWhere('name', 'like', "%$searchText%");
                    });
                })
                ->when($searchShippingDate, function ($query, $searchShippingDate) {
                    $query->whereDate('shipping_date', $searchShippingDate);
                })
                ->paginate(5);

            $request->flash();
        } else {
            $orders = Order::query()->select([
                'orders.id',
                'name',
                'order_number',
                'shipping_date',
                'expected_delivery_date' 
            ])
                ->join('users', 'user_id', 'users.id')
                ->when($isShippingStaff, function ($query) {
                    $query->where('status', OrderStatus::PENDING);
                })
                ->paginate(5);
        
            $request->session()->forget('_old_input');
        }

        return view('home', compact('orders', 'isShippingStaff'));
    }

    public function show($orderId)
    {
        $order = null;

        try {
            $order = Order::query()->select(['orders.*', 'users.id as user_id', 'users.name'])
                ->join('users', 'user_id', 'users.id')
                ->where('orders.id', $orderId)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return view('orders.notfound');
        }

        $reviews = Review::query()->where('order_id', $orderId)->get();

        return view('orders.detail', compact('order', 'reviews'));
    }

    public function destroy($orderId)
    {
        try {
            Order::findOrFail($orderId)->delete();
            return redirect()->route('home');
        } catch (ModelNotFoundException $e) {
            return view('orders.notfound');
        }
    }

    public function edit($orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            return view('orders.edit', compact('order'));
        } catch (ModelNotFoundException $e) {
            return view('orders.notfound');
        }
    }

    public function update(Request $request)
    {
        $orderId = $request->input('id');
        $order = $request->validate([
            'recipient_address' => 'required',
            'shipping_address' => 'required',
            'shipping_date' => [
                'required', 
                'date'
            ]
        ]);

        Order::query()->whereKey($orderId)->update($order);

        return redirect()->route('orders.show', ['order' => $orderId]);
    }

    public function applyOrder($orderId, Request $request)
    {
        $order = Order::find($orderId);

        if ($order->status === OrderStatus::PENDING) {
            Order::query()->whereKey($orderId)->update([
                'shipping_staff_id' => $request->user()->id,
                'status' => OrderStatus::PROCESSING
            ]);
        }

        return back();
    }

    public function myShippingOrders(Request $request)
    {
        $orders = Order::with('user:id,name')
            ->where('shipping_staff_id', $request->user()->id)
            ->whereNot('status', OrderStatus::PENDING)
            ->orderBy('status')
            ->get()
            ->transform(function ($order) {
                $order->status_selectbox = array_slice(OrderStatus::STATUS, $order->status - 1, null, true);
                return $order;
            });

        return view('my-shipping-orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request)
    {
        $status = $request->input('order-status');
        $order = Order::find($request->input('order-id'));

        if ($order->status < $status && in_array($status, array_keys(OrderStatus::STATUS))) {
            $order->update(compact('status'));
        }

        return back();
    }
}
