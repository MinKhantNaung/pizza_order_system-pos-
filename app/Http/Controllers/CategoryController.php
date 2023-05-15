<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // direct category list page
    public function list()
    {
        $categories = Category::when(request('key'), function($query) {
            $query->where('name', 'like', '%' . request('key') . '%'); // search
        })
            ->orderBy('id', 'desc')->paginate(5);
        $categories->appends(request()->all());

        return view('admin.categories.list', compact('categories'));
        // if(request('key')) {
        //     $key = request('key');
        //     $categories = Category::where('name', 'like', "%$key%")->paginate(5);
        // } else {
        //     $categories = Category::orderBy('id', 'desc')->paginate(5);
        // }

        // return view('admin.categories.list', compact('categories'));
    }

    // direct category create page
    public function createPage() {
        return view('admin.categories.create');
    }

    // function to create category
    public function create(Request $request) {
        $request->validate([
            'name' => 'required|min:4|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
        ]);
        return redirect()->route('categories.list')->with('createMsg', 'Category Created!');
    }

    // to direct edit category page
    public function edit($id) {
        $category = Category::find($id);

        return view('admin.categories.edit', compact('category'));
    }

    // to update category
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|min:4|unique:categories,name,'. $id,
        ]);

        Category::find($id)->update([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.list');
    }

    // to delete category
    public function delete($id) {
        // Category::where('id', $id)->delete();
        Category::find($id)->delete();

        return back()->with('deleteMsg', 'Category Deleted!');
    }
}
