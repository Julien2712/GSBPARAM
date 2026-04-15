<?php
// Vue pour l'espace client (Mes avis)
?>
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2>Espace Client</h2>
        </div>
    </div>

    <!-- Navigation par onglets -->
    <ul class="nav nav-tabs justify-content-center mb-4">
        <li class="nav-item">
            <a class="nav-link text-muted" href="#">Mes informations</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-muted" href="#">Mes commandes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active text-success fw-bold" href="#">Mes avis</a>
        </li>
    </ul>

    <!-- Contenu de l'onglet Mes avis -->
    <div class="row w-75 mx-auto">
        <div class="col-12">
            <?php if (empty($lesAvis)): ?>
                <div class="alert alert-info text-center">
                    Vous n'avez pas encore déposé d'avis.
                </div>
            <?php else: ?>
                <?php foreach ($lesAvis as $avis): ?>
                    <div class="card mb-3 border-0 border-bottom rounded-0 pb-3">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-2 text-center">
                                <a href="index.php?uc=voirProduits&produit=<?= $avis->idProduit ?>&action=voirDetails" class="text-decoration-none">
                                    <img src="<?= htmlspecialchars($avis->imageProduit, ENT_QUOTES, 'UTF-8') ?>" class="img-fluid rounded-start" alt="Image Produit" style="max-height: 100px;">
                                    <div class="small mt-2 text-success" style="font-size: 0.8rem; line-height: 1.1;">
                                        <?= htmlspecialchars($avis->nomProduit, ENT_QUOTES, 'UTF-8') ?>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-10">
                                <div class="card-body py-0">
                                    <div class="row mb-2">
                                        <div class="col-3 border-end">
                                            <div class="text-warning mb-1">
                                                <?php 
                                                for($i=1; $i<=5; $i++){
                                                    echo $i <= $avis->note ? '★' : '☆';
                                                }
                                                ?>
                                            </div>
                                            <small class="text-muted" style="font-size: 0.75rem;">Avis déposé le <?= date('d/m/Y', strtotime($avis->date)) ?></small>
                                        </div>
                                        <div class="col-9">
                                            <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Commentaire</h6>
                                            <p class="card-text mb-0"><?= htmlspecialchars($avis->description, ENT_QUOTES, 'UTF-8') ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
