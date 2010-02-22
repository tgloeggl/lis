<?php
/*
Lost in Space - templates/main/index.php
Copyright (C) 2004-2007 by Till Glöggler <tgloeggl@inspace.de>

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

$factory = new Flexi_TemplateFactory($GLOBALS['BASE_PATH'] . DIRECTORY_SEPARATOR . 'templates');
echo $factory->render('html/head');
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
	<tr>
		<td id="awaiting"></td>
		<td id="stats" class="portal_top" valign="top" background="images/portal/v3_btt.png">
		</td>
		<td class="portal_top" valign="top">
			<span id="messages"><span>
		</td>
		<td class="portal_top" style="text-align: right; width: 320px;">
			<img src="http://localhost/lis/public/assets/images/lost_in_space.gif" onClick="window.location='http://lost.inspace.de'" style="cursor: pointer">
		</td>
	</tr>
	<tr>
		<td class="portal_left" background="images/portal/v3_blt.png" height="10" valign="top" align="center" width="150"></td>
		<td align="left" id="main" rowspan="20" colspan="3" height="100%" valign="top" style="{padding:20px; border: 1px solid #C6C6EE}">
			<?= $content_for_layout ?>
		</td>
	</tr>
	<? foreach ((array)$menu as $i => $entry) : ?>
	<tr height="40">
		<td class="portal_left">
			<div class="portal">
			<? if ($entry['nojs']) : ?>
				<a href="http://localhost/lis/public/index.php/<?=$entry['page']?>/<?= $entry['action'] ?>?<?=$entry['params']?>">
					<b><?=$entry['name']?></b>
				</a>
			<? else : ?>
				<a href="javascript:loadPage('<?=$entry['page']?>', '<?= $entry['action'] ?>', '<?=$entry['params']?>')">
					<b><?=$entry['name']?></b>
				</a>
			<? endif; ?>
			</div>
		</td>
	</tr>
	<? endforeach; ?>
	<tr>
		<td class="portal_left" valign="top" style="width: 130px; padding-left: 20px; padding-top: 20px;">
			<table cellspacing="0" cellpadding="0" border="0" width="90%">
				<tr>
					<?
					if (sizeof($icons) > 0) :
						foreach ($icons as $i => $icon) :
					?>
					<td id="i<?=$i?>" align="center" height="30" width="30">
						<a href="javascript:loadPage('<?=$icon['page']?>.php<?=$icon['params']?>')">
							<img src="http://localhost/lis/public/assets/images/<?=$icon['image']?>" title="<?= $icon['name'] ?>">
						</a>
					</td>
					<td>&nbsp;</td>
					<?
						endforeach;
					endif;
					?>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script>
	updateStats();
	new PeriodicalExecuter(updateStats, 15);
</script>
<?= $factory->render('html/tail'); ?>
