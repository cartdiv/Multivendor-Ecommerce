<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

use function Pest\Laravel\delete;

class categoryController extends Controller
{
    public function AllCategory()
    {
        $all_categories = Category::latest()->get();
        return view('admin.backend.category.all_category', compact('all_categories'));
        # code...
    }

    public function AddCategory()
    {
        return view('admin.backend.category.add_category');
        # code...
    }

    public function StoreCategory(Request $request)
    {
        $request->validate([
            'category_image' => 'mimes:doc,pdf,docx,zip,jpeg,png,jpg,gif,svg',
        ]);

        $image = $request->file('category_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/category/'.$name_gen);
        $save_url = 'upload/category/'.$name_gen;

        Category::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-',$request->category_name)),
            'category_image' => $save_url,
        ]);

        $nottification = array(
            'message' => "Category Add Successfully",
            'alert-type' => 'success'
       );

       return redirect()->route('all.category')->with($nottification);

        # code...
    }
    
    public function EditCategory($id)
    {
        $edit_category = Category::findOrFail($id);
        return view('admin.backend.category.edit_category', compact('edit_category'));
        # code...
    }

    public function UpdateCategory(Request $request)
    {
       
        $category_id = $request->id; 

        if($image = $request->file('category_image')){
      
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save('upload/category/'.$name_gen);
            $save_url = 'upload/category/'.$name_gen;

            category::findOrFail($category_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ', '-',$request->category_name)),
                'category_image' => $save_url,
            ]);

            $nottification = array(
                'message' => "Category Add Successfully",
                'alert-type' => 'success'
        );

        return redirect()->route('all.category')->with($nottification);
        }else {
            category::findOrFail($category_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ', '-',$request->category_name)),
            ]);

            $nottification = array(
                'message' => "Category Add Successfully",
                'alert-type' => 'success'
        );

        return redirect()->route('all.category')->with($nottification);
        }
        # code...
    }


    public function DeleteCategory($id)
    {
        $delete = Category::findOrFail($id);
        $img = $delete->category_image;
        unlink($img);
        Category::findOrFail($id)->delete();

        $subcategorys = Subcategory::where('category_id', $id)->get();
        foreach($subcategorys as $subcategory){
            unlink($subcategory->subcategory_image);
            Subcategory::where('category_id', $id)->delete();
        }

        $nottification = array(
            'message' => "Category Deleted Successfully",
            'alert-type' => 'success'
       );

       return redirect()->back()->with($nottification);
        # code...
    }
    //
}
