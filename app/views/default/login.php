<center>
	<table class="login">
		<tr>
			<th colspan="2">Zugang zu Lost in Space...</th>
		</tr>
		<? if ($message) : ?>
		<tr>
			<td colspan="2">
				<?= $this->render_partial('../_messages.php') ?>
			</td>
		</tr>
		<? endif ?>
		<tr>
			<td>Name des Herrschers</td>
			<td>
				<input id="username" type="text" name="username">
			</td>
		</tr>
		<tr>
			<td>Persönlicher Identifikations-Term (PIT):</td>
			<td>
				<input id="password" type="password" name="username">
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: center">
				<br>
				<button onClick="login()">Einloggen</button>
				<a class="p" href="<?= $controller->url_for('default/newaccount') ?>">
					<button>Neu anmelden</button>
				</a>
				<br>
				<br>
			</td>
		</tr>
	</table>
</center>
