<div class="alert alert-light" role="alert" class="categorie">Ajouter un produit à la catégorie :
    <?= $laCategorie->libelle ?>
</div>

<div class="categorie-item border p-3 mb-2 rounded">
    <form method="POST" action="index.php?uc=gererCategorie&action=changerCategorieProduit">
        <input type="hidden" name="idCategorie" value="<?= $laCategorie->id ?>">

        <?php if (empty($lesProduitsSansCategorie)): ?>
            <p class="alert alert-warning"><strong>Il n'y a aucun produit sans catégorie pour le moment.</strong></p>
            <div class="d-flex gap-2">
                <a href="index.php?uc=gererCategorie&action=afficher" class="btn btn-secondary">
                    Retour
                </a>
            </div>
        <?php else: ?>
            <div class="mb-3">
                <label for="idProduit" class="form-label">Choisir un produit existant :</label>
                <select name="idProduit" id="idProduit" class="form-select" required>
                    <option value="" disabled selected>Choisir un produit</option>
                    <?php foreach ($lesProduitsSansCategorie as $unProduit): ?>
                        <option value="<?= $unProduit->id ?>"><?= $unProduit->description ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Ajouter</button>
                <a href="index.php?uc=gererCategorie&action=afficher" class="btn btn-secondary">
                    Annuler
                </a>
            </div>
        <?php endif; ?>
    </form>
</div>