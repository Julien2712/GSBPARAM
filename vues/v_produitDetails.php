<div id="produitDetails" style="display:flex; flex-wrap: wrap; padding:20px; justify-content:center; font-family: sans-serif; max-width: 900px; margin: 0 auto; background: white; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
    <div style="flex:1; min-width: 300px; text-align:center;">
        <img src="<?= $produit->image ?? '' ?>" alt="image produit" style="max-width:100%; max-height: 400px; object-fit: contain;"/>
    </div>
    <div style="flex:1; min-width: 300px; padding: 20px;">
        <h2 style="color:#28a745; margin-top: 0;"><?= htmlspecialchars($produit->description ?? '', ENT_QUOTES, 'UTF-8') ?></h2>
        <p style="font-size: 14px; color: #555;">
            Produit de la marque <strong><?= htmlspecialchars($marque->libelle ?? '', ENT_QUOTES, 'UTF-8') ?></strong> 
            de la catégorie <strong><?= htmlspecialchars($categorie->libelle ?? '', ENT_QUOTES, 'UTF-8') ?></strong>
        </p>
        
        <div style="margin-top: 20px;">
            <u style="font-size: 14px; color: #555;">Description :</u><br>
            <p style="font-size: 14px; color: #666; line-height: 1.5;">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus aliquam venenatis neque, quis pretium orci molestie non.
            </p>
        </div>

        <div style="margin: 20px 0;">
            <?php if ($avisStatistiques && $avisStatistiques->nbAvis > 0): ?>
                <div style="color: #ffc107; font-size: 18px;">
                    <?php 
                    $noteArrondie = round($avisStatistiques->moyenne);
                    for($i=1; $i<=5; $i++){
                        echo $i <= $noteArrondie ? '★' : '☆';
                    }
                    ?>
                    <span style="color:black; font-size:14px; margin-left: 10px;">
                        <a href="#" style="color: #28a745; text-decoration: underline;"><?= $avisStatistiques->nbAvis ?> avis</a>
                    </span>
                </div>
            <?php else: ?>
                <p style="font-size: 14px; color: #888;"><i>Aucune note moyenne pour ce produit.</i></p>
            <?php endif; ?>
        </div>

        <?php if (!empty($produit->contenance)): ?>
        <div style="margin-bottom: 20px; font-size: 14px; color: #555;">
            Contenance : <span style="font-weight:bold;"><?= $produit->contenance ?> ml</span>
        </div>
        <?php endif; ?>

        <div style="margin-top:20px;">
            <span style="color: #28a745; font-weight:bold; font-size: 24px;"><?= $produit->prix ?>€</span> 
            <span style="font-size: 14px; margin-left:10px;">
                <?php if ($produit->stock == 0): ?>
                    - <span style="color: red;">Rupture de Stock</span>
                <?php elseif ($produit->stock <= 5): ?>
                    - <span style="color: #28a745;">En Stock (plus que <?= $produit->stock ?>)</span>
                <?php else: ?>
                    - <span style="color: #28a745;">En Stock</span>
                <?php endif; ?>
            </span>
        </div>

        <?php if (isset($_SESSION['utilisateur']) && $produit->stock > 0): ?>
            <div style="margin-top:20px; display: flex; align-items: center; gap: 10px;">
                <form action="index.php?uc=gererPanier&produit=<?= $produit->id ?>&action=ajouterAuPanier" method="POST" style="margin:0;">
                    <select name="quantite" style="padding:8px; border: 1px solid #ccc; border-radius: 4px;">
                        <?php 
                        $maxStock = min((int)$produit->stock, 10); 
                        for ($i = 1; $i <= $maxStock; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <button type="submit" style="background-color: #28a745; color: white; padding: 10px 20px; border:none; border-radius: 5px; cursor:pointer; font-weight: bold;">Ajouter au panier</button>
                </form>
            </div>
        <?php endif; ?>

        <div style="margin-top:30px; text-align: center;">
            <a href="javascript:window.close()" style="display: inline-block; border: 1px solid #28a745; color: #28a745; padding: 8px 30px; text-decoration: none; border-radius: 5px; text-transform: uppercase; font-size: 14px; font-weight: bold;">Retour</a>
        </div>
    </div>
</div>

<?php if (count($produitsAssocies) > 0): ?>
    <div style="margin-top:50px; text-align:center;">
        <h3 style="color:#888; text-transform: uppercase; font-size: 16px; letter-spacing: 1px;">Vous aimerez peut-être aussi...</h3>
        <div style="display:flex; justify-content:center; gap:20px; flex-wrap: wrap; margin-top: 20px;">
            <?php foreach($produitsAssocies as $pAssoc): ?>
                <div style="width: 150px; background: white; border: 1px solid #eee; padding:15px; border-radius:8px; text-align:center; transition: transform 0.2s;">
                    <a href="index.php?uc=voirProduits&produit=<?= $pAssoc->id ?>&action=voirDetails" target="_blank" style="text-decoration:none; color:inherit; display:block;">
                        <img src="<?= $pAssoc->image ?>" style="max-height:100px; max-width: 100px; object-fit:contain; margin-bottom: 10px;"/>
                        <p style="margin:0; font-size:12px; height: 3em; overflow: hidden;"><?= htmlspecialchars($pAssoc->description, ENT_QUOTES, 'UTF-8') ?></p>
                        <p style="font-weight:bold; margin:10px 0 0 0; font-size:14px; color: #333;"><?= $pAssoc->prix ?>€</p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
