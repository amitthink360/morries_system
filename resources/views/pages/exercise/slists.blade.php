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
							<td><a href="{{ url('/exercise/view') }}/{{ $exercise->id }}" class="btn btn-info btn-fw">Start</a></td>
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
@endsection

@push('plugin-scripts')
@endpush

@push('custom-scripts')
@endpush
