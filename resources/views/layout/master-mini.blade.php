<!DOCTYPE html>
<html>
<head>
  <title>Mikel Morris System</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- CSRF Token -->
  <meta name="_token" content="{{ csrf_token() }}">
  
  <link rel="shortcut icon" href="{{ asset('/favicon.png') }}">

  <!-- plugin css -->
  {!! Html::style('assets/plugins/@mdi/font/css/materialdesignicons.min.css') !!}
  {!! Html::style('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') !!}
  <!-- end plugin css -->

  <!-- plugin css -->
  @stack('plugin-styles')
  <!-- end plugin css -->

  <!-- common css -->
  {!! Html::style('css/app.css') !!}
  <!-- end common css -->

  @stack('style')
</head>
<body data-base-url="{{url('/')}}">
<div id="wait-main" style="display:none;position: fixed;z-index: 10000;top: 0px;left:0;width: 100%;height: 100%;background: rgba(000,000,000,0.6);">
	<div id="wait" style="width:100px;height:100px;position:absolute;top:42%;left:49%;padding:2px;"><img src="{{ asset('assets/images/ajax-loader.gif') }}" width="100" height="100"></div>
</div>
  <div class="container-scroller" id="app">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      @yield('content')
    </div>
  </div>

    <!-- base js -->
    {!! Html::script('js/app.js') !!}
    <!-- end base js -->

    <!-- plugin js -->
    @stack('plugin-scripts')
    <!-- end plugin js -->

    @stack('custom-scripts')
</body>
</html>