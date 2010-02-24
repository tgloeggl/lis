<?
$width = 170;
if ($cur == 0) $percent = 0;
else $percent = floor($width / ($max / $cur));
?>
<div class="percentage" title="<?= Functions::formatNumber($cur) ?> von <?= Functions::formatNumber($max) ?> belegt">
	<div class="filled" style="width: <?= $percent ?>px"></div>
	<div class="left" style="width: <?= ($width - $percent) ?>px"></div>
	<div class="infotext"> <?= Functions::formatNumber($cur) ?> / <?= Functions::formatNumber($max) ?> <?= $unit ?></div>
</div>
