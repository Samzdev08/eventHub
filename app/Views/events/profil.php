<?php

$roleColors = [
    'admin'     => 'bg-danger-subtle text-danger-emphasis border-danger-subtle',
    'organizer' => 'bg-warning-subtle text-warning-emphasis border-warning-subtle',
    'user'      => 'bg-success-subtle text-success-emphasis border-success-subtle',
];
?>
<h1>Bonjour, <?= htmlspecialchars($_SESSION['user']['username']) ?>!</h1>

<?php if ($_SESSION['user']['role'] === 'admin'): ?>
    <p>Voici la liste des utilisateurs.</p>
    <a href="/create-user" class="btn btn-primary mb-3">Créer un utilisateur</a>
    <?php if (!empty($users)): ?>
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Rôle</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <form method="POST" action="/users/<?= $user['id'] ?>/change-role" class="d-inline">
                                    <select class="form-select form-select-sm rounded-pill fw-semibold <?= $roleColors[$user['role']] ?>"
                                        name="role"
                                        id="role-<?= $user['id'] ?>"
                                        style="width: auto;"
                                        onchange="this.form.submit()">
                                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="organizer" <?= $user['role'] === 'organizer' ? 'selected' : '' ?>>Organizer</option>
                                        <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                    </select>
                                </form>
                                <?php if ($user['id'] !== $_SESSION['user']['id']): ?>
                                    <form method="POST" action="/users/<?= $user['id'] ?>/delete" class="d-inline"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-muted">Aucun utilisateur trouvé.</p>
    <?php endif; ?>

<?php elseif ($_SESSION['user']['role'] === 'organizer'): ?>
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

<?php elseif ($_SESSION['user']['role'] === 'user'): ?>
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
                        <td><a href="/events/<?= $registration['event_id'] ?>" class="btn btn-sm btn-outline-dark">Voir</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-muted">Vous n'êtes inscrit à aucun événement.</p>
    <?php endif; ?>

<?php else: ?>
    <p class="text-danger">Rôle utilisateur inconnu.</p>
<?php endif; ?>