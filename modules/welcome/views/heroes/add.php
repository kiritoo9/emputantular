<div class="empu-container">
	
	<p class="empu-title">Empu Foundations</p>
	<small>- Add heroes for your foundations</small>
	<hr /><br />

	<a empu-route="/heroes" class="empu-btn mt-30 empu-btn-primary">Back to List</a>
	<br /><br />

	<form empu-action="/heroes/insert" method="POST">
		<input type="text" name="fullname" placeholder="Fullname" /><br />
		<input type="number" name="strength" placeholder="Strength" /><br />
		<input type="text" name="secret_power" placeholder="Secret Power" />

		<hr />
		<button type="submit">Submit</button>
	</form>

</div>