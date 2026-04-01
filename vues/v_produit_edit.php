<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4">Modifier le produit :
                <?= htmlspecialchars($leProduit->description ?? '', ENT_QUOTES, 'UTF-8') ?></h2>
        </div>
    </div>

    <form method="POST" action="index.php?uc=gererProduit&action=modifier&idProduit=<?= urlencode($leProduit->id) ?>"
        id="formEditProduit" class="border p-4 rounded shadow-sm bg-light">
        <div class="row">
            <div class="mb-3">
                <label for="id_display" class="form-label">Identifiant du produit (non modifiable) :</label>
                <input type="text" class="form-control" name="id_display" id="id_display"
                    value="<?= $leProduit->id ?>" disabled>
                <input type="hidden" name="id" value="<?= $leProduit->id ?>">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Nom du produit :</label>
                <input type="text" class="form-control" name="description" id="description"
                    value="<?= htmlspecialchars($leProduit->description ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image du produit :</label>
                <?php if ($leProduit->image): ?>
                    <div class="mb-2"><img src="<?= $leProduit->image ?>" style="width: 50px; height: auto;"
                            alt="preview" class="rounded shadow-sm border bg-white p-1"></div>
                <?php endif; ?>
                <div class="input-group">
                    <input type="file" class="form-control" id="file_picker" accept="image/*">
                    <input type="text" class="form-control" name="image" id="image"
                        value="<?= htmlspecialchars($leProduit->image ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        placeholder="assets/images/...">
                </div>
                <div class="form-text">Note : Le dossier racine est <code>assets/images/</code>. Choisissez un fichier pour pré-remplir le chemin.</div>
            </div>

            <script>
                document.getElementById('file_picker').addEventListener('change', function(e) {
                    if (e.target.files.length > 0) {
                        document.getElementById('image').value = 'assets/images/' + e.target.files[0].name;
                    }
                });
            </script>

            <div class="mb-3">
                <label for="marqueID" class="form-label">Marque du produit :</label>
                <select name="marqueID" id="marqueID" class="form-select">
                    <?php foreach ($lesMarques as $uneMarque): ?>
                        <option value="<?= $uneMarque->id ?>" <?= $uneMarque->id == $leProduit->marqueID ? 'selected' : '' ?>><?= htmlspecialchars($uneMarque->libelle ?? '', ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="idCategorie" class="form-label">Catégorie du produit :</label>
                <select name="idCategorie" id="idCategorie" class="form-select" required>
                    <option value="" disabled>- Choisissez une catégorie -</option>
                    <?php foreach ($lesCategories as $uneCategorie): ?>
                        <option value="<?= $uneCategorie->id ?>" <?= $uneCategorie->id === $leProduit->idCategorie ? 'selected' : '' ?>>
                            <?= htmlspecialchars($uneCategorie->libelle ?? '', ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row mb-3">
                <div class="col-4">
                    <label for="prix" class="form-label">Prix du produit :</label>
                    <div class="input-group">
                        <input type="number" step="0.01" class="form-control" name="prix" id="prix"
                            value="<?= $leProduit->prix ?>">
                        <span class="input-group-text">€</span>
                    </div>
                </div>
                <div class="col-4">
                    <label for="stock" class="form-label">Stock :</label>
                    <input type="number" class="form-control" name="stock" id="stock"
                        value="<?= $leProduit->stock ?>">
                </div>
                <div class="col-4">
                    <label for="contenance" class="form-label">Contenance :</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="contenance" id="contenance"
                            value="<?= htmlspecialchars($leProduit->contenance ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        <span class="input-group-text">ml</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary shadow-sm">Enregistrer les modifications</button>
            </div>
        </div>

        <div class="text-center mt-2">
            <a href="index.php?uc=gererProduit&action=afficher" class="btn btn-danger btn-sm">Annuler</a>
        </div>
    </form>
</div>