<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4">Ajouter un produit</h2>
        </div>
    </div>

    <form method="POST" action="index.php?uc=gererProduit&action=ajouter" id="formAjoutProduit"
        class="border p-4 rounded shadow-sm bg-light">

        <?php if (isset($erreur)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="mb-3">
                <label for="id" class="form-label">Identifiant du produit (obligatoire et unique) :</label>
                <input type="text" class="form-control" name="id" id="id" required maxlength="5"
                    placeholder="ex: p01, c01, f01..."
                    value="<?= htmlspecialchars($anciennesValeurs['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Nom du produit :</label>
                <input type="text" class="form-control" name="description" id="description" required
                    placeholder="Champoing"
                    value="<?= htmlspecialchars($anciennesValeurs['description'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image du produit :</label>
            <div class="input-group">
                <input type="file" class="form-control" id="file_picker" accept="image/*">
                <input type="text" class="form-control" name="image" id="image" placeholder="assets/images/..." required
                    value="<?= htmlspecialchars($anciennesValeurs['image'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
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
                    <option value="<?= $uneMarque->id ?>" <?= (isset($anciennesValeurs['marqueID']) && $anciennesValeurs['marqueID'] == $uneMarque->id) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($uneMarque->libelle ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="idCategorie" class="form-label">Catégorie du produit :</label>
            <select name="idCategorie" id="idCategorie" class="form-select" required>
                <option value="" disabled <?= empty($anciennesValeurs['idCategorie']) ? 'selected' : '' ?> hidden>-
                    Choisissez une catégorie -</option>
                <?php foreach ($lesCategories as $uneCategorie): ?>
                    <option value="<?= $uneCategorie->id ?>" <?= (isset($anciennesValeurs['idCategorie']) && $anciennesValeurs['idCategorie'] == $uneCategorie->id) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($uneCategorie->libelle ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="prix" class="form-label">Prix du produit :</label>
            <div class="input-group">
                <input type="number" step="0.01" min="0" class="form-control" name="prix" id="prix"
                    value="<?= htmlspecialchars($anciennesValeurs['prix'] ?? '0', ENT_QUOTES, 'UTF-8') ?>">
                <span class="input-group-text">€</span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label for="stock" class="form-label">Stock :</label>
                <input type="number" class="form-control" name="stock" id="stock"
                    value="<?= htmlspecialchars($anciennesValeurs['stock'] ?? '0', ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="col-6">
                <label for="contenance" class="form-label">Contenance (ex: 100) :</label>
                <div class="input-group">
                    <input type="number" class="form-control" name="contenance" id="contenance"
                        value="<?= htmlspecialchars($anciennesValeurs['contenance'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    <span class="input-group-text">ml</span>
                </div>
            </div>
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