<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Subcategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Unique;
use Image;

class subcategoryController extends Controller
{
    public function AllSubcategory()
    {
        $all_subcategories = Subcategory::latest()->get();
        return view('admin.backend.subcategory.all_subcategory', compact('all_subcategories'));
        # code...
    }

    public function AddSubcategory()
    {
        $category = Category::orderBy('category_name', 'ASC')->get();
        return view('admin.backend.subcategory.add_subcategory', compact('category'));
        # code...
    }

    public function StoreSubcategory(Request $request)
    {
        if($image = $request->file('subcategory_image')){
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save('upload/subcategory/'.$name_gen);
    
            $save_url = 'upload/subcategory/'.$name_gen;
    
            Subcategory::insert([
                'subcategory_name' => $request->subcategory_name,
                'category_id' => $request->category_id,
                'subcategory_slug' => strtolower(str_replace(' ', '-',$request->subcategory_name)),
                'subcategory_image'=> $save_url,
            ]);
        }else{
            Subcategory::insert([
                'subcategory_name' => $request->subcategory_name,
                'category_id' => $request->category_id,
                'subcategory_slug' => strtolower(str_replace(' ', '-',$request->subcategory_name)),
            ]);
        }
       

        $nottification = array(
            'message' => "subcategory Add Successfully",
            'alert-type' => 'success'
       );

       return redirect()->route('all.subcategory')->with($nottification);
        # code...
    }

    public function EditSubcategory($id)
    {
        $edit_subcategory = Subcategory::findOrFail($id);
        $category = Category::orderBy('category_name', 'ASC')->get();
        return view('admin.backend.subcategory.edit_subcategory', compact('edit_subcategory','category'));
        # code...
    }

    public function UpdateSubcategory(Request $request)
    {
        $subcategory_id = $request->id;
        if($image = $request->file('subcategory_image')){
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save('upload/subcategory'.$name_gen);
            $save_url = 'upload/subcategory'.$name_gen;

            Subcategory::findOrFail($subcategory_id)->update([
                'subcategory_name' => $request->subcategory_name,
                'category_id' => $request->category_id,
                'subcategory_slug' => strtolower(str_replace(' ', '-',$request->subcategory_name)),
                'subcategory_image'=> $save_url,
            ]);

            $nottification = array(
                'message' => "subcategory Updated Successfully",
                'alert-type' => 'success'
           );
    
           return redirect()->route('all.subcategory')->with($nottification);

        }else{
            Subcategory::findOrFail($subcategory_id)->update([
                'subcategory_name' => $request->subcategory_name,
                'category_id' => $request->category_id,
                'subcategory_slug' => strtolower(str_replace(' ', '-',$request->subcategory_name)),
            ]);

            $nottification = array(
                'message' => "subcategory Updated Successfully",
                'alert-type' => 'success'
           );
    
           return redirect()->route('all.subcategory')->with($nottification);
        }
        # code...
    }


    public function DeleteSubcategory($id)
    {
        $delete = Subcategory::findOrFail($id);
        $image = $delete->subcategory_image;

        unlink($image);

        Subcategory::findOrFail($id)->delete();
        $nottification = array(
            'message' => "Subcategory Deleted Successfully",
            'alert-type' => 'success'
       );

       return redirect()->back()->with($nottification);
        # code...
    }
    public function GetSubCategory($category_id){
        $subcat = SubCategory::where('category_id',$category_id)->orderBy('subcategory_name','ASC')->get();
            return json_encode($subcat);

    }// End Method 
    //
}
