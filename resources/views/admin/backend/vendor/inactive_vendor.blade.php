@extends('admin.admin_master')
@section('admin_main')

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Inactive vendors</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Inactive vendors</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
               
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Shop Name</th>
                                <th>Vendor username</th>
                                <th>vendor Email</th>
                                <th>vendor image</th>
                                <th>status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach($inActiveVendor as $key => $item)
                        <tbody>
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->username}}</td>
                                <td>{{$item->email}}</td>
                                <td><img src="{{asset($item->image)}}" style="width: 40px; height: 40px;" alt="" srcset=""></td>
                                <td><a href="{{route('edit.subcategory',$item->id)}}" class="btn btn-secondary px-3"title="Edit">{{$item->status}}</a></td>
                                <td><a href="{{route('inactive.vendor.details',$item->id)}}" class="btn btn-primary mb-1 mb-md-0">Vendor Details</a></td>
                            </tr>
                           
                        </tbody>
                        @endforeach
                        
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</div>
<!--end page wrapper -->

@endsection
