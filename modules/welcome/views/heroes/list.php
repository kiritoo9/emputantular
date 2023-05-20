<div class="empu-container">
	
	<p class="empu-title">Empu Foundations</p>
	<small>- List of heroes who ready to protect the world!</small>
	<hr /><br />
	<a empu-route="/heroes/add" class="empu-btn mt-30 empu-btn-primary">Add New Heroes</a>
	<table class="empu-table mt-20" border="1">
		<thead>
			<tr>
				<th style="width: 5%;">#</th>
				<th>Fullname</th>
				<th>Strength</th>
				<th>Secret Power</th>
				<th style="width: 15%">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($heroes as $row => $value): ?>
				<tr>
					<td><?= $row + 1 ?></td>
					<td><?= $value->fullname ?></td>
					<td><?= $value->strength ?></td>
					<td><?= $value->secret_power ?></td>
					<td>
						<a empu-route="/heroes/edit/<?= $value->id ?>" class="empu-btn empu-btn-info">Edit</a>
						<a 
							empu-route="/heroes/delete/<?= $value->id ?>" 
							empu-confirm="Are you sure to delete this data?" 
							class="empu-btn empu-btn-danger"
						>
							Delete
						</a>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

</div>