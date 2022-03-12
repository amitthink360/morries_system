@extends('layout.master-mini')
@section('content')

<div class="content-wrapper d-flex align-items-center justify-content-center auth theme-one" style="background-image: url({{ url('assets/images/auth/login_1.jpg') }}); background-size: cover;">
  <div class="row w-100">
    <div class="col-lg-4 mx-auto">
      <div class="auto-form-wrapper">
        <form name="myForm" id="member_login" class="myForm" action="#" method="post">
		  <div style="text-align: center;"><span class="error_login" style="color: #eb4d4b;display:none;">Email Or Password is wrong.</span></div>	
          <div class="form-group">
            <label class="label">Username</label>
            <div class="input-group">
              <input type="email" class="form-control" name="email" id="email" placeholder="Email Address...">
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="mdi mdi-check-circle-outline"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="label">Password</label>
            <div class="input-group">
              <input type="password" name="password" id="password" class="form-control" placeholder="*********">
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="mdi mdi-check-circle-outline"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <a class="btn btn-primary submit-btn btn-block" onclick="login();">Login</a>
          </div>
          <div class="form-group d-flex justify-content-between">
            <div class="form-check form-check-flat mt-0">
              <label class="form-check-label"></label>
            </div>
            <a href="#" class="text-small forgot-password text-black">Forgot Password</a>
          </div>
        </form>
      </div>
      <ul class="auth-footer">
      </ul>
      <p class="footer-text text-center">copyright © 2022 MikelMorris.com. All rights reserved.</p>
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>

	$('#email, #password').keypress(function (event) {
        if (event.which == 13) {
            event.preventDefault();
            login();
        }
    });

	function login() {
		
		$("#wait-main").css("display", "block");
		
		formdata = $("#member_login").serialize();
		
		$.ajax({
			headers: {
			  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
			url: "{{ url('/doLogin') }}",
			type: 'POST',
			data: formdata,
			success: function(result) {
										
				if(result.success === 'true' && result.role === 'admin'){
					location.href = "students";
				}else if(result.success === 'true' && result.role === 'student'){
					location.href = "exercise";
				}else{
					$("#wait-main").css("display", "none");
					
					$(".error_login").show();
				}
			}
		});
	}
</script>
@endsection