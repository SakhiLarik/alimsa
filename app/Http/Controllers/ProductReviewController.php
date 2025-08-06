<?php

namespace App\Http\Controllers;

use App\Models\ProductComment;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductReviewController extends Controller
{

    //
    public function ratings(Request $request)
    {
        //
        // dd($request->all());
         if (Auth::guard('web')->check()) {
            $user_id = Auth::guard('web')->user()->id;
            $validator = $request->validate([
                'rating' => 'integer|min:1|max:5|required',
                'review' => 'string|max:255|required',
                'product_id' => 'required',
            ]);
            $create = ProductReview::create([
                'user_id' => $user_id,
                'product_id' => $request->product_id,
                'ratings' => $request->rating,
                'review' => $request->review,
            ]);
            if($create){
                return redirect()->back()->with("success", $request->rating > 3? "Thanks, for your positive ratings for our product.":"Thans, we are working to improve our products");
            }else{
                return redirect()->back()->with("error", "Sorry! something went wrong, try again");
            }
        } else {
            return redirect()->route('login')->with("error", "Please login to your account");
        }
    }

    public function comments(Request $request)
    {
        //
        // dd($request->all());
         if (Auth::guard('web')->check()) {
            $user_id = Auth::guard('web')->user()->id;
            $validator = $request->validate([
                'comment' => 'string|min:10|max:5000|required',
                'product_id' => 'required',
            ]);
            $create = ProductComment::create([
                'user_id' => $user_id,
                'product_id' => $request->product_id,
                'comment' => $request->comment,
            ]);
            if($create){
                return redirect()->back()->with("success", "Thank you, for your comment.");
            }else{
                return redirect()->back()->with("error", "Sorry! something went wrong, try again");
            }
        } else {
            return redirect()->route('login')->with("error", "Please login to your account");
        }
    }

}
