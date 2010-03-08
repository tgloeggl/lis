<b><?= $planet['name'] ?> (<?= ($user = User::getName($planet['owner_id'])) ? $user : 'unbewohnt' ?>)</b><br>
Klasse <?= Planets::getClass($planet['temp'], $planet['type']) ?>
(<?= Planets::getClassName($planet['temp'], $planet['type']) ?>)<br>
<?= Planets::getTypeName($planet['type']) ?> Ressourcen<br>
<?= Planets::getTempName($planet['temp']) ?> (<?= $planet['temp'] ?>°C)<br>
<?= Planets::getSizeName($planet['size']) ?>
