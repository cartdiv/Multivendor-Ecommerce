
<div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
    <div class="card">
        <div class="card-header">
            <h5>Change Password</h5>
        </div>
        <div class="card-body">
            {{-- <p>Already have an account? <a href="page-login.html">Log in instead!</a></p> --}}
            <form method="POST" action="{{route('store.user.password')}}">
                @csrf
                <div class="row">
                    
                    <div class="form-group col-md-12">
                        <label>Current Password <span class="required">*</span></label>
                        <input class="form-control" name="oldpassword" type="password" />
                    </div>
                    <div class="form-group col-md-12">
                        <label>New Password <span class="required">*</span></label>
                        <input class="form-control" name="newpassword" type="password" />
                    </div>
                    <div class="form-group col-md-12">
                        <label>Confirm Password <span class="required">*</span></label>
                        <input class="form-control" name="confirm_password" type="password" />
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Save Change</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>