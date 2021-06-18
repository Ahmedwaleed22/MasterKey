<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Master Key</title>
	<link rel=stylesheet href="{{ mix('css/app.css') }}" />
	<script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer></script>
</head>
<body>
	<div id="app">
		<router-view></router-view>
	</div>
	<noscript>Sorry This Website Can't Load Without JavaScript Enabled</noscript>
	<script src="https://unpkg.com/vue-recaptcha@latest/dist/vue-recaptcha.min.js"></script>
	<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>