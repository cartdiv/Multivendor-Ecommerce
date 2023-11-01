<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class vendorController extends Controller
{
    public function VendorDashboard()
    {
        return view('vendor.index');
        # code...
    }

    public function VendorLogin()
    {
        return view('vendor.login');
        # code...
    }
    public function VendorLogout(Request $request)
    {

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $nottification = array(
            'message' => 'Vendor Logout Successfully',
            'alert-type' => 'success',
        );
        return redirect('/vendor/login')->with($nottification);
        # code...
    }
     
    public function VendorProfile()
    {
        $id = Auth::user()->id;
        $vendor_user = User::find($id);
        return view('vendor.vendor_profile_edit', compact('vendor_user'));
        # code...
    }

    public function UpdateVendor(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->vendor_short_info = $request->vendor_short_info;
        if($request->file('photo')){
            $file = $request->file('photo');
            
            @unlink(public_path('upload/vendor_image/'.$data->photo));

            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/vendor_image'),$filename);
            $data['photo'] = $filename;
           }
           $data->save();
    
           $nottification = array(
                'message' => "Vendor Profile Updated Successfully",
                'alert-type' => 'success'
           );
    
           return redirect()->route('vendor.profile')->with($nottification);
        # code...
    }

    public function ChangeVendorPassword()
    {
        return view('vendor.vendor_change_password');
        # code...
    }

    public function StoreVendorPassword(Request $request)
    {
        $validateData = $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirm_password' => 'required|same:newpassword',

        ]);

        $hashedPassword = Auth::user()->password;
        if(Hash::check($request->oldpassword,$hashedPassword)){
            $users = user::find(Auth::id());
            $users->password = bcrypt($request->newpassword);
            $users->save();

            

            $nottification = array(
                'message' => 'Vendor Password updated Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('vendor.dashboard')->with($nottification);
        }else{
            $nottification = array(
                'message' => 'Check your Old Password',
                'alert-type' => 'error',
            );
            return redirect()->route('vendor.dashboard')->with($nottification);
        }
        # code...
    }



    //Become a vendor registration

    public function BecomeVendor()
    {
        return view('auth.become_vendor');
        # code...
    }

    public function VendorRegister(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::insert([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'vendor_short_info' => $request->vendor_short_info,
            'password' => Hash::make($request->password),
            'role' => 'vendor',
            'status' => 'inactive',

        ]);

        $nottification = array(
            'message' => 'Vendor Registered Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('vendor.login')->with($nottification);
        # code...
    }
    //
}
