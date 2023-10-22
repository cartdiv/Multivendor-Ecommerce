@extends('admin.admin_master')
@section('admin_main')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content"> 
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Edit Category</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Edit Category</li>
							</ol>
						</nav>
					</div>
					
				</div>
				<!--end breadcrumb-->
				<div class="container">
					<div class="main-body">
						<div class="row">
							
							<div class="col-lg-8">
								<div class="card">
									<div class="card-body">
                                        <h3>Edit Category</h3>
                                        <br>
                                        
                                        <form  method="POST" action="{{route('update.category')}}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$edit_category->id}}">
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Category Name</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" class="form-control" name="category_name" value="{{$edit_category->category_name}}" >
											</div>
										</div>
										
                                        <div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Category Image</h6>
											</div>
                                            <div class="col-sm-9 text-secondary">
												<input type="file" class="form-control" id="image" name="category_image">
                                            </div>
										</div>
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                            <div class="col-sm-10">
                                                <img id="showImage" src="{{ asset($edit_category->category_image) }}" class="rounded-circle p-1 border" width="90" height="90" alt="Avatar">
                                            </div>
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
		</div>
		<!--end page wrapper -->
        <script type="text/javascript">

            $(document).ready(function(){
                $('#image').change(function(e){
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('#showImage').attr('src',e.target.result);
                    }
                    reader.readAsDataURL(e.target.files['0']);
                });
            });
        
        </script>

@endsection