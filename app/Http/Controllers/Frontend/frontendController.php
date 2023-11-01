<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\MultiImage;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User; 



class frontendController extends Controller
{
    public function Frontend()
    {
        $skip_category_0 = Category::skip(0)->first();
        $skip_product_0 = Product::where('status',1)->where('category_id',$skip_category_0->id)->orderBy('id','DESC')->limit(5)->get();

        $hot_deals = Product::where('hot_deals', 1)->where('status', 1)->orderBy('id','DESC')->limit(3)->get();
        $special_offer = Product::where('special_offer', 1)->where('status', 1)->orderBy('id','DESC')->limit(3)->get();
        $recently_addeds = Product::where('status', 1)->orderBy('id','DESC')->limit(3)->get();
        $special_deals = Product::where('special_deals', 1)->where('status', 1)->orderBy('id','DESC')->limit(3)->get();
    
        return view('frontend.index', compact('skip_category_0', 'skip_product_0', 'hot_deals', 'special_offer', 'recently_addeds', 'special_deals'));
        # code...
    }

    public function ProductDetails($id,$slug){

        $product = Product::findOrFail($id); 
        
        $tag = $product->product_tags;
        $product_tags = explode(',', $tag);

        $color = $product->product_color;
        $product_color = explode(',', $color);

        $size = $product->product_size;
        $product_size = explode(',', $size);

        $multiImage = MultiImage::where('product_id',$id)->get();

        $cat_id = $product->category_id;
        $relatedProduct = Product::where('category_id',$cat_id)->where('id','!=',$id)->orderBy('id','DESC')->limit(4)->get();

        

        return view('frontend.product.product_details',compact('product','product_color','product_size', 'product_tags', 'multiImage', 'relatedProduct'));

     } // End Method 


     public function VendorDetails($id,$name)
     {
        $vendors = User::findOrFail($id);
        $products = Product::where('vendor_id', $id)->orderBy('id', 'DESC')->get();
        $categories = Category::orderBy('category_name', 'ASC')->get();
        return view ('frontend.vendor.vendor_details',compact('vendors', 'products', 'categories'));
        # code...
     }

     public function VendorAll(){

        $vendors = User::where('status','active')->where('role','vendor')->orderBy('id','DESC')->get();
        return view('frontend.vendor.vendor_all',compact('vendors'));

     } // End Method 

     public function CategoryDetails($id, $slug)
     {
        $categories = Category::orderBy('category_name', 'ASC')->get();
        $products = Product::where('status',1)->where('category_id',$id)->orderBy('id','DESC')->get();
        $breadcat = Category::where('id',$id)->first();
        $newProduct = Product::orderBy('id','DESC')->limit(3)->get();
        return view('frontend.product.category_details',compact('categories', 'products', 'breadcat', 'newProduct'));

        # code...
     }


     public function SubcategoryDetails($id, $slug)
     {
        $subcategories = Subcategory::orderBy('subcategory_name', 'ASC')->get();
        $products = Product::where('status',1)->where('subcategory_id',$id)->orderBy('id','DESC')->get();
        $breadsubcat = Subcategory::where('id',$id)->first();
        $categories = Category::orderBy('category_name', 'ASC')->get();
        $newProduct = Product::orderBy('id','DESC')->limit(3)->get();
        return view('frontend.product.subcategory_details',compact('subcategories', 'categories', 'products', 'breadsubcat', 'newProduct'));

        # code...
     }
    //
    
}
