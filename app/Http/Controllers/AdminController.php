<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // direct login page
    public function login()
    {
        return view('login');
    }

    // direct register page
    public function register()
    {
        return view('register');
    }

    // direct dashboard page
    public function dashboard()
    {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('categories.list');
        }
        return redirect()->route('users.home');
    }

    // to change Password page
    public function changePasswordPage()
    {

        return view('admin.account.changePassword');
    }

    // to change Password
    public function changePassword(Request $request)
    {
        /*
            1. all field must be fill
            2. new pwd and confirm pwd length must be greater than 6
            3. new pwd and confirm pwd must same
            4. client old pwd must be same with db pwd
            5. password change
        */
        $request->validate([
            'oldPassword' => 'required|min:8|max:10',
            'newPassword' => 'required|min:8|max:10',
            'confirmPassword' => 'required|min:8||max:10|same:newPassword',
        ]);

        $user = User::find(Auth::user()->id);

        $dbPassword = $user->password;

        if (Hash::check($request->oldPassword, $dbPassword)) {
            User::find($user->id)->update([
                'password' => Hash::make($request->newPassword),
            ]);

            Auth::logout();

            return redirect()->route('auth.login')->with('changeSuccess', 'Password Changed!');
        }

        return back()->with('notMatch', 'The old password not match. Try Again!');
    }

    // to direct account detail page
    public function detail() {
        return view('admin.account.detail');
    }

    // to direct account edit page
    public function edit() {
        return view('admin.account.edit');
    }

    // to update account
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'image' => 'mimes:jpg,jpeg,png,webp,svg',
        ]);

        // for image
        // 1 old image name | check => delete | store
        if ($request->hasFile('image')) {
            $user = User::find($id);
            $dbImage = $user->image;

            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $fileName);
            // store in database
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

        return redirect()->route('admin.detail')->with('successUpdate', 'Admin Account Updated!');
    }

    // to admin list page
    public function list() {
        $admins = User::when(request('key'), function($query) {
                            $query->orWhere('name', 'like', '%' . request('key') . '%')
                                  ->orWhere('email', 'like', '%' . request('key') . '%')
                                  ->orWhere('gender', 'like', '%' . request('key') . '%')
                                  ->orWhere('phone', 'like', '%' . request('key') . '%')
                                  ->orWhere('address', 'like', '%' . request('key') . '%');
                        })
                        ->where('role', 'admin')
                        ->paginate(3);

        $admins->appends(request()->all());

        return view('admin.account.list', compact('admins'));
    }

    // to delete other admin account
    public function delete($id) {
        User::where('id', $id)->delete();

        return back()->with('deleteMsg', 'Admin account successfully deleted');
    }

    // to change role others admin with Ajax
    public function changeRole(Request $request) {
        $user = User::where('id', $request->userId)->first();

        $user->update([
            'role' => 'user',
        ]);
    }
}

