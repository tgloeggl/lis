<? foreach ($planets as $planet) : ?>
<? $storage = Planets::getStorage($planet['planet_id']) ?>
<div class="planet_overview" style="background-image: url('<?= Assets::imgurl('background_transparent') ?>')" onClick="loadPage('planets', '<?= ($return) ? '' : 'details/'. $planet['planet_id'] ?>', '')">
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
			<tr>
				<td>Energie</td>
				<td colspan="3" style="padding-left: 10px;"><?= Functions::formatNumber(Planets::getEnergy($planet['planet_id'])) ?> MWh</td>
			</tr>
			<tr>
				<td>Carboxin</td>
				<td colspan="2" style="padding: 0px 10px 0px 10px"><?= $this->render_partial('_percentage.php', array('cur' => $planet['carboxin'], 'max' => $storage['carboxin'], 'unit' => 't')) ?></td>
				<td><?= Functions::formatNumber($planet['pcarboxin'], true) ?></td>
			</tr>
			<tr>
				<td>Detrogen</td>
				<td colspan="2" style="padding: 0px 10px 0px 10px"><?= $this->render_partial('_percentage.php', array('cur' => $planet['detrogen'], 'max' => $storage['detrogen'], 'unit' => 'm³')) ?></td>
				<td><?= Functions::formatNumber($planet['pdetrogen'], true) ?></td>
			</tr>
			<tr>
				<td>Radium</td>
				<td colspan="2" style="padding: 0px 10px 0px 10px"><?= $this->render_partial('_percentage.php', array('cur' => $planet['radium'], 'max' => $storage['radium'], 'unit' => 'kg')) ?></td>
				<td><?= Functions::formatNumber($planet['pradium'], true) ?></td>
			</tr>
			<tr>
				<td>Credits</td>
				<td colspan="2" style="padding: 0px 10px 0px 10px"><?= $this->render_partial('_percentage.php', array('cur' => $planet['credits'], 'max' => $storage['credits'], 'unit' => 'cr.')) ?></td>
				<td><?= Functions::formatNumber($planet['pcredits'], true) ?></td>
			</tr>
		</table>
	</div>
</div>
<? endforeach ?>
