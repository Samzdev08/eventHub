<?php


$flash = $flash ?? $_SESSION['flash'] ?? [];
unset($_SESSION['flash']);

$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'EventHub') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { color: #111; }
        a { color: #111; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="/events">EventHub</a>
    <div>
        <a href="/events" class="text-white text-decoration-none me-3">Événements</a>
        <?php if ($isLoggedIn): ?>
            <a href="/my-registrations" class="text-white text-decoration-none me-3">Mes inscriptions</a>
            <form action="/logout" method="POST" class="d-inline">
                <button type="submit" class="btn btn-sm btn-outline-light">Déconnexion</button>
            </form>
        <?php else: ?>
            <a href="/login" class="text-white text-decoration-none me-3">Connexion</a>
            <a href="/register" class="text-white text-decoration-none">Créer un compte</a>
        <?php endif; ?>
    </div>
</nav>

<main class="container py-4">

    <?php if (!empty($flash['success'])): ?>
        <div class="alert alert-dark"><?= htmlspecialchars($flash['success']) ?></div>
    <?php endif; ?>
    <?php if (!empty($flash['error'])): ?>
        <div class="alert alert-secondary"><?= htmlspecialchars($flash['error']) ?></div>
    <?php endif; ?>

    <?= $content ?? '' ?>

</main>

</body>
</html>