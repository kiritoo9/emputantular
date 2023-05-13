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
		<?php require_once __DIR__ . "/../modules/{$content}.php"; ?>
	</div>

	<!-- EMPU.JS CORE -->
	<script type="module" src="/systems/web/empu.js"></script>
</body>
</html>