<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // to user home page
    public function home() {
        $pizzas = Product::orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $history = Order::where('user_id', Auth::user()->id)->get();

        return view('user.main.home', compact('pizzas', 'categories', 'carts', 'history'));
    }

    // to password change page
    public function changePasswordPage() {
        return view('user.password.change');
    }

    // to change password
    public function changePassword(Request $request) {
        $request->validate([
            'oldPassword' => 'required|min:8|max:10',
            'newPassword' => 'required|min:8|max:10',
            'confirmPassword' => 'required|min:8|max:10|same:newPassword',
        ]);

        $user = User::find(Auth::user()->id);
        $dbPassword = $user->password;

        if (Hash::check($request->oldPassword, $dbPassword)) {
            $user->update([
                'password' => Hash::make($request->newPassword),
            ]);

            Auth::logout();
            return redirect()->route('auth.login')->with('changeSuccess', 'Password Changed!');
        }

        return back()->with('notMatch', 'The old password not match. Try Again!');
    }

    // to user account change page
    public function changeAccountPage() {
        return view('user.account.account');
    }

    // to change user account
    public function changeAccount(Request $request, $id) {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png,webp,svg',
        ]);

        if ($request->hasFile('image')) {
            $user = User::find($id);
            $dbImage = $user->image;

            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $fileName);

            $user->update([
                'image' => $fileName,
            ]);
        }

        User::find($id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
        ]);

        return back()->with('updateSuccess', 'Account changed successfully!');
    }

    // to filter products by categories
    public function filter($id) {
        $pizzas = Product::where('category_id', $id)->latest()->get();
        $categories = Category::all();
        $carts = Cart::all();
        $history = Order::where('user_id', Auth::user()->id)->get();

        return view('user.main.home', compact('pizzas', 'categories', 'carts', 'history'));
    }

    // to pizzas detail
    public function pizzaDetails($id) {
        $pizza = Product::find($id);
        $pizzaList = Product::all();

        return view('user.main.detail', compact('pizza', 'pizzaList'));
    }

    // to cart list page
    public function cartList() {
        $cartList = Cart::select('carts.*', 'products.name as pizza_name', 'products.price as pizza_price', 'products.image as pizza_image')
                    ->leftJoin('products', 'products.id', 'carts.product_id')
                    ->where('carts.user_id', Auth::user()->id)
                    ->get();

        $totalPrice = 0;
        foreach($cartList as $cart) {
            $totalPrice += $cart->pizza_price * $cart->qty;
        }

        return view('user.main.cart', compact('cartList', 'totalPrice'));
    }

    // to order history page
    public function history() {
        $orders = Order::where('user_id', Auth::user()->id)->latest()->paginate(5);

        return view('user.main.history', compact('orders'));
    }

    // to contact page
    public function contactPage() {
        return view('user.contact.index');
    }

    // to contact
    public function contact(Request $request) {
        $id = Auth::user()->id;
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $id,
            'message' => 'required',
        ]);

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return back()->with('successMsg', 'Done! Thank you for your feedback!');
    }
}
