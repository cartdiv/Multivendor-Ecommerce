@php
     $id = Illuminate\Support\Facades\Auth::user()->id;
        $user_data = App\Models\User::find($id);
@endphp
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<div class="tab-pane fade" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
    <div class="card">
        <div class="card-header">
            <h5>Account Details</h5>
        </div>
        <div class="card-body">
            {{-- <p>Already have an account? <a href="page-login.html">Log in instead!</a></p> --}}
            <form method="POST" action="{{route('update.user')}}">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Full Name <span class="required">*</span></label>
                        <input class="form-control" name="name" type="text" value="{{$user_data->name}}" />
                    </div>
                    <div class="form-group col-md-6">
                        <label>Username <span class="required">*</span></label>
                        <input class="form-control" name="username" value="{{$user_data->username}}" disabled="" />
                    </div>
                   
                    <div class="form-group col-md-12">
                        <label>Email Address <span class="required">*</span></label>
                        <input class="form-control" name="email" type="email" value="{{$user_data->email}}"/>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Phone <span class="required">*</span></label>
                        <input class="form-control" name="phone" type="text" value="{{$user_data->phone}}" />
                    </div>
                    <div class="form-group col-md-12">
                        <label>Address <span class="required">*</span></label>
                        <input class="form-control" name="address" type="text" value="{{$user_data->address}}" />
                    </div>
                    <div class="col-md-6">
                        <label>Profile image <span class="required">*</span></label>
                      
                        <input type="file" class="form-control" id="image" name="photo" >
                    </div>
                    <div class="form-group col-md-6">
                        <label><span class="required">*</span></label>
                        <img id="showImage" src="{{ (!empty($user_data->photo))? url('upload/admin_image/'.$user_data->photo):url('upload/no_image.jpg') }}" class="rounded-circle p-1 border" width="90" height="90" alt="Avatar">
                       
                    </div>
                    {{-- <div class="form-group col-md-12">
                        <label>Current Password <span class="required">*</span></label>
                        <input class="form-control" name="password" type="password" />
                    </div>
                    <div class="form-group col-md-12">
                        <label>New Password <span class="required">*</span></label>
                        <input class="form-control" name="npassword" type="password" />
                    </div>
                    <div class="form-group col-md-12">
                        <label>Confirm Password <span class="required">*</span></label>
                        <input class="form-control" name="cpassword" type="password" />
                    </div> --}}
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Save Change</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

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