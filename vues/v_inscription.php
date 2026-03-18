<div class="container">
    <h2>Inscription</h2>
    <?php if (isset($msgErreurs) && !empty($msgErreurs)): ?>
        <div class="alert alert-danger">
            <?php foreach ($msgErreurs as $e)
                echo "<p>" . htmlspecialchars($e) . "</p>"; ?>
        </div>
    <?php endif; ?>
    <form action="index.php" method="post">
        <input type="hidden" name="uc" value="utilisateur">
        <input type="hidden" name="action" value="creerCompte">
        <div><label>Login: <input type="text" name="login" required></label></div>
        <div><label>Nom: <input type="text" name="nom"></label></div>
        <div><label>Prenom: <input type="text" name="prenom"></label></div>
        <div><label>rue: <input type="text" name="rue"></label></div>
        <div><label>cp: <input type="text" name="cp" pattern="[0-9]{5}" maxlength="5"
                    title="Veuillez entrer 5 chiffres exacts"></label></div>
        <div><label>ville: <input type="text" name="ville"></label></div>
        <div><label>Mail: <input type="email" name="mail"></label></div>
        <div><label>Mot de passe: <input type="password" name="mdp" required></label></div>
        <div><label>Confirmer: <input type="password" name="mdp2" required></label></div>
        <div><button type="submit">Créer</button></div>
    </form>
</div>