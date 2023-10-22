<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImage;
use App\Models\Product;
use App\Models\Subcategory;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Image;
use Carbon\Carbon;

class productController extends Controller
{
    public function AllProduct()
    {
        $all_product = Product::latest()->get();
        return view('admin.backend.product.all_product', compact('all_product'));
        # code...
    }

    public function AddProduct()
    {
        $all_brands = Brand::orderBy('brand_name', 'ASC')->get();
        $all_category = Category::latest()->get();
        $all_vendors = User::where('status', 'active')->where('role','vendor')->orderBy('name', 'ASC')->get();
        return view('admin.backend.product.add_product', compact('all_brands', 'all_vendors', 'all_category'));
        # code...
    }

    public function StoreProduct(Request $request){


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
            'vendor_id' => $request->vendor_id,
            'status' => 1,
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

        return redirect()->route('all.product')->with($notification); 

    } // End Method 

    public function EditProduct($id){
        $multiImgs = MultiImage::where('product_id',$id)->get();
        $activeVendor = User::where('status','active')->where('role','vendor')->latest()->get();
         $brands = Brand::latest()->get();
         $categories = Category::latest()->get();
         $subcategory = SubCategory::latest()->get();
         $products = Product::findOrFail($id);
         return view('admin.backend.product.edit_product',compact('brands','categories','activeVendor','products','subcategory','multiImgs'));
     }// End Method 

     public function UpdateProduct(Request $request){

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


       'vendor_id' => $request->vendor_id,
       'status' => 1,
       'created_at' => Carbon::now(), 

   ]);


    $notification = array(
       'message' => 'Product Updated Without Image Successfully',
       'alert-type' => 'success'
   );

   return redirect()->route('all.product')->with($notification); 

}// End Method 

        public function UpdateProductThambnail(Request $request){

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
        public function UpdateProductMultiimage(Request $request){

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

        public function MulitImageDelelte($id){
            $oldImg = MultiImage::findOrFail($id);
            unlink($oldImg->photo_name);

            MultiImage::findOrFail($id)->delete();

            $notification = array(
                'message' => 'Product Multi Image Deleted Successfully',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);

        }// End Method 

        public function ProductInactive($id){

            Product::findOrFail($id)->update(['status' => 0]);
            $notification = array(
                'message' => 'Product Inactive',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);

        }// End Method 


        public function ProductActive($id){

            Product::findOrFail($id)->update(['status' => 1]);
            $notification = array(
                'message' => 'Product Active',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);

        }// End Method 

        public function ProductDelete($id){

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
