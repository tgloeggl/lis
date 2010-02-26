<div class="planet_overview" style="text-align: center; font-weight: bold" onClick="loadPage('design', 'new', '')">
	Neuen Schiffstyp erstellen
</div>

<br style="clear: both">

<? if (is_array($ship_designs)) foreach ($ship_designs as $ship) : ?>
<div class="shipdesign" <? /* onClick="$('modules_<?= $ship['shipdesign_id'] ?>').toggle()" */ ?> style="position: relative">
	<b><?= $ship['name'] ?></b>
	<div>
	<? for ($i = 1; $i <= 10; $i++) :
		if ($ship['damage'][$i] && $ship['damage'][$i] > 0) :
			$color =  '0, '. (floor(150 / ($ship['max_damage'] / $ship['damage'][$i])) + 50) .', 0';
		else :
			$color = '100, 0, 0';
		endif;
	?>
	<span class="dmg" style="background-color: rgb(<?= $color ?>)"><?= ($ship['damage'][$i]) ? $ship['damage'][$i] : '0'  ?></span>
	<? endfor; ?>
	</div>

	<br> 
	<?= $ship['size']['tonnage'] ?> t (<?= $ship['size']['name'] ?>),
	<?= $ship['drive']['name'] ?>, 
	Panzerung: <?= $ship['armor'] ?> t/cm²<br>

	<?= $ship['carg'] ? 'Nutzlast: '. $ship['cargo'] .' t<br>' : '' ?>
	Baukosten: <? $costs = array(); foreach (Config::get('resources') as $name => $res) :
		if ($ship[$res]) $costs[] = Functions::formatNumber($ship[$res]) .' '. $name;
	endforeach; echo implode(', ', $costs); ?>

	<div id="modules_<?= $ship['shipdesign_id'] ?>" <? /* style="display: none" */ ?>>
		<table class="default">
			<tr>
				<th>Name</th><th>Angriff</th><th>Panzerung</th><th>Reichweite</th><th>Nutzlast</th><th>Anzahl</th>
			</tr>
			<? $c = 0; foreach ($ship['modules'] as $module) : $c = 1 - $c;?>
			<tr>
				<td <?= $c ? 'class="odd"' : '' ?>><?= $module['name'] ?></td>
				<td <?= $c ? 'class="odd"' : '' ?>><?= $module['attack'] ?> </td>
				<td <?= $c ? 'class="odd"' : '' ?>><?= $module['armor'] ?> </td>
				<td <?= $c ? 'class="odd"' : '' ?>><?= $module['range'] ?> </td>
				<td <?= $c ? 'class="odd"' : '' ?>>
					<?= $module['cargo'] ? $module['cargo'] .' t' : '' ?>
				</td>
				<td <?= $c ? 'class="odd"' : '' ?>>
					<?= $module['count'] ?>
				</td>
			</tr>
			<? endforeach ?>
		</table>
	</div>

	<div class="icon">
		<a href="javascript:loadPage('design', 'delete', '/<?= $ship['shipdesign_id'] ?>')">
			<?= Assets::img('delete'); ?>
		</a>
	</div>
</div>
<? endforeach ?>
