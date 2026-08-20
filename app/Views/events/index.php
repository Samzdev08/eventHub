<?php
/** @var array $events */
?>

<h1 class="mb-4">Événements</h1>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Date</th>
            <th>Places</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($events as $event): ?>
            <?php $full = $event['registered_count'] >= $event['capacity']; ?>
            <tr>
                <td><?= htmlspecialchars($event['title']) ?></td>
                <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($event['event_date']))) ?></td>
                <td>
                    Capacité: <?= $event['capacity'] ?>
                </td>
                <td><a href="/events/<?= $event['id'] ?>" class="btn btn-sm btn-outline-dark">Voir</a></td>
            </tr>
        <?php endforeach; ?>

        <?php if (empty($events)): ?>
            <tr><td colspan="4" class="text-center text-muted">Aucun événement.</td></tr>
        <?php endif; ?>
    </tbody>
</table>