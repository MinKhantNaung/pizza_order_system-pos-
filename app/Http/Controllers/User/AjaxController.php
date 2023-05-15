<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    // to sorting products list
    public function pizzaList(Request $request) {

        if ($request->status == 'desc') {
            $data = Product::orderBy('created_at', 'desc')->get();
        } else {
            $data = Product::get();
        }

        return response()->json($data, 200);
    }

    // to add to cart
    public function addToCart(Request $request) {
        Cart::create([
            'user_id' => $request->userId,
            'product_id' => $request->pizzaId,
            'qty' => $request->count,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $response = [
            'message' => 'Add to cart complete',
            'status' => 'success',
        ];

        return response()->json($response, 200);
    }

    // to order
    public function order(Request $request) {
        // $total is for Order table to add total
        $total = 0;

        foreach ($request->all() as $item) {
            $data = OrderList::create($item);

            $total += $data->total;
        }

        Cart::where('user_id', Auth::user()->id)->delete();
        Order::create([
            'user_id' => $data->user_id,
            'order_code' => $data->order_code,
            'total_price' => $total + 3000,
        ]);

        return response()->json([
            'status' => 'true',
            'message' => 'order complete'
        ],
        200);
    }

    // to clear cart
    public function clearCart() {
        Cart::where('user_id', Auth::user()->id)->delete();
    }

    // to clear current product from cart when click cross button
    public function clearCurrentProduct(Request $request) {
        Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $request->product_id)
                ->where('id', $request->order_id)
                ->delete();
    }

    // to increase view count
    public function increaseViewCount(Request $request) {
        $product = Product::where('id', $request->pizzaId)->first();

        $product->update([
            'view_count' => $product->view_count + 1,
        ]);
    }
}
