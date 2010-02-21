<? foreach ($planets as $planet) : ?>
<div class="planet_overview" onClick="loadPage('planets', 'details/<?= $planet['planet_id'] ?>', '')">
	<div style="float:left; padding-right: 10px;">
		<?= Assets::img('planets/'. Planets::getClass($planet['temp'], $planet['type'])) ?><br>
		<? if (Planets::is_blocked($planet['planet_id'])) : ?>
		<?= Assets::img('ship_red') ?>
		<? endif; ?>
	</div>
	<div style="float:left; padding-right: 20px;">
		<b><?= $planet['name'] ?></b><br>
		Klasse <?= Planets::getClass($planet['temp'], $planet['type']) ?>
			(<?= Planets::getClassName($planet['temp'], $planet['type']) ?>)<br>
		<?= Planets::getTypeName($planet['type']) ?> Ressourcen<br>
		<?= Planets::getTempName($planet['temp']) ?> (<?= $planet['temp'] ?>°C)<br>
		<?= Planets::getSizeName($planet['size']) ?>
	</div>
	<div style="float:left;">
		<table cellspacing="0" cellpadding="0">
			<tr><td>Energie</td> <td style="padding-left: 10px;"><?= $planet['energy'] ?> MWh</td></tr>
			<tr><td>Carboxin</td><td style="padding-left: 10px;"><?= $planet['carboxin'] ?> t</td></tr>
			<tr><td>Detrogen</td><td style="padding-left: 10px;"><?= $planet['detrogen'] ?> m³</td></tr>
			<tr><td>Radium</td>  <td style="padding-left: 10px;"><?= $planet['radium'] ?> kg</td></tr>
			<tr><td>Credits</td> <td style="padding-left: 10px;"><?= $planet['credits'] ?></td></tr>
		</table>
	</div>
</div>
<? endforeach ?>
