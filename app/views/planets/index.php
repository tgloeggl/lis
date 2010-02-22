<? foreach ($planets as $planet) : ?>
<? $storage = Planets::getStorage($planet['planet_id']) ?>
<div class="planet_overview" style="background-image: url('<?= Assets::imgurl('background_transparent') ?>')" onClick="loadPage('planets', 'details/<?= $planet['planet_id'] ?>', '')">
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
		<?= Planets::getTempName($planet['temp']) ?> (<?= $planet['temp'] ?>�C)<br>
		<?= Planets::getSizeName($planet['size']) ?>
	</div>
	<div style="float:left;">
		<table cellspacing="0" cellpadding="0">
			<tr>
				<td>Energie</td>
				<td colspan="2" style="padding-left: 10px;"><?= Functions::formatNumber(Planets::getEnergy($planet['planet_id'])) ?> MWh</td>
			</tr>
			<tr>
				<td>Carboxin</td>
				<td style="padding: 0px 10px 0px 10px;"><?= Functions::formatNumber($planet['carboxin']) ?> t</td>
				<td>/ <?= Functions::formatNumber($storage['carboxin']) ?> t</td>
			</tr>
			<tr>
				<td>Detrogen</td>
				<td style="padding: 0px 10px 0px 10px;"><?= Functions::formatNumber($planet['detrogen']) ?> m�</td>
				<td>/ <?= Functions::formatNumber($storage['detrogen']) ?> m�</td>
			</tr>
			<tr>
				<td>Radium</td>
				<td style="padding: 0px 10px 0px 10px;"><?= Functions::formatNumber($planet['radium']) ?> kg</td>
				<td>/ <?= Functions::formatNumber($storage['radium']) ?>  kg</td>
			</tr>
			<tr>
				<td>Credits</td>
				<td style="padding: 0px 10px 0px 10px;"><?= Functions::formatNumber($planet['credits']) ?> cr.</td>
				<td>/ <?= Functions::formatNumber($storage['credits']) ?> cr.</td>
			</tr>
		</table>
	</div>
</div>
<? endforeach ?>
