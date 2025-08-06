<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    //
    public function index()
    {

        if (Auth::guard('admin')->check()) {
            $id = Auth::guard('admin')->user()->id;
            // Newest without response at tops
            $contacts = DB::table('contacts')->where('response_sent', '=', 0)->orderBy('name', 'asc')->orderBy('id', 'desc')->get();
            $search = '';
            return view("admins.contacts.index", compact('search', 'contacts'));
        } else {
            return redirect()->route('admin.login');
        }
    }
    function respond($message_id)
    {
        if (Auth::guard('admin')->check()) {
            $message = Contact::find($message_id);
            if ($message) {
                $message->update([
                    'response_sent' => 1
                ]);
                return redirect()->back()->with("success", "Contact message was read successfully.");
            } else {
                return redirect()->back()->with("error", "Sorry! we can not locate this message.");
            }
            return redirect()->route("admin.contacts.index");
        } else {
            return redirect()->route('admin.login');
        }
    }

    function replied($message_id)
    {
        $message = Contact::find($message_id);
        if ($message) {
            $message->update([
                'response_sent' => 1
            ]);
        }
    }

    function search(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $search = $request->search;
            if (!empty($search)) {
                $contacts =  DB::table('contacts')->where('response_sent', '=', 0)->orWhere('name', 'like', "$search%")->orWhere('email', 'like', "%$search%")->orWhere('message', '=', "$search%")->orderBy('name', 'asc')->orderBy('id', 'desc')->get();
                if ($contacts) {
                    return view("admins.contacts.index", compact('search', 'contacts'));
                }
            }
            return redirect()->route("admin.contacts.index");
        } else {
            return redirect()->route('admin.login');
        }
    }
}
