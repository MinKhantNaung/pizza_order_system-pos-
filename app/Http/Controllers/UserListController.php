<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserListController extends Controller
{
    // to user list page
    public function userList() {
        $users = User::where('role', 'user')->latest()->paginate(3);
        $users->appends(request()->all());

        return view('admin.users.list', compact('users'));
    }

    // to change role with ajax
    public function userChangeRole(Request $request) {
        $user = User::where('id', $request->userId)->first();

        $user->update([
            'role' => 'admin',
        ]);
    }

    // to delete users
    public function delete($id) {
        User::find($id)->delete();

        return to_route('admin.userList')->with('successMsg', 'A User Deleted Successfully!');
    }
}
