<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // to products list page
    public function list()
    {
        $pizzas = Product::select('products.*', 'categories.name as category_name')
            ->when(request('key'), function ($query) {
                $query->where('products.name', 'like', '%' . request('key') . '%');
            })
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->orderBy('products.id', 'desc')
            ->paginate(3);

        $pizzas->appends(request()->all());
        return view('admin.products.pizzaList', compact('pizzas'));
    }

    // to products create page
    public function createPage()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    // to create products
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5|unique:products,name',
            'category_id' => 'required',
            'description' => 'required|min:10',
            'image' => 'required|mimes:png,jpg,jpeg,webp|file',
            'price' => 'required|integer',
            'waiting_time' => 'required|integer',
        ]);

        $imageName = uniqid() . $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public', $imageName);

        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image' => $imageName,
            'price' => $request->price,
            'waiting_time' => $request->waiting_time,
        ]);

        return redirect()->route('products.list')->with('successProduct', 'A Product Created!');
    }
    // to products view page
    public function view($id)
    {
        $pizza = Product::select('products.*', 'categories.name as category_name')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->find($id);
        return view('admin.products.view', compact('pizza'));
    }

    // to products update page
    public function updatePage($id)
    {
        $pizza = Product::find($id);
        $categories = Category::all();

        return view('admin.products.update', compact('pizza', 'categories'));
    }

    // to update products
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:5|unique:products,name,' . $id,
            'category_id' => 'required',
            'description' => 'required|min:10',
            'image' => 'mimes:png,jpg,jpeg,webp|file',
            'price' => 'required',
            'waiting_time' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $pizza = Product::find($id);
            $oldImage = $pizza->image;

            if ($oldImage != null) {
                Storage::delete('public/' . $oldImage);
            }

            $newImage = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $newImage);

            // store in database
            $pizza->update([
                'image' => $newImage,
            ]);
        }

        Product::find($id)->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'waiting_time' => $request->waiting_time,
        ]);
        return redirect()->route('products.list')->with('success', 'Pizza Updated Successfully!');
    }

    // to delete products
    public function delete($id)
    {
        $product = Product::find($id);
        Storage::delete('public/' . $product->image);
        $product->delete();

        return redirect()->route('products.list')->with('success', 'Pizza deleted Successfully!');
    }
}
