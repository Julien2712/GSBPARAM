<div class="alert alert-light" role="alert" id="association">Gérer les associations de produits :</div>

<div class="mb-3 contenuCentre">
    <button class="btn btn-primary shadow-sm" data-bs-toggle="collapse" data-bs-target="#formAjout">
        Créer une association
    </button>
</div>

<div class="collapse mb-4" id="formAjout">
    <div class="card card-body col-8 m-auto">
        <form method="POST" action="index.php?uc=gererAssociation&action=ajouter">
            <div class="mb-3">
                <label for="prodId" class="form-label"><strong>Produit principal :</strong></label>
                <select name="prodId" id="prodId" class="form-select" required>
                    <option value="">-- Sélectionner un produit --</option>
                    <?php foreach ($lesProduits as $unProduit): ?>
                        <option value="<?= $unProduit->id ?>">
                            <?= htmlspecialchars($unProduit->description ?? $unProduit->id, ENT_QUOTES, 'UTF-8') ?> (<?= $unProduit->id ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="prodIdAssocie" class="form-label"><strong>Produit associé :</strong></label>
                <select name="prodIdAssocie" id="prodIdAssocie" class="form-select" required>
                    <option value="">-- Sélectionner un produit --</option>
                    <?php foreach ($lesProduits as $unProduit): ?>
                        <option value="<?= $unProduit->id ?>">
                            <?= htmlspecialchars($unProduit->description ?? $unProduit->id, ENT_QUOTES, 'UTF-8') ?> (<?= $unProduit->id ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Ajouter l'association</button>
        </form>
    </div>
</div>

<?php if (empty($lesAssociations)): ?>
    <div class="alert alert-info text-center">Aucune association de produits pour le moment.</div>
<?php else: ?>
    <?php foreach ($lesAssociations as $uneAssociation): ?>
        <div class="categorie-item border p-3 mb-2 rounded" id="assoc-<?= $uneAssociation->prodId ?>-<?= $uneAssociation->prodId_produit ?>">
            <div class="d-flex justify-content-between align-items-center">
                <span>
                    <strong>Produit :</strong> <?= htmlspecialchars($uneAssociation->descriptionProduit, ENT_QUOTES, 'UTF-8') ?> (<?= $uneAssociation->prodId ?>)
                    &nbsp;↔&nbsp;
                    <strong>Associé à :</strong> <?= htmlspecialchars($uneAssociation->descriptionProduitAssocie, ENT_QUOTES, 'UTF-8') ?> (<?= $uneAssociation->prodId_produit ?>)
                </span>
                <div class="d-flex gap-2">
                    <a href="index.php?uc=gererAssociation&prodId=<?= $uneAssociation->prodId ?>&prodIdAssocie=<?= $uneAssociation->prodId_produit ?>&action=supprimer"
                        class="btn btn-danger btn-sm" type="button"
                        onclick="return confirm('Voulez-vous vraiment supprimer cette association ?');">
                        Supprimer
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
