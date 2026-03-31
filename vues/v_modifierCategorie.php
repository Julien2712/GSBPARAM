<div class="alert alert-light" role="alert" id="categorie">Modifier la catégorie : <?= $laCategorie->libelle ?></div>

<div class="categorie-item border p-3 mb-2 rounded">
    <form method="POST" action="index.php?uc=gererCategorie&action=modifier&idCategorie=<?= $laCategorie->id ?>">
        <div class="mb-3">
            <label for="libelle" class="form-label">Nom de la catégorie :</label>
            <input type="text" class="form-control" name="libelle" id="libelle" value="<?= $laCategorie->libelle ?>" required>
        </div>
        <div class="mb-3">
            <label for="id" class="form-label">ID de la catégorie :</label>
            <input type="text" class="form-control" name="id" id="id" value="<?= $laCategorie->id ?>" required>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Enregistrer</button>
            <a href="index.php?uc=gererCategorie&action=afficher" class="btn btn-secondary">
                Annuler
            </a>
        </div>
    </form>
</div>