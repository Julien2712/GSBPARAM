<?php
// Vue pour donner un avis sur un produit
?>
<div class="container mt-5">
    <div class="row w-75 mx-auto">
        <div class="col-12 text-center mb-4">
            <h2>Donner un avis</h2>
        </div>
    </div>

    <?php if (!empty($msgErreurs)): ?>
        <div class="alert alert-danger w-50 mx-auto">
            <ul class="mb-0">
                <?php foreach ($msgErreurs as $erreur): ?>
                    <li><?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card w-50 mx-auto mb-5 p-4 shadow-sm border-0">
        <div class="d-flex align-items-center mb-4">
            <div class="me-4">
                <img src="<?= htmlspecialchars($produit->image ?? '', ENT_QUOTES, 'UTF-8') ?>" alt="image produit" style="width: 100px; object-fit: contain;" />
            </div>
            <div>
                <h5><?= htmlspecialchars($produit->description ?? '', ENT_QUOTES, 'UTF-8') ?></h5>
                <p class="text-muted mb-0">
                    Marque: <?= htmlspecialchars($marque->libelle ?? '', ENT_QUOTES, 'UTF-8') ?><br>
                    Catégorie: <?= htmlspecialchars($categorie->libelle ?? '', ENT_QUOTES, 'UTF-8') ?>
                </p>
            </div>
        </div>

        <form action="index.php?uc=voirProduits&action=validerAvis&produit=<?= $produit->id ?>" method="POST">
            <div class="mb-3 d-flex align-items-center">
                <label for="note" class="form-label me-3 fw-bold mb-0">Note :</label>
                <input type="number" class="form-control text-center me-2" id="note" name="note" min="1" max="5" value="5" required style="width: 80px;">
                <span class="fs-5">/ 5</span>
            </div>
            
            <div class="mb-4">
                <label for="commentaire" class="form-label fw-bold">Commentaire :</label>
                <textarea class="form-control" id="commentaire" name="commentaire" rows="4" placeholder="Votre avis sur ce produit... (optionnel)"></textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="index.php?uc=voirProduits&produit=<?= $produit->id ?>&action=voirDetails" class="btn btn-outline-secondary px-4 rounded-pill">Retour</a>
                <button type="submit" class="btn btn-success px-4 rounded-pill col-7">Valider</button>
            </div>
        </form>
    </div>
</div>
