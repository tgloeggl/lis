<?= $this->render_partial('planets/index.php', array('planets' => array($planet))) ?>
<h1>Gebäude</h1>

<? foreach ($buildings as $building) : ?>
<div class="planet_overview">
	<div style="float: left;">
		<b><?= $building['name'] ?></b><br>
		<!--<?= $building['description'] ?>-->
	</div>

	
	<div style="float: right; margin-left: 10px;">
		Stufe <?= $building['level'] ?>
	</div>
	<div class="building_resources">
		<table cellspacing="0" border="0">
			<tr>
				<th></th>
				<th>Energie</th>
				<th>Carboxin</th>
				<th>Detrogen</th>
				<th>Radium</th>
				<th>Credits</th>
			</tr>
			<tr>
				<td>Baukosten</td> 
				<? foreach (Config::get('resources') as $res) : ?>
					<td><?= ($building[$res]) ? Functions::formatNumber($building[$res]) : '-' ?></td>
				<? endforeach ?>
			</tr>
			<tr>
				<td>Produktion</td> 
				<? foreach (Config::get('resources') as $res) : ?>
					<td><?= ($building['mod_'. $res]) ? Functions::formatNumber($building['mod_'. $res]) : '-' ?></td>
				<? endforeach ?>
			</tr>
		</table>
	</div>

</div>
<? endforeach; ?>
