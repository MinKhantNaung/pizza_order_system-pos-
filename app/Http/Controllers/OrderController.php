<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // to orders list page
    public function orderList() {
        $orders = Order::select('orders.*', 'users.name as user_name')
                        ->leftJoin('users', 'users.id', 'orders.user_id')
                        ->orderBy('id', 'desc')
                        ->get();

        return view('admin.orders.list', compact('orders'));
    }

    // to filter and select with form
    public function orderStatus(Request $request) {
        $orders = Order::select('orders.*', 'users.name as user_name')
                        ->leftJoin('users', 'users.id', 'orders.user_id')
                        ->orderBy('id', 'desc');

        if ($request->status == null) {
            $orders = $orders->get();
        } else {
            $orders = $orders->where('orders.status', $request->status)->get();
        }

        return view('admin.orders.list', compact('orders'));
    }

    // submit or change status with ajax
    public function changeStatus(Request $request) {
        Order::where('id', $request->orderId)->update([
            'status' => $request->status,
        ]);
    }

    // to list when click order code
    public function listInfo($orderCode) {
        // to get total price from order
        $order = Order::where('order_code', $orderCode)->first();
        // to get order list from order_lists
        $orders = OrderList::select('order_lists.*', 'users.name as user_name', 'products.image as product_image', 'products.name as product_name')
                            ->leftJoin('users', 'users.id', 'order_lists.user_id')
                            ->leftJoin('products', 'products.id', 'order_lists.product_id')
                            ->where('order_code', $orderCode)
                            ->get();

        return view('admin.orders.orderList', compact('orders', 'order'));
    }
}
