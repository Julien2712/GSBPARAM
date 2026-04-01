<div id="produitDetails" class="produit-details-container">
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

        <div class="produit-details-avis">
            <?php if ($avisStatistiques && $avisStatistiques->nbAvis > 0): ?>
                <div>
                    <?php 
                    $noteArrondie = round($avisStatistiques->moyenne);
                    for($i=1; $i<=5; $i++){
                        echo $i <= $noteArrondie ? '★' : '☆';
                    }
                    ?>
                    <span>
                        <a href="#"><?= $avisStatistiques->nbAvis ?> avis</a>
                    </span>
                </div>
            <?php else: ?>
                <p style="font-size: 14px; color: #888;"><i>Aucune note moyenne pour ce produit.</i></p>
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

        <div class="produit-retour">
            <a href="javascript:window.close()">Retour</a>
        </div>
    </div>
</div>

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
