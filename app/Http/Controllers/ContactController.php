<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contactLIst() {
        $contacts = Contact::latest()->paginate(3);

        return view('admin.contacts.list', compact('contacts'));
    }
}
