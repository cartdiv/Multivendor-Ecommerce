<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
class brandController extends Controller
{
    public function AllBrand()
    {
        $all_brand = Brand::latest()->get();
        return view('admin.backend.brand.all_brand', compact('all_brand'));
        # code...
    }

    public function AddBrand()
    {
        return view('admin.backend.brand.add_brand');
        # code...
    }

    public function StoreBrand(Request $request)
    {
        $image = $request->file('brand_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);
        $save_url = 'upload/brand/'.$name_gen;

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_slug' => strtolower(str_replace(' ', '-',$request->brand_name)),
            'brand_image' => $save_url,
        ]);

        $nottification = array(
            'message' => "Brand Add Successfully",
            'alert-type' => 'success'
       );

       return redirect()->route('all.brand')->with($nottification);
        # code...
    }

    public function EditBrand($id)
    {
        $edit_brand = Brand::findOrFail($id);
        return view('admin.backend.brand.edit_brand', compact('edit_brand'));
        # code...
    }

    public function UpdateBrand(Request $request)
    {
        $brand_id = $request->id; 

        if($image = $request->file('brand_image')){
      
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);
            $save_url = 'upload/brand/'.$name_gen;

            Brand::findOrFail($brand_id)->update([
                'brand_name' => $request->brand_name,
                'brand_slug' => strtolower(str_replace(' ', '-',$request->brand_name)),
                'brand_image' => $save_url,
            ]);

            $nottification = array(
                'message' => "Brand Add Successfully",
                'alert-type' => 'success'
        );

        return redirect()->route('all.brand')->with($nottification);
        }else {
            Brand::findOrFail($brand_id)->update([
                'brand_name' => $request->brand_name,
                'brand_slug' => strtolower(str_replace(' ', '-',$request->brand_name)),
            ]);

            $nottification = array(
                'message' => "Brand Add Successfully",
                'alert-type' => 'success'
        );

        return redirect()->route('all.brand')->with($nottification);
        }
        

        # code...
    }

    public function DeleteBrand($id)
    {
        $delete = Brand::findOrFail($id);
        
        $img = $delete->brand_image;
        unlink($img);
        Brand::findOrFail($id)->delete();
    
        $nottification = array(
            'message' => "Branded delected Successfully",
            'alert-type' => 'success'
       );
    
       return redirect()->back()->with($nottification);
        # code...
    }
    //
}
