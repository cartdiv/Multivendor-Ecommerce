@extends('admin.admin_master')
@section('admin_main')

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Products</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Product  <span class="badge rounded-pill bg-danger"> {{ count($all_product) }} </span> </li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{route('add.product')}}">
                    <button type="button" class="btn btn-primary" >Add Products</button>
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
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Discount</th>
                                <th>Status</th>
                                <th>Product Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach($all_product as $key => $item)
                        <tbody>
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->product_name}}</td>
                                <td>{{$item->selling_price}}</td>
                                <td>{{$item->product_qty}}</td>
                                <td>
                                    @if($item->discount_price == NULL)
                                        <span class="badge rounded-pill bg-info">No Discount</span>
                                    @else
                                    @php
                                        $amount = $item->selling_price - $item->discount_price;
                                        $discount = ($amount/$item->selling_price) * 100;
                                    @endphp
                                        <span class="badge rounded-pill bg-danger"> {{ round($discount) }}%</span>
                                    @endif
                                </td>
                                <td> 
                                    @if($item->status == 1)
                                    <span class="badge rounded-pill bg-success">Active</span>
                                    @else
                                    <span class="badge rounded-pill bg-danger">InActive</span>
                                    @endif
                                </td>
                                <td><img src="{{asset($item->product_thumbnail)}}" style="width: 40px; height: 40px;" alt="" srcset=""></td>
                                
                
                
                
                                
                
                                <td>
                <a href="{{ route('edit.product',$item->id) }}" class="btn btn-info" title="Edit Data"> <i class="fa fa-pencil"></i> </a>
                <a href="{{ route('delete.product',$item->id) }}" class="btn btn-danger" id="delete" title="Delete Data" ><i class="fa fa-trash"></i></a>
                
                <a href="{{ route('edit.category',$item->id) }}" class="btn btn-warning" title="Details Page"> <i class="fa fa-eye"></i> </a>
                
                @if($item->status == 1)
                <a href="{{ route('product.inactive',$item->id) }}" class="btn btn-primary" title="Inactive"> <i class="fa-solid fa-thumbs-down"></i> </a>
                @else
                <a href="{{ route('product.active',$item->id) }}" class="btn btn-primary" title="Active"> <i class="fa-solid fa-thumbs-up"></i> </a>
                @endif
                
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
