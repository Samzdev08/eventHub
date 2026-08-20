<?php

/** @var array $event */
?>

<h1><?= htmlspecialchars($event['title']) ?></h1>
<p class="text-muted"><?= htmlspecialchars($event['event_date']) ?></p>

<p><?= nl2br(htmlspecialchars($event['description'])) ?></p>

<p>Capacité : <?= $event['capacity'] ?></p>

<a href="/events" class="btn btn-secondary">Retour aux événements</a>