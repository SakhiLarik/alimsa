<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    //
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            $settings = DB::table('settings')->first();
            // dd($settings);
            return view("admins.settings",compact('settings'));
        } else {
            return redirect()->route('admin.login')->with("error", "Please login to admin account");
        }
    }
    public function update(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $validator = $request->validate([
                'header_image' => 'image|mimes:png,jpg|max:2048|required',
                'primary_image' => 'image|mimes:png,jpg|max:2048|required',
                'secondary_image' => 'image|mimes:png,jpg|max:2048|required',
                'header_extra' => 'string|max:255|required',
                'header_title'  => 'string|max:255|required',
                'header_text'  => 'string|required',
                'primary_title'  => 'string|max:255|required',
                'primary_text'  => 'string|required',
                'secondary_title'  => 'string|max:255|required',
                'secondary_text' => 'string|required',
            ]);
            $settings = DB::table('settings')->first();
            // dd($settings);
            $header_image = time() . "_" . uniqid(false) . '.' . $request->header_image->extension();
            $primary_image = time() . "_" . uniqid(false) . '.' . $request->primary_image->extension();
            $secondary_image = time() . "_" . uniqid(false) . '.' . $request->secondary_image->extension();

            $request->header_image->move(public_path('settings/images/'), $header_image);
            $request->primary_image->move(public_path('settings/images/'), $primary_image);
            $request->secondary_image->move(public_path('settings/images/'), $secondary_image);

            if ($settings) {
                DB::table('settings')->update([
                    'header_image' => "settings/images/".$header_image,
                    'primary_image' => "settings/images/".$primary_image,
                    'secondary_image' => "settings/images/".$secondary_image,
                    'header_extra' => $request->header_extra,
                    'header_title' => $request->header_title,
                    'header_text' => $request->header_text,
                    'primary_title' => $request->primary_title,
                    'primary_text' => $request->primary_text,
                    'secondary_title' => $request->secondary_title,
                    'secondary_text' => $request->secondary_text,
                ]);
            }else{
                 Settings::create([
                    'header_image' => "settings/images/".$header_image,
                    'primary_image' => "settings/images/".$primary_image,
                    'secondary_image' => "settings/images/".$secondary_image,
                    'header_extra' => $request->header_extra,
                    'header_title' => $request->header_title,
                    'header_text' => $request->header_text,
                    'primary_title' => $request->primary_title,
                    'primary_text' => $request->primary_text,
                    'secondary_title' => $request->secondary_title,
                    'secondary_text' => $request->secondary_text,
                ]);
            }

            return redirect()->route("admin.settings")->with('success',"Settings Updated Successfully");
        } else {
            return redirect()->route('admin.login')->with("error", "Please login to admin account");
        }
    }
}
