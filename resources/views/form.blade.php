<form name='linkform' action='./' method='post'>
<div id='formgrid'>
	@csrf

	<div class='field-label'>Ссылка</div>
	<div><input type='text' name='sourcelink' value='{{ $sourceLinkForm ?? '' }}' size=20 required></div>

	<div class='field-label'>Лимит переходов</div>
	<div><input type='number' name='counter' value='0' size=5 required min=0 step=1></div>

	<div class='field-label' class='field-label'>Время жизни (часов)</div>
	<div><input type='number' name='lifetime' value='1' size=5 required min=1 max=24 step=1></div>

	<div class='field-label'></div>
	<div><input type='submit'></div>

</div>
</form>

