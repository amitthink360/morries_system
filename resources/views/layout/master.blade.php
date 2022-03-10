<!DOCTYPE html>
<html>
<head>
  <title>Mikel Morris Admin</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- CSRF Token -->
  <meta name="_token" content="{{ csrf_token() }}">
  
  <link rel="shortcut icon" href="{{ asset('/favicon.png') }}">
	{!! Html::style('https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css') !!}
  <!-- plugin css -->
  {!! Html::style('assets/plugins/@mdi/font/css/materialdesignicons.min.css') !!}
  {!! Html::style('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') !!}
  <!-- end plugin css -->

  @stack('plugin-styles')

  <!-- common css -->
  {!! Html::style('public/css/app.css') !!}
  <!-- end common css -->

  @stack('style')
   {!! Html::script('https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js') !!}
</head>
<body data-base-url="{{url('/')}}">
<div id="wait-main" style="display:none;position: fixed;z-index: 10000;top: 0px;left:0;width: 100%;height: 100%;background: rgba(000,000,000,0.6);">
	<div id="wait" style="width:100px;height:100px;position:absolute;top:42%;left:49%;padding:2px;"><img src="{{ asset('assets/images/ajax-loader.gif') }}" width="100" height="100"></div>
</div>
  <div class="container-scroller" id="app">
    @include('layout.header')
    <div class="container-fluid page-body-wrapper">
      @include('layout.sidebar')
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
        @include('layout.footer')
      </div>
    </div>
  </div>

  <!-- base js -->
  {!! Html::script('js/app.js') !!}
  {!! Html::script('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') !!}
  <!-- end base js -->

  <!-- plugin js -->
  @stack('plugin-scripts')
  <!-- end plugin js -->

  <!-- common js -->
  {!! Html::script('https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js') !!}
  {!! Html::script('assets/js/off-canvas.js') !!}
  {!! Html::script('assets/js/hoverable-collapse.js') !!}
  {!! Html::script('assets/js/misc.js') !!}
  {!! Html::script('assets/js/settings.js') !!}
  {!! Html::script('assets/js/todolist.js') !!}
  <!-- end common js -->

  @stack('custom-scripts')
  
  <script>
	$(document).ready( function () {
		$('#myTable').DataTable();
	});
  </script>
</body>
</html>