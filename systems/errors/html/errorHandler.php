<link rel="stylesheet" href="/systems/errors/html/style.css">
<div id="empu_err_main">
	<div class="fof">
		<h2>ERROR CIL</h2>
		<p>
			Error: <?= isset($empuError['message']) ? $empuError['message'] : 'Undefined Error' ?><br />
			File: <?= isset($empuError['file']) ? $empuError['file'] : 'Unreachable File' ?> <br />
			Line: <?= isset($empuError['line']) ? $empuError['line'] : '0' ?>
		</p>
		<h5>
			"error mulu bisa ngoding ga sih? awkwokwo"<br />
			Emputantular - Version 2.0.0
		</h5>
	</div>
</div>