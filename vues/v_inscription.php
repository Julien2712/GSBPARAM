<div class="alert alert-light" role="alert">Inscription :</div>

<div class="card card-body col-8 m-auto mb-4">
    <?php if (isset($msgErreurs) && !empty($msgErreurs)): ?>
        <div class="alert alert-danger">
            <?php foreach ($msgErreurs as $e) echo "<p class='mb-0'>".htmlspecialchars($e)."</p>"; ?>
        </div>
    <?php endif; ?>
    <form action="index.php" method="post">
        <input type="hidden" name="uc" value="utilisateur">
        <input type="hidden" name="action" value="creerCompte">
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="login" class="form-label"><strong>Login * :</strong></label>
                <input type="text" class="form-control" name="login" id="login" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="mail" class="form-label"><strong>Email :</strong></label>
                <input type="email" class="form-control" name="mail" id="mail">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nom" class="form-label"><strong>Nom :</strong></label>
                <input type="text" class="form-control" name="nom" id="nom">
            </div>
            <div class="col-md-6 mb-3">
                <label for="prenom" class="form-label"><strong>Prénom :</strong></label>
                <input type="text" class="form-control" name="prenom" id="prenom">
            </div>
        </div>

        <div class="mb-3">
            <label for="rue" class="form-label"><strong>Rue :</strong></label>
            <input type="text" class="form-control" name="rue" id="rue">
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="cp" class="form-label"><strong>Code postal :</strong></label>
                <input type="text" class="form-control" name="cp" id="cp" pattern="[0-9]{5}" maxlength="5" title="Veuillez entrer 5 chiffres exacts">
            </div>
            <div class="col-md-8 mb-3">
                <label for="ville" class="form-label"><strong>Ville :</strong></label>
                <input type="text" class="form-control" name="ville" id="ville">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6 mb-3 mb-md-0">
                <label for="mdp" class="form-label"><strong>Mot de passe * :</strong></label>
                <input type="password" class="form-control" name="mdp" id="mdp" required minlength="12" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{12,}" title="Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.">
                <div class="form-text">Min 12 caractères, 1 maj, 1 min, 1 chiffre, 1 caractère spécial.</div>
            </div>
            <div class="col-md-6">
                <label for="mdp2" class="form-label"><strong>Confirmer * :</strong></label>
                <input type="password" class="form-control" name="mdp2" id="mdp2" required>
            </div>
        </div>

        <button type="submit" class="btn btn-warning">Créer mon compte</button>
    </form>
</div>

<div class="text-center">
    <p>Déjà un compte ? <a href="index.php?uc=utilisateur&action=connexion">Se connecter</a></p>
</div>