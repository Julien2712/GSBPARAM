<div id="produitDetails" class="produit-details-container mt-4">
    <?php if (isset($_GET['avisAjoute'])): ?>
        <div class="alert alert-success w-100 mb-3 text-center">Votre avis a été ajouté avec succès.</div>
    <?php endif; ?>
    <?php if (isset($_GET['dejaAvis'])): ?>
        <div class="alert alert-warning w-100 mb-3 text-center">Vous avez déjà donné votre avis sur ce produit.</div>
    <?php endif; ?>

    <div class="produit-details-image">
        <img src="<?= $produit->image ?? '' ?>" alt="image produit" />
    </div>
    <div class="produit-details-infos">
        <h2 class="produit-details-titre"><?= htmlspecialchars($produit->description ?? '', ENT_QUOTES, 'UTF-8') ?></h2>
        <p class="produit-details-marque">
            Produit de la marque <strong><?= htmlspecialchars($marque->libelle ?? '', ENT_QUOTES, 'UTF-8') ?></strong> 
            de la catégorie <strong><?= htmlspecialchars($categorie->libelle ?? '', ENT_QUOTES, 'UTF-8') ?></strong>
        </p>
        
        <div class="produit-details-description">
            <u>Description :</u><br>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus aliquam venenatis neque, quis pretium orci molestie non.
            </p>
        </div>

        <div class="produit-details-avis mb-3 text-center">
            <?php if ($avisStatistiques && $avisStatistiques->nbAvis > 0): ?>
                <div>
                    <span class="text-warning">
                    <?php 
                    $noteArrondie = round($avisStatistiques->moyenne);
                    for($i=1; $i<=5; $i++){
                        echo $i <= $noteArrondie ? '★' : '☆';
                    }
                    ?>
                    </span>
                    <span>
                        <a href="#liste-avis" class="text-success text-decoration-none ms-1"><?= $avisStatistiques->nbAvis ?> avis</a>
                    </span>
                </div>
            <?php else: ?>
                <p style="font-size: 14px; color: #888;" class="mb-1"><i>Aucun avis pour ce produit.</i></p>
            <?php endif; ?>

            <?php if (isset($_SESSION['utilisateur'])): ?>
                <?php if (!$aDejaDonneAvis): ?>
                    <div class="mt-1">
                        <a href="index.php?uc=voirProduits&produit=<?= $produit->id ?>&action=donnerAvis" class="text-success text-decoration-underline" style="font-size: 0.9rem;">Donner un avis</a>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="mt-1">
                    <span class="text-muted" style="font-size: 0.85rem;">Connectez-vous pour donner un avis</span>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($produit->contenance)): ?>
        <div class="contenance-info">
            Contenance : <span><?= $produit->contenance ?> ml</span>
        </div>
        <?php endif; ?>

        <div class="produit-details-prix">
            <span class="prix-valeur"><?= $produit->prix ?>€</span> 
            <span class="stock-status">
                <?php if ($produit->stock == 0): ?>
                    - <span class="stock-rupture">Rupture de Stock</span>
                <?php elseif ($produit->stock <= 5): ?>
                    - <span class="stock-ok">En Stock (plus que <?= $produit->stock ?>)</span>
                <?php else: ?>
                    - <span class="stock-ok">En Stock</span>
                <?php endif; ?>
            </span>
        </div>

        <?php if (isset($_SESSION['utilisateur']) && $produit->stock > 0): ?>
            <div class="produit-ajouter-panier">
                <form action="index.php?uc=gererPanier&produit=<?= $produit->id ?>&action=ajouterAuPanier" method="POST" style="margin:0;">
                    <select name="quantite">
                        <?php 
                        $maxStock = min((int)$produit->stock, 10); 
                        for ($i = 1; $i <= $maxStock; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <button type="submit">Ajouter au panier</button>
                </form>
            </div>
        <?php endif; ?>

        <div class="produit-retour mt-3">
            <a href="javascript:window.close()" class="btn btn-outline-secondary btn-sm">Retour</a>
        </div>
    </div>
</div>

<?php if (!empty($lesAvis)): ?>
<div id="liste-avis" class="container mt-5 w-75 mx-auto">
    <h4 class="mb-4 text-success border-bottom pb-2">Avis clients</h4>
    <?php foreach ($lesAvis as $avis): ?>
        <div class="card mb-3 border-0 bg-light">
            <div class="card-body py-2 px-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <div>
                        <strong class="me-2"><?= htmlspecialchars($avis->utiLogin, ENT_QUOTES, 'UTF-8') ?></strong>
                        <span class="text-warning small">
                        <?php 
                        for($i=1; $i<=5; $i++){
                            echo $i <= $avis->note ? '★' : '☆';
                        }
                        ?>
                        </span>
                    </div>
                    <small class="text-muted"><?= date('d/m/Y', strtotime($avis->date)) ?></small>
                </div>
                <?php if (!empty($avis->description)): ?>
                    <p class="card-text small mb-1"><?= nl2br(htmlspecialchars($avis->description, ENT_QUOTES, 'UTF-8')) ?></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (count($produitsAssocies) > 0): ?>
    <div class="produits-associes-container">
        <h3 class="produits-associes-titre">Vous aimerez peut-être aussi...</h3>
        <div class="produits-associes-liste">
            <?php foreach($produitsAssocies as $pAssoc): ?>
                <div class="produit-associe-card">
                    <a href="index.php?uc=voirProduits&produit=<?= $pAssoc->id ?>&action=voirDetails" target="_blank" style="text-decoration:none; color:inherit; display:block;">
                        <img src="<?= $pAssoc->image ?>"/>
                        <p class="desc"><?= htmlspecialchars($pAssoc->description, ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="prix"><?= $pAssoc->prix ?>€</p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
