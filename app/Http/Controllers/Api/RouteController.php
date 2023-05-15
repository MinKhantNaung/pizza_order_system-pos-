<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class RouteController extends Controller
{
    // to get all products list
    public function productList() {
        $products = Product::all();

        return response()->json($products, 200);
    }

    // to get all categories list
    public function categoryList() {
        $categories = Category::orderBy('id', 'desc')->get();

        return response()->json($categories, 200);
    }

    //  to get all contacts list
    public function contactList() {
        $contacts = Contact::latest()->get();

        return response()->json($contacts, 200);
    }

    // to get all users list
    public function userList() {
        $users = User::all();

        return response()->json($users, 200);
    }

    // to create category
    public function categoryCreate(Request $request) {
        $data = [
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        $response = Category::create($data);

        return response()->json($response, 200);
    }

    // to create contact
    public function contactCreate(Request $request) {
        $data = $this->getContactData($request);
        $contact = Contact::create($data);

        return response()->json($contact, 200);
    }

    // to delete category
    public function categoryDelete($id) {
        $data = Category::where('id', $id)->first();
        if (isset($data)) {
            $data->delete();

            return response()->json(['status' => true, 'message' => 'Delete Success!'], 200);
        }

        return response()->json(['status' => false, 'message' => 'There is no category...'], 404);
    }

    // to see category detail
    public function categoryDetail($id) {
        $data = Category::where('id', $id)->first();

        if (isset($data)) {
            return response()->json(['status' => 'true', 'category' => $data], 200);
        }

        return response()->json(['status' => 'false', 'message' => 'There is no category found...'], 404);
    }

    // to update category
    public function categoryUpdate(Request $request) {
        $categoryId = $request->category_id;

        $dbSource = Category::where('id', $categoryId)->first();
        if (isset($dbSource)) {
            $data = $this->getCategoryData($request);
            $response = $dbSource->update($data);
            return response()->json(['status' => true, 'message' => 'category update success...', 'category' => $response], 200);
        }
        return response()->json(['status' => false, 'category' => 'There is no category for update...'], 404);
    }

    private function getContactData($request) {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ];
    }

    private function getCategoryData($request) {
        return [
            'name' => $request->name,
            'updated_at' => Carbon::now(),
        ];
    }
}
