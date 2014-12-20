<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>{{ $title }} :: HamroNeta.com</title>

    {{ Basset::show('admin.css') }}
</head>
<body>
<div class="container">
	@include('admin._partials.header')

	@yield('main')

    {{ Basset::show('admin.js') }}
</div>
</body>
</html>
