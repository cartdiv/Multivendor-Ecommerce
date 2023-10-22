<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class adminController extends Controller
{

    public function AdminDashboard()
    {
        return view('admin.index');
        # code...
    }

    public function AdminLogout(Request $request)
    {

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
        # code...
    }

    public function AdminLogin()
    {
        return view('admin.login');
        # code...
    }
     
    public function AdminProfile()
    {
        $id = Auth::user()->id;
        $admin_user = User::find($id);
        return view('admin.admin_profile_edit', compact('admin_user'));
        # code...
    }

    public function UpdateAdmin(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        if($request->file('photo')){
            $file = $request->file('photo');
            
            @unlink(public_path('upload/admin_image/'.$data->photo));

            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_image'),$filename);
            $data['photo'] = $filename;
           }
           $data->save();
    
           $nottification = array(
                'message' => "Admin Profile Updated Successfully",
                'alert-type' => 'success'
           );
    
           return redirect()->route('admin.profile')->with($nottification);
        # code...
    }

    public function ChangeAdminPassword()
    {
        return view('admin.admin_change_password');
        # code...
    }

    public function StoreAdminPassword(Request $request)
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
                'message' => 'Admin Password updated Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('admin.dashboard')->with($nottification);
        }else{
            $nottification = array(
                'message' => 'Check your Old Password',
                'alert-type' => 'error',
            );
            return redirect()->route('admin.dashboard')->with($nottification);
        }
        # code...
    }

    public function InactiveVendor()
    {
        $inActiveVendor = User::where('status', 'inactive')->where('role', 'vendor')->latest()->get();
        return view('admin.backend.vendor.inactive_vendor', compact('inActiveVendor'));
        
        # code...
    }
    
    public function ActiveVendor()
    {
        $activeVendor = User::where('status', 'active')->where('role','vendor')->latest()->get();
        return view('admin.backend.vendor.active_vendor', compact('activeVendor'));

        # code...
    }

    public function InactiveVendorDetails($id)
    {
        $inactiveVendorDetails = User::findOrFail($id);
        return view('admin.backend.vendor.inactive_vendor_details', compact('inactiveVendorDetails'));

        # code...
    }
    
    public function ActiveVendorDetails($id)
    {
        $activeVendorDetails = User::findOrFail($id);
        return view('admin.backend.vendor.active_vendor_details', compact('activeVendorDetails'));
        # code...
    }

    public function ActiveVendorApprove(Request $request)
    {
        $activevendorapprove_id = $request->id;
        $user = User::findOrFail($activevendorapprove_id)->update([
            'status' => 'active',

        ]);
        $nottification = array(
            'message' => 'Vendor Activated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('active.vendor')->with($nottification);
    }

    public function InactiveVendorApprove(Request $request)
    { 
        $inactivevendorapprove_id = $request->id;
        $user = User::findOrFail($inactivevendorapprove_id)->update([
            'status' => 'inactive',

        ]);
        $nottification = array(
            'message' => 'Vendor Is Now Inactive',
            'alert-type' => 'success',
        );
        return redirect()->route('inactive.vendor')->with($nottification);
        # code...
    }
    //
}
