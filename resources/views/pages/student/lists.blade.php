@extends('layout.master')

@push('plugin-styles')
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
		<h4 class="card-title">Students</h4>
		<a href="javascript:void(0);" class="btn btn-success btn-fw" style="float: right;" data-toggle="modal" data-target="#myModal">Add New</a>
        <div class="table-responsive">
          <table class="table table-striped" id="myTable">
            <thead>
              <tr>
                <th> Name </th>
                <th> Email </th>
                <th> Membership </th>
                <th> Last Login </th>
				<th> Date Added </th>
				<th> Action </th>
              </tr>
            </thead>
            <tbody>
				@if(!empty($students))
					@foreach($students as $student)
						<tr>
							<td>{{ $student->name }}</td>
							<td>{{ $student->email }}</td>
							<td>{{ $student->membership }}</td>
							<td>{{ $student->last_login }}</td>
							<td>{{ $student->created_at }}</td>
							<td><a href="javascript:void(0);" class="btn btn-primary btn-fw editStudent" data-id="{{ $student->id }}">Edit</a>  <a href="{{ url('admin/student/delete') }}/{{ $student->id }}" class="btn btn-danger btn-fw" onclick="return confirm('Are you Sure?');">Delete</a></td>
						</tr>
					@endforeach
				@else
					<tr>                            
						<td colspan="5" align="center">No Student Found.</td>
					</tr>
				@endif 
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<form action="{{ url('admin/student/add') }}" method="post" id="register_form" enctype="multipart/form-data">
		{!! csrf_field() !!}
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add New</h4>
				</div>
				<div class="modal-body">
					<div style="text-align: center;margin-bottom: 10px;"><span class="error_register" style="color: #eb4d4b;display:none;"></span></div>	
					<div class="form-horizontal form-label-left">
						<div class="form-group">
							<div class="input-group">
								<input type="text" name="student_name" class="form-control" placeholder="Name" required>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<input type="email" name="student_email" class="form-control" placeholder="Email" required>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<input type="password" name="student_password" class="form-control" placeholder="Password" required>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<select class="form-control" name="membership">
									<option value="Basic">Basic</option>
									<option value="Pro">Pro</option>
								</select>								
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="javascript:void(0);" name="addcontacts" onclick="register();" class="btn btn-primary btn-fw">Submit</a>
				</div>
			</div>
		</form>
	</div>
</div>

<div id="editModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<form action="{{ url('admin/student/update') }}" method="post" id="edit_register_form" enctype="multipart/form-data">
		{!! csrf_field() !!}
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Student</h4>
				</div>
				<div class="modal-body">
					<div style="text-align: center;margin-bottom: 10px;"><span class="error_edit" style="color: #eb4d4b;display:none;"></span></div>
					<div class="form-horizontal form-label-left">
						<div class="form-group">
							<div class="input-group">
								<input type="text" name="student_name" class="form-control" placeholder="Name" required>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<input type="email" name="student_email" class="form-control" placeholder="Email" readonly>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<input type="password" name="student_password" class="form-control" placeholder="Password" required>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<select class="form-control" name="membership">
									<option value="Basic">Basic</option>
									<option value="Pro">Pro</option>
								</select>								
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input name="student_id" type="hidden" value="" />
					<a href="javascript:void(0);" name="addcontacts" onclick="editStudent();" class="btn btn-primary btn-fw">Submit</a>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	function register() {
		$("#wait-main").css("display", "block");
		
		formdata = $("#register_form").serialize();
		
		$.ajax({
			headers: {
			  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
			url: "{{ url('admin/student/add') }}",
			type: 'POST',
			data: formdata,
			success: function(result) {
										
				if(result.success === 'true'){
					location.reload();
				}else{
					$("#wait-main").css("display", "none");
					
					$(".error_register").text(result.error);
					$(".error_register").show();
				}
			}
		});
	}
	
	function editStudent() {
		$("#wait-main").css("display", "block");
		
		formdata = $("#edit_register_form").serialize();
		
		$.ajax({
			headers: {
			  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
			url: "{{ url('admin/student/update') }}",
			type: 'POST',
			data: formdata,
			success: function(result) {
										
				if(result.success === 'true'){
					location.reload();
				}else{
					$("#wait-main").css("display", "none");
					
					$(".error_edit").text(result.error);
					$(".error_edit").show();
				}
			}
		});
	}
	
	$("body").on("click", ".editStudent", function(e) {
		$("#wait-main").css("display", "block");		
		$('#edit_register_form').trigger("reset");
		student_id = $(this).attr('data-id');
		
		$("#edit_register_form input[name='student_id']").val(student_id);
		
		$.ajax({
			headers: {
			  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: "{{ url('admin/student/getstudentinfo') }}/"+student_id,
			type: 'GET',
			dataType: 'json',
			success: function(result) {
			
				$("#edit_register_form input[name='student_name']").val(result['name']);
				$("#edit_register_form input[name='student_email']").val(result['email']);
				$("#edit_register_form input[name='membership']").val(result['membership']);
				$("#wait-main").css("display", "none");
				$('#editModal').modal('show'); 
			}
		});
		
	});
</script>
@endsection

@push('plugin-scripts')
@endpush

@push('custom-scripts')
@endpush
