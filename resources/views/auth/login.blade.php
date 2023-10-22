@extends('frontend.frontend_master')
@section('frontend_main')
		
<main class="main pages">
	<div class="page-header breadcrumb-wrap">
		<div class="container">
			<div class="breadcrumb">
				<a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
				<span></span> Pages <span></span> My Account
			</div>
		</div>
	</div>
	<div class="page-content pt-150 pb-150">
		<div class="container">
			<div class="row">
				<div class="col-xl-8 col-lg-10 col-md-12 m-auto">
					<div class="row">
						<div class="col-lg-6 pr-30 d-none d-lg-block">
							<img class="border-radius-15" src="{{asset('frontend/assets/imgs/page/login-1.png')}}" alt="" />
						</div>
						<div class="col-lg-6 col-md-8">
							<div class="login_wrap widget-taber-content background-white">
								<div class="padding_eight_all bg-white">
									<div class="heading_s1">
										
										<h1 class="mb-5">Login</h1>
										<p class="mb-30">Don't have an account? <a href="{{route('register')}}">Create here</a></p>
									</div>
									
									<form method="POST" action="{{ route('login') }}">
										@csrf
										<x-input-error :messages="$errors->get('login')" class="mt-2" />
										<x-input-error :messages="$errors->get('password')" class="mt-2" />
										<div class="col-12 form-group">
											<input type="text"  name="login" id="inputEmailAddress" placeholder="Username">
										</div><br>
										<div class="col-12 form-group">
											<div class="input-group" id="show_hide_password">
												<input type="password" name="password" placeholder="Password">
											</div>
										</div>
										<br>
										<div class="col-md-6">	<a href="{{ route('password.request') }}">Forgot Password ?</a>
										</div>
										<br>
										<div class="col-12">
											<div class="d-grid">
												<button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Sign in</button>
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
</main>
		


@endsection