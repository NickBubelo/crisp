<!DOCTYPE html>
<html>
<head lang='ru-UA'>
	<title>Тестовое задание по сокращению ссылок</title>
	<meta charset='UTF-8' />
	<meta name='viewport' content='width=device-width, initial-scale=1.0' />
	<link rel='stylesheet' type='text/css' href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css' />
	<link rel='stylesheet' type='text/css' href='css/app.css' />
</head>
<body>

@include ('form')

<p>Все короткие ссылки:</p>
<ul>
@foreach ($links as $link)
	<li><a href='{{ $url }}/{{ $link->shortlink }}' target='_blank'>{{ $url }}/{{ $link->shortlink }}</a> <!-- counter: {{ $link->counter }}, lifetaime: {{ $link->lifetime }} --> </li>
@endforeach
</ul>

</body>
</html>
