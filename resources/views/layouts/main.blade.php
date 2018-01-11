<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title></title>
	<link rel="stylesheet" type="text/css" href="{{asset("css/app.css")}}">
</head>
<body>
	<div id="app">
		<App user="{{$user}}"></App>
	</div>
	<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</body>
</html>