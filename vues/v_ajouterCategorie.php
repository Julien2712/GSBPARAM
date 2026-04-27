<div class="alert alert-light" role="alert" id="categorie">Créer une nouvelle catégorie</div>

<div class="categorie-item border p-3 mb-2 rounded">
    <form method="POST" action="index.php?uc=gererCategorie&action=ajouter">
        <div class="mb-3">
            <label for="id" class="form-label">ID de la catégorie (ex: CH, FO, PS) :</label>
            <input type="text" class="form-control" name="id" id="id" placeholder="Entrez l'identifiant court" required maxlength="10">
        </div>
        <div class="mb-3">
            <label for="libelle" class="form-label">Nom de la catégorie :</label>
            <input type="text" class="form-control" name="libelle" id="libelle" placeholder="Entrez le nom complet" required>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Créer</button>
            <a href="index.php?uc=gererCategorie&action=afficher" class="btn btn-secondary">
                Annuler
            </a>
        </div>
    </form>
</div>
