<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImage;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VendorProductController extends Controller
{

    public function AllVendorProduct()
    {
        $id = Auth::user()->id;
        $products = Product::where('vendor_id',$id)->latest()->get();
        return view('vendor.backend.product.all_product',compact('products'));
        # code...
    }

    public function AddVendorProduct()
    {
        // get all brand and category for dropdown menu
        $brands = Brand::orderBy('brand_name','asc')->get();
        $categories = Category::orderBy('category_name','asc')->get();
        return view('vendor.backend.product.add_product', compact( 'brands', 'categories' ));
        # code...
    }

    public function GetSubCategoryVendor($category_id){
        $subcat = SubCategory::where('category_id',$category_id)->orderBy('subcategory_name','ASC')->get();
            return json_encode($subcat);

    }// End Method

    public function StoreVendorProduct(Request $request)
    {
        $vendor_id = Auth::user()->id;
        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(800,800)->save('upload/products/thambnail/'.$name_gen);
        $save_url = 'upload/products/thambnail/'.$name_gen;

        $product_id = Product::insertGetId([

            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ','-',$request->product_name)),

            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp, 

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals, 

            'product_thumbnail' => $save_url,
            'vendor_id' => $vendor_id,
            'status' => 0,
            'created_at' => Carbon::now(), 

        ]);

        /// Multiple Image Upload From her //////


        $images = $request->file('multi_img');
        foreach($images as $img){
        $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        Image::make($img)->resize(800,800)->save('upload/products/multi-image/'.$make_name);
        $uploadPath = 'upload/products/multi-image/'.$make_name;

        MultiImage::insert([

            'product_id' => $product_id,
            'photo_name' => $uploadPath,
            'created_at' => Carbon::now(), 

        ]); 
        } // end foreach

        /// End Multiple Image Upload From her //////

        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.vendor.product')->with($notification); 
        # code...
    }
    
    public function EditVendorProduct($id)
    {
        $multiImgs = MultiImage::where('product_id',$id)->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategory = SubCategory::latest()->get();
        $products = Product::findOrFail($id);
        return view('vendor.backend.product.edit_product',compact('brands','categories','products','subcategory','multiImgs'));
        # code...
    }

    public function UpdateVendorProduct(Request $request)
    {
        $product_id = $request->id;

        Product::findOrFail($product_id)->update([

       'brand_id' => $request->brand_id,
       'category_id' => $request->category_id,
       'subcategory_id' => $request->subcategory_id,
       'product_name' => $request->product_name,
       'product_slug' => strtolower(str_replace(' ','-',$request->product_name)),

       'product_code' => $request->product_code,
       'product_qty' => $request->product_qty,
       'product_tags' => $request->product_tags,
       'product_size' => $request->product_size,
       'product_color' => $request->product_color,

       'selling_price' => $request->selling_price,
       'discount_price' => $request->discount_price,
       'short_descp' => $request->short_descp,
       'long_descp' => $request->long_descp, 

       'hot_deals' => $request->hot_deals,
       'featured' => $request->featured,
       'special_offer' => $request->special_offer,
       'special_deals' => $request->special_deals, 


       'created_at' => Carbon::now(), 

   ]);


    $notification = array(
       'message' => 'Product Updated Without Image Successfully',
       'alert-type' => 'success'
   );

   return redirect()->route('all.vendor.product')->with($notification); 

}// End Method 

        public function UpdateVendorProductThambnail(Request $request){

            $pro_id = $request->id;
            $oldImage = $request->old_img;

            $image = $request->file('product_thambnail');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(800,800)->save('upload/products/thambnail/'.$name_gen);
            $save_url = 'upload/products/thambnail/'.$name_gen;

            if (file_exists($oldImage)) {
            unlink($oldImage);
            }

            Product::findOrFail($pro_id)->update([

                'product_thumbnail' => $save_url,
                'updated_at' => Carbon::now(),
            ]);

        $notification = array(
                'message' => 'Product Image Thambnail Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification); 

        }// End Method 

        // Multi Image Update 
        public function UpdateVendorProductMultiimage(Request $request){

            $imgs = $request->multi_img;

            foreach($imgs as $id => $img ){
                $imgDel = MultiImage::findOrFail($id);
                unlink($imgDel->photo_name);

        $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(800,800)->save('upload/products/multi-image/'.$make_name);
            $uploadPath = 'upload/products/multi-image/'.$make_name;

            MultiImage::where('id',$id)->update([
                'photo_name' => $uploadPath,
                'updated_at' => Carbon::now(),

            ]); 
            } // end foreach

            $notification = array(
                'message' => 'Product Multi Image Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification); 

        }// End Method 

        public function VendorMulitImageDelelte($id){
            $oldImg = MultiImage::findOrFail($id);
            unlink($oldImg->photo_name);

            MultiImage::findOrFail($id)->delete();

            $notification = array(
                'message' => 'Product Multi Image Deleted Successfully',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);

        }// End Method 

        // public function VendorProductInactive($id){

        //     Product::findOrFail($id)->update(['status' => 0]);
        //     $notification = array(
        //         'message' => 'Product Inactive',
        //         'alert-type' => 'success'
        //     );

        //     return redirect()->back()->with($notification);

        // }// End Method 


        // public function VendorProductActive($id){

        //     Product::findOrFail($id)->update(['status' => 1]);
        //     $notification = array(
        //         'message' => 'Product Active',
        //         'alert-type' => 'success'
        //     );

        //     return redirect()->back()->with($notification);

        // }// End Method 

        public function VendorProductDelete($id){

            $product = Product::findOrFail($id);
            unlink($product->product_thumbnail);
            Product::findOrFail($id)->delete();

            $imges = MultiImage::where('product_id',$id)->get();
            foreach($imges as $img){
                unlink($img->photo_name);
                MultiImage::where('product_id',$id)->delete();
            }

            $notification = array(
                'message' => 'Product Deleted Successfully',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);

        }// End Method 
    //
}

