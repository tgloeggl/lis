<? foreach ($message->getMessages() as $msg) : ?>
<div class="<?= $msg['type'] ?>">
	<?= $msg['message'] ?>
</div>
<? endforeach ?>
