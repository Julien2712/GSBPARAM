<div class="alert alert-light" role="alert" id="categorie">Gérer les produits :</div>

<div class="mb-3 contenuCentre">
    <a href="index.php?uc=gererProduit&action=afficherAjouter" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-circle"></i> Ajouter un produit
    </a>
</div>

<div id="liste-produits-gestion">
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
                        <div class="bg-secondary rounded text-white d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px; margin-right: 15px; font-size: 10px;">
                            No image
                        </div>
                    <?php endif; ?>
                    <div>
                        <strong>Nom :</strong> <?= $description ?><br>
                        <small class="text-muted">ID: <?= $id ?> | Prix: <?= $prix ?> € | Stock:
                            <?= $unProduit->stock ?></small>
                    </div>
                </span>
                <div class="d-flex gap-2">
                    <a href="index.php?uc=gererProduit&idProduit=<?= urlencode($id) ?>&action=afficherModifier"
                        class="btn btn-warning btn-sm shadow-sm" style="min-width: 80px;">
                        Modifier
                    </a>
                    <a href="index.php?uc=gererProduit&idProduit=<?= urlencode($id) ?>&action=supprimer"
                        class="btn btn-danger btn-sm shadow-sm" style="min-width: 80px;"
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