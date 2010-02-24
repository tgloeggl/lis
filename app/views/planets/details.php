<?= $this->render_partial('planets/index.php', array('planets' => array($planet), 'return' => true)) ?>
<?= $this->render_partial('_messages.php'); ?>
<h1>Gebäude</h1>
<? foreach ($buildings as $building) : ?>
	<? if (!$building['level']) $building['active'] = 1; ?>
	<? if ($building['defense'] > 0 && $cat != 'defense') : ?>
		<h1>Verteidigungsanlagen</h1>
	<? $cat = 'defense'; endif; ?>
	<? 
	$can_build = true;
	foreach (Config::get('resources') as $res) : 
		if ($res != 'energy') {
			if ($planet[$res] < $building[$res]) $can_build = false;
		}
	endforeach; 
	$class = '';
	if ($in_progress[$building['building_id']]) $class = 'inprogress';
	else if (!$building['active']) $class = 'deactivated';
	else if (!$can_build) $class = 'locked';
	?>
<div class="planet_overview building <?= $class ?>" onClick="build('<?= $planet['planet_id'] ?>', '<?= $building['building_id'] ?>')">
	<div style="float: left;">
		<b><?= $building['name'] ?></b><br>
		<!--<?= $building['description'] ?>-->
	</div>
	
	<div style="float: right; margin-left: 10px;">
		<?= $building['level'] ? 'Anzahl: '. $building['level'] : '<span style="color: #AA0000">nicht vorhanden</span>' ?>
	</div>
		
	<? if ($in_progress[$building['building_id']]) : ?>
	<div style="float: right; color: #00CC00; font-weight: bold;">
		im Bau bis <?= date('d.m, H:i', $in_progress[$building['building_id']]['end'] + 60) ?>
	</div>
	<? elseif (!$building['active']) : ?>
	<div style="float: right; color: #FF0000; font-weight: bold;">
		Gebäude sind deaktiviert!
	</div>
	<? else: ?>
	<div style="float: right; color: #5555FF; font-weight: bold;">
		Bauzeit: <?= ceil($building['completion'] / 60) ?> min
	</div>
	<? endif ?>
	
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
	
	<div style="float: right; clear: both">
		<? if (!$building['active']) : ?>
		Klicken um Gebäude zu aktivieren
		<? else : ?>
		Klicken um Auszubauen
		<? endif ?>
	</div>
</div>
<? endforeach; ?>
