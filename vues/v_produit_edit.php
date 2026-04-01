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
                <div>
                    <label for="id_display" class="form-label">Identifiant du produit (non modifiable) :</label>
                    <input type="text" class="form-control" name="id_display" id="id_display"
                        value="<?= $leProduit->id ?>" disabled>
                    <input type="hidden" name="id" value="<?= $leProduit->id ?>">
                </div>

                <div>
                    <label for="description" class="form-label">Nom du produit :</label>
                    <input type="text" class="form-control" name="description" id="description"
                        value="<?= htmlspecialchars($leProduit->description ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <div >
                    <label for="image" class="form-label">Image du produit :</label>
                    <?php if ($leProduit->image): ?>
                        <div class="mb-2"><img src="<?= $leProduit->image ?>" style="width: 50px; height: auto;"
                                alt="preview" class="rounded"></div>
                    <?php endif; ?>
                    <input type="text" class="form-control" name="image" id="image"
                        value="<?= htmlspecialchars($leProduit->image ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        placeholder="assets/images/...">
                </div>

                <div>
                    <label for="marqueID" class="form-label">Marque du produit :</label>
                    <select name="marqueID" id="marqueID" class="form-select">
                        <?php foreach ($lesMarques as $uneMarque): ?>
                            <option value="<?= $uneMarque->id ?>" <?= $uneMarque->id == $leProduit->marqueID ? 'selected' : '' ?>><?= htmlspecialchars($uneMarque->libelle ?? '', ENT_QUOTES, 'UTF-8') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div">
                    <label for="idCategorie" class="form-label">Catégorie du produit :</label>
                    <select name="idCategorie" id="idCategorie" class="form-select">
                        <option value="">- Choisissez une catégorie -</option>
                        <?php foreach ($lesCategories as $uneCategorie): ?>
                            <option value="<?= $uneCategorie->id ?>" <?= $uneCategorie->id === $leProduit->idCategorie ? 'selected' : '' ?>>
                                <?= htmlspecialchars($uneCategorie->libelle ?? '', ENT_QUOTES, 'UTF-8') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <div>
                        <label for="prix" class="form-label">Prix du produit :</label>
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control" name="prix" id="prix"
                                value="<?= $leProduit->prix ?>">
                            <span class="input-group-text">€</span>
                        </div>
                    </div>
                    <div>
                        <label for="stock" class="form-label">Stock :</label>
                        <input type="number" class="form-control" name="stock" id="stock"
                            value="<?= $leProduit->stock ?>">
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-sm">Enregistrer les modifications</button>
            </div>
        </div>

        <div class="text-center">
            <a href="index.php?uc=gererProduit&action=afficher" class="btn btn-danger btn-sm">Annuler</a>
        </div>
    </form>
</div>