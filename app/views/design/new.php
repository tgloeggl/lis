<? if ($flash['messages']) echo $this->render_partial('_messages') ?>
<form id="shipdesigner" method="post" action="<?= $controller->url_for('design/create') ?>"
<div style="clear: both">
	<h1>Schiffstyp</h1>
	<div style="float: left; margin-right: 20px;">
		Tonnage:<br>
		<select id="size" name="size" onChange="Shipdesign.updateModules()">
		<? foreach ($sizes as $size) : ?>
			<option value="<?= $size['shipsize_id'] ?>"><?= $size['name'] ?> (<?= Functions::formatNumber($size['tonnage']) ?> t)</option>
		<? endforeach ?>
		</select>
		<br>
		<br>
		Gewicht: <span id="whole_weight"><?= $sizes[0]['weight'] ?></span> t
		<br>
		<br>
	</div>

	<div style="float: left; margin-right: 20px;">
		Antrieb:<br>
		<select id="drive" name="drive" onchange="Shipdesign.updateDrive()">
		<? foreach ($drives as $drive) : ?>
			<option value="<?= $drive['drive_id'] ?>"><?= $drive['name'] ?> (<?= $drive['speed'] ?> IAU)</option>
		<? endforeach ?>
		</select>
		<br>
		<br>
		Panzerung: <span id="armor"><?= $sizes[0]['armor'] ?></span> t/cm²
	</div>

	<div style="float: left; margin-right: 20px;">
		Name des Schiffstyps:<br>
		<input id="ship_name" type="text" style="width: 200pt" name="ship_name">
		<br>
		<br>
			<span class="dmg" id="dmg_1" style="background-color: #660000;">0</span>
			<span class="dmg" id="dmg_2" style="background-color: #660000;">0</span>
			<span class="dmg" id="dmg_3" style="background-color: #660000;">0</span>
			<span class="dmg" id="dmg_4" style="background-color: #660000;">0</span>
			<span class="dmg" id="dmg_5" style="background-color: #660000;">0</span>
			<span class="dmg" id="dmg_6" style="background-color: #660000;">0</span>
			<span class="dmg" id="dmg_7" style="background-color: #660000;">0</span>
			<span class="dmg" id="dmg_8" style="background-color: #660000;">0</span>
			<span class="dmg" id="dmg_9" style="background-color: #660000;">0</span>
			<span class="dmg" id="dmg_10" style="background-color: #660000;">0</span>
	</div>

</div>

<div style="clear: both">
	<table class="default" style="width: 600pt">
		<tr>
			<th></th><th>Carboxin in t</th><th>Detrogen in m³</th><th>Radium in kg</th><th>Credits</th>
		</tr>
		<tr>
			<td><b>Kosten:</b></td>
			<td id="cost_carboxin"><?= $sizes[0]['carboxin'] ?></td>
			<td id="cost_detrogen"><?= $sizes[0]['detrogen'] ?></td>
			<td id="cost_radium"><?= $sizes[0]['radium'] ?></td>
			<td id="cost_credits"><?= $sizes[0]['credits'] ?></td>
		</tr>
		<tr>
			<td><b>Verbrauch pro Lichjahr:</b></td>
			<td id="drive_carboxin"><?= $drives[0]['carboxin'] ?></td>
			<td id="drive_detrogen"><?= $drives[0]['detrogen'] ?></td>
			<td id="drive_radium"><?= $drives[0]['radium'] ?></td>
		</tr>
	</table>
	<br>
</div>

<div stlye="clear: both">
	<button onClick="return Shipdesign.build()">Design speichern</button>
</div>

<div id="modules" style="clear: both">
	<h1>Module</h1>
	<table class="default">
		<tr>
			<th>Name</th><th>Angriff</th><th>Panzerung</th><th>Reichweite</th><th>Kosten</th><th>Gewicht</th><th>Spezielles</th><th>Anzahl</th>
		</tr>
		<? foreach ($modules as $module) : $c = 1 - $c;?>
		<tr>
			<td <?= $c ? 'class="odd"' : '' ?>><?= $module['name'] ?></td>
			<td <?= $c ? 'class="odd"' : '' ?>><?= $module['attack'] ?> </td>
			<td <?= $c ? 'class="odd"' : '' ?>><?= $module['armor'] ?> </td>
			<td <?= $c ? 'class="odd"' : '' ?>><?= $module['range'] ?> </td>
			<td <?= $c ? 'class="odd"' : '' ?>>
				<? $cost = array(); foreach (Config::get('resources') as $res_name => $res) :
					if ($module[$res])  $cost[] =  $module[$res] .' '. $res_name;
				endforeach ?>
				<?= implode(', ', $cost); ?>
			</td>
			<td <?= $c ? 'class="odd"' : '' ?>><?= $module['weight'] ?> t</td>
			<td <?= $c ? 'class="odd"' : '' ?>>
				<?= $module['cargo'] ? 'Nutzlast: '. $module['cargo'] .' t<br>' : '' ?>
			</td>
			<td <?= $c ? 'class="odd"' : '' ?>>
				<input class="module" id="<?= $module['module_id'] ?>" type="text" name="modules[<?= $module['module_id'] ?>]" value="0" style="width: 40px" onChange="Shipdesign.updateModules()">
			</td>
		</tr>
		<? endforeach ?>
	</table>
</div>

<div id="debug" style="position: absolute; bottom: 0px; width: 600px; height: 100px; background-color: #FFFFAA; border: 1px solid black; color:black; overflow: scroll">
	Debugausgaben
	<hr>
</div>
</form>
