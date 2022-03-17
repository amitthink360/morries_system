@extends('layout.master')

@push('plugin-styles')
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
		<h4 class="card-title">Exercise Sets</h4>
		<div class="table-responsive">
          <table class="table table-striped" id="myTable">
            <thead>
              <tr>
                <th> Name </th>
                <th> Total Questions </th>
				<th> Action </th>
              </tr>
            </thead>
            <tbody>
				@if(!empty($exercises))
					@foreach($exercises as $exercise)
						<tr>
							<td>{{ $exercise->name }}</td>
							<td>{{ $exercise->questions_count }}</td>
							<td><a data-id="{{ $exercise->id }}" href="javascript:void(0);" class="btn btn-info btn-fw startExercise">Start</a></td>
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
<div id="startModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<form action="#" method="post" id="start_exercise_form" enctype="multipart/form-data">
		{!! csrf_field() !!}
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Start Exercise</h4>
				</div>
				<div class="modal-body">
					<div class="form-horizontal form-label-left">
						<strong>Choose Timing</strong>
						<div class="form-check">
						   <input class="form-check-input" type="radio" name="timing" id="timed2" value="no" checked>
						   <label class="form-check-label" for="timed2">
						   Untimed
						   </label>
						</div>
						<div class="form-check">
						   <input class="form-check-input" type="radio" name="timing" id="timed1" value="yes">
						   <label class="form-check-label" for="timed1">
						   Timed
						   </label>
						</div>
						
						<div class="form-group" id="mins_field" style="display:none;">
							<div class="input-group">
								<input type="number" name="exercise_time" class="form-control" value placeholder="Set time in minutes...">
							</div>
						</div>
						
						<strong>Do you want to see score?</strong>
						<div class="form-check">
						   <input class="form-check-input" type="radio" name="scored" id="score1" value="yes" checked>
						   <label class="form-check-label" for="score1">
						   Yes
						   </label>
						</div>
						<div class="form-check">
						   <input class="form-check-input" type="radio" name="scored" id="score2" value="no">
						   <label class="form-check-label" for="score2">
						   No
						   </label>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input name="exercise_id" type="hidden" value="" />
					<a href="javascript:void(0);" name="addcontacts" onclick="startExercise();" class="btn btn-primary btn-fw">Start</a>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	function startExercise() {
		formdata = $("#start_exercise_form").serialize();
		
		timing = $('input[name="timing"]:checked').val();
		if(timing == 'yes'){
			timevalue = $('input[name="exercise_time"]').val();
			
			if(timevalue == ""){
				alert("Please enter the time.");
				return false;
			}
		}
		
		$("#wait-main").css("display", "block");
		$.ajax({
			headers: {
			  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
			url: "{{ url('/exercise/start') }}",
			type: 'POST',
			data: formdata,
			success: function(result) {
										
				if(result.success === 'true'){
					location.href="{{ url('/exercise/startexercise') }}/"+result.uid;
				}else{
					$("#wait-main").css("display", "none");
					
					$(".error_register").text(result.error);
					$(".error_register").show();
				}
			}
		});
	}
	
	$("body").on("change", "input[type=radio][name=timing]", function(e) {
		
		if (this.value == 'yes') {
			$("#mins_field").show();
		}else {
			$("#mins_field").hide();
		}
	});
	
	$("body").on("click", ".startExercise", function(e) {
		$('#start_exercise_form').trigger("reset");
		exercise_id = $(this).attr('data-id');
		
		$("#start_exercise_form input[name='exercise_id']").val(exercise_id);
		$('#startModal').modal('show'); 
	});
</script>
@endsection

@push('plugin-scripts')
@endpush

@push('custom-scripts')
@endpush
