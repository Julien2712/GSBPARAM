<div class="container">
    <h2>Connexion</h2>
    <?php if(isset($msgErreurs) && !empty($msgErreurs)): ?>
        <div class="alert alert-danger">
            <?php foreach($msgErreurs as $e) echo "<p>".htmlspecialchars($e)."</p>"; ?>
        </div>
    <?php endif; ?>
    <form action="index.php" method="post">
        <input type="hidden" name="uc" value="utilisateur">
        <input type="hidden" name="action" value="seConnecter">
        <div><label>Login: <input type="text" name="login" required></label></div>
        <div><label>Mot de passe: <input type="password" name="mdp" required></label></div>
        <div><button type="submit">Se connecter</button></div>
    </form>
    <p><a href="index.php?uc=utilisateur&action=inscription">Créer un compte</a></p>
</div>