<title>Wooppsss!!</title>
<link rel="stylesheet" href="/systems/errors/html/style.css">
<div id="main">
	<div class="fof">
		<h1>Error dik!</h1>
		<p>
			<?= str_replace(
				"Error:", "<br /> Error:", str_replace(
					"Location:", "<br /> Location:", $log
				)
			) ?>
		</p>
		<h5>
			"error mulu bisa ngoding ga sih? awkwokwo"<br />
			Emputantular - Version 2.0.0
		</h5>
	</div>
</div>