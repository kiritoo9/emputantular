<?php if(!defined('EmpuCoreApp')) exit('You cannot access the file directly bro!'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $title ?? 'Emputantular' ?></title>

	<link rel="stylesheet" type="text/css" href="/systems/web/empu.css">
</head>
<body>
	<div id="emputantular-rootapp">
		<?php 
			if(isset($__empuErrorContent)):
				require_once __DIR__ . "/../systems/{$__empuErrorContent}.php";
			elseif(isset($__empuContent)):
				require_once __DIR__ . "/../modules/{$__empuContent}.php";
			endif;
		?>
	</div>

	<!--
		Handler error and show it in DOM
		For SPA error only!
	-->
	<div id="empuErrorDom"></div>

	<!-- EMPU.JS CORE -->
	<script type="module" src="/systems/web/empu.js"></script>
</body>
</html>