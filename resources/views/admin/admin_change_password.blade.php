@extends('admin.admin_master')
@section('admin_main')

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content"> 
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Change Admin Password</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Change Admin Password</li>
                    </ol>
                </nav>
            </div>
            
        </div>
        <!--end breadcrumb-->
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{route('store.admin.password')}}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Old Password:</label>
                                    <input type="password" name="oldpassword" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">New Password:</label>
                                    <input type="password" name="newpassword" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm Password:</label>
                                    <input type="password" name="confirm_password" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end page wrapper -->

@endsection