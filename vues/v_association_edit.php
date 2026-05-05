<div class="alert alert-light" role="alert" id="association">Modifier une association de produits :</div>

<div class="mb-3 contenuCentre">
    <a href="index.php?uc=gererAssociation&action=afficher" class="btn btn-secondary shadow-sm">
        Retour à la gestion des associations
    </a>
</div>

<div class="card card-body col-8 m-auto mb-4">
    <form method="POST" action="index.php?uc=gererAssociation&action=modifier">
        <input type="hidden" name="ancienProdId" value="<?= htmlspecialchars($prodId, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="ancienProdIdAssocie" value="<?= htmlspecialchars($prodIdAssocie, ENT_QUOTES, 'UTF-8') ?>">

        <div class="mb-3">
            <label for="prodId" class="form-label"><strong>Produit principal :</strong></label>
            <select name="prodId" id="prodId" class="form-select" required>
                <option value="">-- Sélectionner un produit --</option>
                <?php foreach ($lesProduits as $unProduit): ?>
                    <option value="<?= $unProduit->id ?>" <?= ($unProduit->id == $prodId) ? 'selected' : '' ?>>
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
                    <option value="<?= $unProduit->id ?>" <?= ($unProduit->id == $prodIdAssocie) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($unProduit->description ?? $unProduit->id, ENT_QUOTES, 'UTF-8') ?> (<?= $unProduit->id ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-warning">Enregistrer les modifications</button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const selectProdId = document.getElementById("prodId");
    const selectProdIdAssocie = document.getElementById("prodIdAssocie");

    if (selectProdId && selectProdIdAssocie) {
        function updateSelectOptions() {
            const val1 = selectProdId.value;
            const val2 = selectProdIdAssocie.value;

            // Pour selectProdIdAssocie, on cache l'option choisie dans selectProdId
            Array.from(selectProdIdAssocie.options).forEach(opt => {
                if(opt.value !== "") {
                    opt.style.display = (opt.value === val1) ? 'none' : '';
                }
            });

            // Pour selectProdId, on cache l'option choisie dans selectProdIdAssocie
            Array.from(selectProdId.options).forEach(opt => {
                if(opt.value !== "") {
                    opt.style.display = (opt.value === val2) ? 'none' : '';
                }
            });
        }

        selectProdId.addEventListener("change", updateSelectOptions);
        selectProdIdAssocie.addEventListener("change", updateSelectOptions);
        
        // Initialiser au chargement si des valeurs sont déjà sélectionnées
        updateSelectOptions();
    }
});
</script>
