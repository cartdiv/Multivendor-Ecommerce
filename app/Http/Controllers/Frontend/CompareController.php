<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Compare;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function AddToCompare(Request $request, $product_id)
    {
        if(Auth::check()){
            $exists = Compare::where('user_id',Auth::id())->where('product_id',$product_id)->first();

            if (!$exists) {
                Compare::insert([
                'user_id' => Auth::id(),
                'product_id' => $product_id,
                'created_at' => Carbon::now(),

               ]);
               return response()->json(['success' => 'Successfully Added On Your Compare' ]);
            } else{
                return response()->json(['error' => 'This Product exist in Your Compare' ]);

            } 

        }else{
            return response()->json(['error' => 'Login to add a product to Compare' ]);
        }

    } // End Method 

    public function AllCompare(){

        return view('frontend.compare.view_compare');

    }// End Method 
    
    public function GetCompareProduct ()
    {
        $compare = Compare::with('product')->where('user_id',Auth::id())->latest()->get(); 
        $compQty = Compare::count();
        return response()->json(['compare' => $compare, 'compQty' => $compQty]);
        # code...
    }

    public function CompareRemove ($id){

        Compare::where('user_id',Auth::id())->where('id',$id)->delete();
     return response()->json(['success' => 'Successfully Product Remove' ]);
    }// End Method
        
        # code...
 
    //
}
