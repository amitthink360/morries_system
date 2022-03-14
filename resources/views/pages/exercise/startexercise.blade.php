@extends('layout.master')

@push('plugin-styles')
  {!! Html::style('/assets/plugins/dragula/dragula.min.css') !!}
@endpush

@section('content')
	<div class="row">
	  <div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
		  <div class="card-body">
			<h4 class="card-title">Exercise Test</h4><span class="score">Score: <b>10</b></span><div id="fixture"></div>
			<div class="table-responsive">
				<div class="col-lg-12 grid-margin stretch-card">
					<div class="col-lg-6 grid-margin">
						<div class="form-group">
							<div class="input-group">	
								<textarea class="form-control" rows="20" readonly placeholder="Question..."></textarea>
							</div>
						</div>
					</div>
					<div class="col-lg-6 grid-margin">
						<div class="form-group">
							<div class="input-group">	
								<img src="{{ asset('assets/images/dummy.gif') }}" width="550" height="270">
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12 grid-margin stretch-card">
					<div class="col-lg-6 grid-margin">
						<div class="form-group">
							<div class="input-group">	
								<textarea class="form-control" rows="20" placeholder="Answer here..."></textarea>
							</div>
						</div>
					</div>
					<div class="col-lg-6 grid-margin">
						<div class="form-group">
							<div class="input-group">	
								<textarea class="form-control" rows="20" readonly placeholder="Result..."></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	<script>
	$(function() {
	  function addScore(score, $domElement) {
		$("<span class='stars-container'>")
		  .addClass("stars-" + score.toString())
		  .text("★★★★★")
		  .appendTo($domElement);
	  }

	  addScore(50, $("#fixture"));
	});
	</script>
@endsection

@push('plugin-scripts')
  {!! Html::script('/assets/plugins/dragula/dragula.min.js') !!}
@endpush

@push('custom-scripts')
  {!! Html::script('/assets/js/dragula.js') !!}
@endpush