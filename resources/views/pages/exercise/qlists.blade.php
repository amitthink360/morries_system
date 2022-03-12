@extends('layout.master')

@push('plugin-styles')
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
		<h4 class="card-title">Questions</h4>
		<a href="javascript:void(0);" class="btn btn-success btn-fw" style="float: right;" data-toggle="modal" data-target="#myModal">Add New</a>
        <div class="table-responsive">
          <table class="table table-striped" id="myTable">
            <thead>
              <tr>
                <th> Type </th>
                <th> Question </th>
                <th> Created At </th>
				<th> Action </th>
              </tr>
            </thead>
            <tbody>
				@if(!empty($questiondata))
					@foreach($questiondata as $question)
						<tr>
							<td>{{ $question['type'] }}</td>
							<td>@if($question['type_id'] == 2) {{ $question['answer'] }} @else {{ $question['question'] }} @endif</td>
							<td>{{ $question['created_at'] }}</td>
							<td><a href="javascript:void(0);" class="btn btn-primary btn-fw editQuestion" data-id="{{ $question['id'] }}">Edit</a>  <a href="{{ url('/question/delete') }}/{{ $exercise_id }}/{{ $question['id'] }}" class="btn btn-danger btn-fw" onclick="return confirm('Are you Sure?');">Delete</a></td>
						</tr>
					@endforeach
				@else
					<tr>                            
						<td colspan="5" align="center">No Question Found.</td>
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
		<form action="{{ url('/question/add') }}" method="post" id="question_form" enctype="multipart/form-data">
		{!! csrf_field() !!}
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add New</h4>
				</div>
				<div class="modal-body">
					<div class="form-horizontal form-label-left">
						<div class="form-group">
							<div class="input-group">
								<select class="form-control" name="question_type" onchange="getval(this);">
									<option value="">Question Type</option>
									@foreach (App\Types::all() as $type)
										<option value="{{ $type->id }}">{{ $type->name }}</option>
									@endforeach	
								</select>			
							</div>
						</div>
						<div class="form-group type_3" style="display:none;">
							<div class="input-group">
								<input type="file" name="mp3_file" />
							</div>
						</div>
						<div class="form-group type_r">
							<div class="input-group">
								<textarea class="form-control" id="ckeditor1" name="question"></textarea>
							</div>
						</div>
						<div class="form-group type_2">
							<div class="input-group">
								<input type="text" name="answer" class="form-control" placeholder="Answer...">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input name="exercise_id" type="hidden" value="{{ $exercise_id }}" />
					<button type="submit" name="addcontacts" class="btn btn-primary btn-fw">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>

<div id="editModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<form action="{{ url('/question/update') }}" method="post" id="edit_question_form" enctype="multipart/form-data">
		{!! csrf_field() !!}
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Exercise</h4>
				</div>
				<div class="modal-body">
					<div style="text-align: center;margin-bottom: 10px;"><span class="error_edit" style="color: #eb4d4b;display:none;"></span></div>
					<div class="form-horizontal form-label-left">
						<div class="form-horizontal form-label-left">
							<div class="form-group">
								<div class="input-group">
									<select class="form-control" name="question_type" onchange="getval(this);">
										<option value="">Question Type</option>
										@foreach (App\Types::all() as $type)
											<option value="{{ $type->id }}">{{ $type->name }}</option>
										@endforeach	
									</select>			
								</div>
							</div>
							<div class="form-group type_3" style="display:none;">
								<div class="input-group">
									<input type="file" name="mp3_file" />
								</div>
							</div>
							<div class="form-group type_r">
								<div class="input-group">
									<textarea class="form-control" id="ckeditor2" name="question"></textarea>
								</div>
							</div>
							<div class="form-group type_2">
								<div class="input-group">
									<input type="text" name="answer" class="form-control" placeholder="Answer...">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input name="exercise_id" type="hidden" value="{{ $exercise_id }}" />
					<input name="question_id" type="hidden" value="" />
					<button type="submit" name="addcontacts" class="btn btn-primary btn-fw">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	function getval(sel)
	{
		type = sel.value;
		if(type == 2){
			$(".type_3").hide();
			$(".type_r").hide();
		}else if(type == 3){
			$(".type_r").show();
			$(".type_3").show();
			$(".type_2").show();
		}else{
			$(".type_3").hide();
			$(".type_r").show();
			$(".type_2").show();
		}
	}
	
	$("body").on("click", ".editQuestion", function(e) {
		$("#wait-main").css("display", "block");		
		$('#edit_question_form').trigger("reset");
		question_id = $(this).attr('data-id');
		
		$("#edit_question_form input[name='question_id']").val(question_id);
		
		$.ajax({
			headers: {
			  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
			url: "{{ url('/question/getquestioninfo') }}/"+question_id,
			type: 'GET',
			dataType: 'json',
			success: function(result) {
			
				$("#edit_question_form select[name='question_type']").val(result['type_id']);
				//$("#ckeditor2").html(result['question']);
				CKEDITOR.instances["ckeditor2"].setData(result['question']);
				$("#edit_question_form input[name='answer']").val(result['answer']);
				
				if(result['type_id'] == 2){
					$(".type_3").hide();
					$(".type_r").hide();
				}else if(result['type_id'] == 3){
					$(".type_r").show();
					$(".type_3").show();
					$(".type_2").show();
				}else{
					$(".type_3").hide();
					$(".type_r").show();
					$(".type_2").show();
				}
				
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
