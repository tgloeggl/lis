<? if (is_object($flash['messages'])) : ?>
<div id="message_area" class="messages">
	<?  foreach ($flash['messages']->getMessages() as $msg) : ?>
	<div class="<?= $msg['type'] ?>" style="position: relative">
		<?= $msg['message'] ?>
		<div class="close_message" onClick="this.parentNode.fade()">
			&nbsp;X&nbsp;
		</div>
	</div>
	<? endforeach ?>	
</div>
<? endif ?>
