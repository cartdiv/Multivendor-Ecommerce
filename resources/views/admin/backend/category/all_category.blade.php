@extends('admin.admin_master')
@section('admin_main')

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Category</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Category</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{route('add.category')}}">
                    <button type="button" class="btn btn-primary" >Add Category</button>
                </a>
                </div>
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
                                <th>Category Name</th>
                                <th>Category Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach($all_categories as $key => $all_category)
                        <tbody>
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$all_category->category_name}}</td>
                                <td><img src="{{asset($all_category->category_image)}}" style="width: 40px; height: 40px;" alt="" srcset=""></td>
                                <td>
                                    <a href="{{route('edit.category',$all_category->id)}}" class="btn btn-primary mb-1 mb-md-0" title="Edit"> <i data-feather="edit"></i></a>
                                   
                                    <a href="{{route('delete.category',$all_category->id)}}" id="delete" class="btn btn-danger mb-1 mb-md-0" title="Delete"><i data-feather="trash-2"></i></a>
                                </td>
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
