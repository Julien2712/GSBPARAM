<div class="alert alert-light" role="alert" id="categorie">Gérer les produits :</div>

<div class="mb-3 contenuCentre">
    <a href="index.php?uc=gererProduit&action=afficherAjouter" class="btn btn-primary">
        Ajouter un produit
    </a>
</div>

<div id="produits">
    <?php
    foreach ($lesProduits as $unProduit) {
        $id = $unProduit->id;
        $description = htmlspecialchars($unProduit->description ?? '', ENT_QUOTES, 'UTF-8');
        $prix = htmlspecialchars($unProduit->prix ?? '', ENT_QUOTES, 'UTF-8');
        $image = htmlspecialchars($unProduit->image ?? '', ENT_QUOTES, 'UTF-8');
        ?>
        <div class="produit-item border p-3 mb-2 rounded shadow-sm bg-white" id="produit-<?= $id ?>">
            <div class="d-flex justify-content-between align-items-center">
                <span class="d-flex align-items-center">
                    <?php if ($image): ?>
                        <img src="<?= $image ?>" alt="<?= $id ?>" style="width: 50px; height: auto; margin-right: 15px;"
                            class="rounded shadow-sm">
                    <?php else: ?>
                        <div class="bg-secondary rounded"
                            style="width: 50px; height: 50px; margin-right: 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 10px;">
                            No image</div>
                    <?php endif; ?>
                    <div>
                        <strong>Nom :</strong> <?= $description ?><br>
                        <small class="text-muted">ID: <?= $id ?> | Prix: <?= $prix ?> € | Stock:
                            <?= $unProduit->stock ?></small>
                    </div>
                </span>
                <div class="d-flex gap-3">
                    <a href="index.php?uc=gererProduit&idProduit=<?= urlencode($id) ?>&action=afficherModifier">
                        Modifier
                    </a>
                    <a href="index.php?uc=gererProduit&idProduit=<?= urlencode($id) ?>&action=supprimer"
                        onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?');">
                        Supprimer
                    </a>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>