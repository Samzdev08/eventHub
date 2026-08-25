<h1>Inscription</h1>
<form method="POST" action="/register" class="w-25" novalidate>
    <div class="mb-3">
        <label for="username" class="form-label">Nom d'utilisateur</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div>
        <label for="role" class="form-label">Role</label>
        <select class="form-control" id="role" name="role" required>
            <option value="user">Utilisateur</option>
            <option value="organizer">Organisateur</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password_hash" required>
    </div>
    <button type="submit" class="btn btn-primary">S'inscrire</button>
</form>