<h1>Bonjour, <?= htmlspecialchars($_SESSION['user']['username']) ?>!</h1>

<?php if ($_SESSION['user']['role'] === 'organizer'): ?>
    <p>Voici vos événements que vous organisez.</p>
    <a href="/events/create" class="btn btn-primary mb-3">Créer un nouvel événement</a>
    <?php if (!empty($events)): ?>
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Date</th>
                    <th>Places</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?= htmlspecialchars($event['title']) ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($event['event_date']))) ?></td>
                        <td>Capacité: <?= $event['capacity'] ?></td>
                        <td><a href="/events/<?= $event['id'] ?>" class="btn btn-sm btn-outline-dark">Voir</a>
                            <a href="/events/<?= $event['id'] ?>/edit" class="btn btn-sm btn-outline-warning">Modifier</a>
                            <form method="POST" action="/events/<?= $event['id'] ?>/delete" class="d-inline"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-muted">Vous n'avez pas encore créé d'événements.</p>
    <?php endif; ?>
<?php else: ?>
    <p>Voici vos inscriptions aux événements.</p>
    <?php if (!empty($registrations)): ?>
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Titre de l'événement</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registrations as $registration): ?>
                    <tr>
                        <td><?= htmlspecialchars($registration['title']) ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($registration['event_date']))) ?></td>
                        <td><a href="/events/<?= $registration['id'] ?>" class="btn btn-sm btn-outline-dark">Voir</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-muted">Vous n'êtes inscrit à aucun événement.</p>
    <?php endif; ?>
<?php endif; ?>