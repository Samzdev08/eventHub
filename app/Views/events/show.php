<?php

/** @var array $event */
?>

<h1><?= htmlspecialchars($event['title']) ?></h1>
<p class="text-muted"><?= htmlspecialchars(date('Y-m-d H:i', strtotime($event['event_date']))) ?></p>

<p><?= nl2br(htmlspecialchars($event['description'])) ?></p>

<p>Capacité : <?= $event['capacity'] ?></p>

<a  onclick="history.go(-1)" class="btn btn-secondary">Retour aux événements</a>