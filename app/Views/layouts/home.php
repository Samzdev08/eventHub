
<div class="text-center py-5">
    <h1 class="mb-3">EventHub</h1>
    <p class="text-muted mb-4">Créez, gérez et rejoignez des événements en quelques clics pour des six seven</p>

    <a href="/events" class="btn btn-dark me-2">Voir les événements</a>
    <?php if (empty($_SESSION['user_id'])): ?>
        <a href="/register" class="btn btn-outline-dark">Créer un compte</a>
    <?php endif; ?>
</div>