<?php
/** @var array|null $event */
/** @var int|null $id */
?>
<h1><?=  $id ? 'Modifier l\'événement' : 'Créer un nouvel événement' ?></h1>
<form action="<?= $id ? '/events/' . $id . '/edit' : '/events/create' ?>" method="POST" novalidate>
    <div class="mb-3">
        <label for="title" class="form-label">Titre</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($event['title'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($event['description'] ?? '') ?></textarea>
    </div>
    <div class="mb-3">
        <label for="event_date" class="form-label">Date et heure</label>
        <input type="datetime-local" class="form-control" id="event_date" name="event_date" value="<?= date('Y-m-d\TH:i', strtotime($event['event_date']) ?? '') ?>" required>
    </div>
    <div class="mb-3">
        <label for="capacity" class="form-label">Capacité</label>
        <input type="number" class="form-control" id="capacity" name="capacity" value="<?= htmlspecialchars($event['capacity'] ?? '') ?>" required>
    </div>
    <button type="submit" class="btn btn-primary"><?= $id ? 'Modifier' : 'Créer' ?></button>
    <a onclick="history.back()" class="btn btn-secondary">Annuler</a>
</form>
