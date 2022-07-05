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

@switch($result)
    @case('update')
		<p>Ссылка <a href='{{ $sourceLink }}' target='_blank'>{{ $sourceLink }}</a> уже есть в базе данных.</p>
		<p>Короткая ссылка для нее: <a href='{{ $shortLink }}' target='_blank'>{{ $shortLink }}</a></p>
        @break
    @case('collision')
		<p>Ссылка <a href='{{ $sourceLink }}' target='_blank'>{{ $sourceLink }}</a> вызвала коллизию (неуникальность короткой ссылки).</p>
		<p>Попробуйте отправить форму еще раз.</p>
        @break
    @case('insert')
		<p>Ссылка <a href='{{ $sourceLink }}' target='_blank'>{{ $sourceLink }}</a> внесена в базу данных.</p>
		<p>Короткая ссылка для нее: <a href='{{ $shortLink }}' target='_blank'>{{ $shortLink }}</a></p>
        @break
@endswitch

@include ('form')

</body>
</html>
