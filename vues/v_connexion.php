<div class="alert alert-light" role="alert">Connexion :</div>

<div class="card card-body col-6 m-auto mb-4">
    <?php if(isset($msgErreurs) && !empty($msgErreurs)): ?>
        <div class="alert alert-danger">
            <?php foreach($msgErreurs as $e) echo "<p class='mb-0'>".htmlspecialchars($e)."</p>"; ?>
        </div>
    <?php endif; ?>
    <form action="index.php" method="post">
        <input type="hidden" name="uc" value="utilisateur">
        <input type="hidden" name="action" value="seConnecter">
        
        <div class="mb-3">
            <label for="login" class="form-label"><strong>Login :</strong></label>
            <input type="text" class="form-control" name="login" id="login" required>
        </div>
        
        <div class="mb-3">
            <label for="mdp" class="form-label"><strong>Mot de passe :</strong></label>
            <input type="password" class="form-control" name="mdp" id="mdp" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>

<div class="text-center">
    <p>Pas encore de compte ? <a href="index.php?uc=utilisateur&action=inscription">Créer un compte</a></p>
</div>