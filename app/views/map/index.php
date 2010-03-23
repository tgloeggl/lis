<? $i = $j = 0 ?>
<span id="x" style="display: none"><?= $x ?></span>
<span id="y" style="display: none"><?= $y ?></span>

<div style="position: relative">
	<table class="map" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<th colspan="14" style="background-color: black" id="pos"><?= $x ?> / <?= $y ?></th>
		</tr>
	<? for ($yp = ($y - 7); $yp < ($y + 7); $yp++) : ?>
		<tr>
		<? for ($xp = ($x - 7); $xp < ($x + 7); $xp++) : ?>
			<? if ($map[$xp][$yp]['planet_id']) : ?>
				<td id="<?= $j .'_'. $i ?>" onMouseOver="Tooltip.show('<?= str_replace("\n", '', $this->render_partial('map/_planet_tooltip', array('planet' => $map[$xp][$yp]))) ?>')" onMouseOut="Tooltip.hide()">
					<?= Assets::img('planets/'. Planets::getClass($map[$xp][$yp]['temp'], $map[$xp][$yp]['type'])) ?>
				</td>
			<? else : ?>
			<td id="<?= $j .'_'. $i ?>"></td>
			<? endif ?>
			<? $j++ ?>
		<? endfor ?>
		</tr>
		<? $i++; $j = 0; ?>
	<? endfor ?>
	</table>

	<div style="position: absolute; top: 0px; left: 0px; z-index: 1000; height: 390px; width: 410px;" onMouseDown="Map.startMove()" onMouseUp="Map.stopMove()">
	</div>
</div>

<div id="tooltip"></div>
