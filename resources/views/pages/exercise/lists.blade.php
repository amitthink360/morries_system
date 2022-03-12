@extends('layout.master')

@push('plugin-styles')
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
		<h4 class="card-title">Exercise Sets</h4>
		<a href="javascript:void(0);" class="btn btn-success btn-fw" style="float: right;" data-toggle="modal" data-target="#myModal">Add New</a>
        <div class="table-responsive">
          <table class="table table-striped" id="myTable">
            <thead>
              <tr>
                <th> Name </th>
                <th> Total Questions </th>
				<th> Date Added </th>
				<th> Action </th>
              </tr>
            </thead>
            <tbody>
				@if(!empty($exercises))
					@foreach($exercises as $exercise)
						<tr>
							<td>{{ $exercise->name }}</td>
							<td>{{ $exercise->questions_count }}</td>
							<td>{{ $exercise->created_at }}</td>
							<td><a href="javascript:void(0);" class="btn btn-primary btn-fw editExercise" data-id="{{ $exercise->id }}">Edit</a>  <a href="{{ url('admin/exercise/view') }}/{{ $exercise->id }}" class="btn btn-info btn-fw">View Questions</a>  <a href="{{ url('admin/exercise/delete') }}/{{ $exercise->id }}" class="btn btn-danger btn-fw" onclick="return confirm('Are you Sure?');">Delete</a></td>
						</tr>
					@endforeach
				@else
					<tr>                            
						<td colspan="5" align="center">No Exercise Found.</td>
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
		<form action="{{ url('admin/exercise/add') }}" method="post" id="exercise_form" enctype="multipart/form-data">
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
								<input type="text" name="set_name" class="form-control" placeholder="Name" required>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="javascript:void(0);" name="addcontacts" onclick="addExercise();" class="btn btn-primary btn-fw">Submit</a>
				</div>
			</div>
		</form>
	</div>
</div>

<div id="editModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<form action="{{ url('admin/exercise/update') }}" method="post" id="edit_exercise_form" enctype="multipart/form-data">
		{!! csrf_field() !!}
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Exercise</h4>
				</div>
				<div class="modal-body">
					<div style="text-align: center;margin-bottom: 10px;"><span class="error_edit" style="color: #eb4d4b;display:none;"></span></div>
					<div class="form-horizontal form-label-left">
						<div class="form-group">
							<div class="input-group">
								<input type="text" name="set_name" class="form-control" placeholder="Name" required>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input name="exercise_id" type="hidden" value="" />
					<a href="javascript:void(0);" name="addcontacts" onclick="editExercise();" class="btn btn-primary btn-fw">Submit</a>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	function addExercise() {
		$("#wait-main").css("display", "block");
		
		formdata = $("#exercise_form").serialize();
		
		$.ajax({
			headers: {
			  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
			url: "{{ url('admin/exercise/add') }}",
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
	
	function editExercise() {
		$("#wait-main").css("display", "block");
		
		formdata = $("#edit_exercise_form").serialize();
		
		$.ajax({
			headers: {
			  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
			url: "{{ url('admin/exercise/update') }}",
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
	
	$("body").on("click", ".editExercise", function(e) {
		$("#wait-main").css("display", "block");		
		$('#edit_exercise_form').trigger("reset");
		exercise_id = $(this).attr('data-id');
		
		$("#edit_exercise_form input[name='exercise_id']").val(exercise_id);
		
		$.ajax({
			headers: {
			  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
			url: "{{ url('admin/exercise/getexerciseinfo') }}/"+exercise_id,
			type: 'GET',
			dataType: 'json',
			success: function(result) {
			
				$("#edit_exercise_form input[name='set_name']").val(result['name']);
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
