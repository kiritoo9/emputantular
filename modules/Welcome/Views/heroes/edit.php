<br />
<a href="/heroes" class="empu-btn mt-30 empu-btn-primary">Back to List</a>
<br /><br />

<form action="/heroes/update" method="POST">
	<input type="hidden" name="id" value="<?= $hero->id ?>" />
	<input type="text" name="fullname" value="<?= $hero->fullname ?>" placeholder="Fullname" /><br />
	<input type="number" name="strength" value="<?= $hero->strength ?>" placeholder="Strength" /><br />
	<input type="text" name="secret_power" value="<?= $hero->secret_power ?>" placeholder="Secret Power" />

	<hr />
	<button type="submit">Submit</button>
</form>