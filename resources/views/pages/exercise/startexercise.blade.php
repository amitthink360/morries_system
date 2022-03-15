@extends('layout.master')

@push('plugin-styles')
  {!! Html::style('/assets/plugins/dragula/dragula.min.css') !!}
@endpush

@section('content')
	<div class="row">
	  <div class="col-lg-12 grid-margin stretch-card exercise_test">
		<div class="card">
		  <div class="card-body">
			<h4 class="card-title">Exercise Test</h4>@if($testinfo->timing == "yes")<div class="countdown_tiles" style="display:inline-block;"></div>@endif<span class="score" @if($testinfo->scored == "no") style="float:right;" @endif>Score: <b>0</b></span>@if($testinfo->scored == "yes")<div id="fixture"></div>@endif
			<div class="table-responsive">
				<div class="col-lg-12 grid-margin stretch-card">
					<div class="col-lg-6 grid-margin">
						<div class="form-group">
							<div class="input-group">	
								<textarea class="form-control" rows="15" readonly placeholder="Question..."></textarea>
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
								<textarea class="form-control" rows="15" placeholder="Answer here..."></textarea>
							</div>
						</div>
					</div>
					<div class="col-lg-6 grid-margin">
						<div class="form-group">
							<div class="input-group">	
								<textarea class="form-control" rows="15" readonly placeholder="Result..."></textarea>
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

	  addScore(0, $("#fixture"));
	});
	
	@if($testinfo->timing == "yes")

		var target_date = new Date().getTime() + (1000*60*{{ $testinfo->exercise_time }}); // 10 minutes
		var days, hours, minutes, seconds, miliseconds; // variables for time units
		var countdown = document.getElementsByClassName("countdown_tiles"); // get tag element

		getCountdown();
		var counter = setInterval(function () { getCountdown(); });

		function getCountdown(){

			// find the amount of "seconds" between now and target
			var current_date = new Date().getTime();
			var seconds_left = (target_date - current_date) / 1000;

			days = pad( parseInt(seconds_left / 86400) );
			seconds_left = seconds_left % 86400;

			hours = pad( parseInt(seconds_left / 3600) );
			seconds_left = seconds_left % 3600;

			if(seconds_left <= 1){
				minutes = 0;
				seconds = 0;
				miliseconds = 0;

			} else {
				minutes = pad( parseInt(seconds_left / 60) );
				seconds = pad( parseInt( seconds_left % 60 ) );
				var d = new Date();
				var n = d.getMilliseconds();
				n = 99 -(n/10);
				if (n < 0) {
					n = 0;
				}
				miliseconds = pad((n).toFixed(0));
			}
			// format countdown string + set tag value
			$(".countdown_tiles").html('<div style="font-size:22px;font-weight:500;">Time Left: '+ minutes +' : '+ seconds +'</div>');

			
		}
		
		function pad(n) {
			return (n < 10 ? '0' : '') + n;
		}
	@endif
	</script>
@endsection

@push('plugin-scripts')
  {!! Html::script('/assets/plugins/dragula/dragula.min.js') !!}
@endpush

@push('custom-scripts')
  {!! Html::script('/assets/js/dragula.js') !!}
@endpush