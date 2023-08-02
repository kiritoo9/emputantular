<html lang="en">
<head>
	<title>ERROR CIL</title>
	<link rel="stylesheet" href="/systems/errors/html/style.css">
</head>
<body>
	<div id="empu_err_main">
		<div class="fof">
			<h2>ERROR CIL</h2>
			<p>
				Error:
				<?= isset($empuError['message']) ? $empuError['message'] : 'Undefined Error' ?><br />
				File:
				<?= isset($empuError['file']) ? $empuError['file'] : 'Unreachable File' ?> <br />
				Line:
				<?= isset($empuError['line']) ? $empuError['line'] : '0' ?>
			</p>

			<?php if (isset($empuError['details']) && count($empuError['details']) > 0): ?>
				<table id="tableError">
					<thead>
						<tr>
							<th>File Name</th>
							<th>Line</th>
							<th>Class</th>
							<th>Function</th>
						</tr>
					</thead>
					<tbody>
						<?php for ($i = 0; $i < count($empuError['details']); $i++): ?>
							<tr>
								<td>
									<?= $empuError['details'][$i]['file'] ?? 'Untrackable'; ?>
								</td>
								<td>
									<?= $empuError['details'][$i]['line'] ?? 'Untrackable'; ?>
								</td>
								<td>
									<?= $empuError['details'][$i]['class'] ?? 'Untrackable'; ?>
								</td>
								<td>
									<?= $empuError['details'][$i]['function'] ?? 'Untrackable'; ?>
								</td>
							</tr>
						<?php endfor ?>
					</tbody>
				</table>
			<?php endif ?>

			<h5>
				"error mulu cil kerjaan lu, tutor ngoding cek profil dik"<br />
				Emputantular - Version 2.0
			</h5>
		</div>
	</div>
</body>

</html>