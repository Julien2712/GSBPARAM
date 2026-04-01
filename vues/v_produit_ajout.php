<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4">Ajouter un produit</h2>
            <h3 class="text-center text-muted mb-4">Produit N°<?= $prochainID ?></h3>
        </div>
    </div>

    <form method="POST" action="index.php?uc=gererProduit&action=ajouter" id="formAjoutProduit"
        class="border p-4 rounded shadow-sm bg-light">
        <div class="row">
            <div class="mb-3">
                <label for="id" class="form-label">Identifiant du produit (obligatoire) :</label>
                <input type="text" class="form-control" name="id" id="id" required maxlength="5"
                    placeholder="p<?= $prochainID ?>">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Nom du produit :</label>
                <input type="text" class="form-control" name="description" id="description" required
                    placeholder="Champoing">
            </div>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image du produit :</label>
            <div class="input-group">
                <input type="file" class="form-control" id="file_picker" accept="image/*">
                <input type="text" class="form-control" name="image" id="image" placeholder="assets/images/..."
                    required>
            </div>
            <div class="form-text">Sélectionnez un fichier pour pré-remplir le chemin.</div>
        </div>

        <script>
            document.getElementById('file_picker').addEventListener('change', function (e) {
                if (e.target.files.length > 0) {
                    document.getElementById('image').value = 'assets/images/' + e.target.files[0].name;
                }
            });
        </script>

        <div class="mb-3">
            <label for="marqueID" class="form-label">Marque du produit :</label>
            <select name="marqueID" id="marqueID" class="form-select">
                <?php foreach ($lesMarques as $uneMarque): ?>
                    <option value="<?= $uneMarque->id ?>">
                        <?= htmlspecialchars($uneMarque->libelle ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="idCategorie" class="form-label">Catégorie du produit :</label>
            <select name="idCategorie" id="idCategorie" class="form-select" required>
                <option value="" disabled selected hidden>- Choisissez une catégorie -</option>
                <?php foreach ($lesCategories as $uneCategorie): ?>
                    <option value="<?= $uneCategorie->id ?>">
                        <?= htmlspecialchars($uneCategorie->libelle ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="prix" class="form-label">Prix du produit :</label>
            <div class="input-group">
                <input type="number" step="0.01" class="form-control" name="prix" id="prix" value="0">
                <span class="input-group-text">€</span>
            </div>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock :</label>
            <input type="number" class="form-control" name="stock" id="stock" value="0">
        </div>

        <div class="row mt-4">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary shadow-sm">Ajouter le produit</button>
            </div>
        </div>

        <div class="text-center mt-2">
            <a href="index.php?uc=gererProduit&action=afficher" class="btn btn-danger btn-sm">Annuler</a>
        </div>
    </form>
</div>