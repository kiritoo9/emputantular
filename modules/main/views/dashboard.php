<a empu-route="/masters/users/foo?id=123">Go To Detail!</a>

<br />
<legend>List ID</legend>
<table border="1" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th style="width: 5%">#</th>
			<th>ID</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $row => $value): ?>
			<tr>
				<td><?= $row + 1 ?></td>
				<td><?= $value->id ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>