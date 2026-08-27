<div class="container mt-4">
    <div class="card w-50 mx-auto shadow-sm">
        <div class="card-body p-4">
            <h1 class="h4 mb-4">Créer un utilisateur</h1>
            <form method="POST" action="/create-user" novalidate>
                <div class="mb-3">
                    <label for="username" class="form-label">Nom d'utilisateur</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Rôle</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="user">Utilisateur</option>
                        <option value="organizer">Organisateur</option>
                        <option value="admin">Administrateur</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password-hash" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Créer l'utilisateur</button>
                    <a class="btn btn-outline-secondary" href="/my-events">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>