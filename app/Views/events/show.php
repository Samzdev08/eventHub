<?php

/** @var array $event */
/** @var array $nbRegistrations */

$registeredCount = (int) $nbRegistrations['count'];
$capacity = (int) $event['capacity'];
$isFull = $registeredCount >= $capacity;
?>

<h1><?= htmlspecialchars($event['title']) ?></h1>
<p class="text-muted"><?= htmlspecialchars(date('Y-m-d H:i', strtotime($event['event_date']))) ?></p>

<p><?= nl2br(htmlspecialchars($event['description'])) ?></p>

<?php if ($isFull): ?>
    <p>Complet</p>
<?php else: ?>
    <p>Places disponibles : <?= $capacity - $registeredCount ?></p>
<?php endif; ?>

<?php if ((int) $event['owner_id'] === (int) $_SESSION['user']['id'] || $_SESSION['user']['role'] === 'admin'): ?>
    <div class="mt-3">
        <a href="/events/<?= $event['id'] ?>/edit" class="btn btn-sm btn-outline-dark">Modifier</a>
        <form action="/events/<?= $event['id'] ?>/delete" method="POST" class="d-inline">
            <button type="submit" class="btn btn-sm btn-outline-dark"
                    onclick="return confirm('Supprimer cet événement ?');">Supprimer</button>
        </form>
    </div>
<?php elseif ($_SESSION['user']['role'] === 'user'): ?>
    <div class="mt-3">
        <?php if (!empty($isRegistred)): ?>
            <p class="text-muted">Vous êtes inscrit à cet événement.</p>
        <?php elseif ($isFull): ?>
            <p class="text-muted">Les inscriptions sont closes.</p>
        <?php else: ?>
            <form action="/registrations" method="POST">
                <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                <button type="submit" class="btn btn-dark">S'inscrire</button>
            </form>
        <?php endif; ?>
    </div>
<?php endif; ?>

<a onclick="history.go(-1)" class="btn btn-outline-secondary btn-sm mt-3">Retour</a>