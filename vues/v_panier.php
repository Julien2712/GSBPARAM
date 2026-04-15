<div class="alert alert-light" role="alert" id="panier" style="text-align: center; border: none; background: transparent; margin-bottom: 20px;">
    <h2 style="color: #2e8b57; font-weight: bold;">Mon Panier</h2>
</div>

<div class="panier-container" style="display: flex; gap: 20px; flex-wrap: wrap; justify-content: center; max-width: 1200px; margin: 0 auto;">
    
    <div class="panier-produits" id="produits" style="flex: 2; min-width: 300px; display: flex; flex-direction: column; gap: 15px;">
        <?php
        if(!isset($lesProduitsDuPanier)) $lesProduitsDuPanier = [];
        if(!isset($lesQuantites)) $lesQuantites = [];

        $totalTTC = 0;

        foreach($lesProduitsDuPanier as $unProduit)
        {
            $id = (string)$unProduit->id;
            $description = htmlspecialchars($unProduit->description ?? '', ENT_QUOTES, 'UTF-8');
            $image = htmlspecialchars($unProduit->image ?? '', ENT_QUOTES, 'UTF-8');
            $prix = floatval($unProduit->prix ?? 0);
            $quantite = isset($lesQuantites[$id]) ? (int)$lesQuantites[$id] : 1;
            $totalTTC += $prix * $quantite;
        ?>
            <div class="panier-item" style="display: flex; flex-direction: row; width: 100%; border: 1px solid #eee; padding: 15px; border-radius: 5px; background: #fff; align-items: center; justify-content: space-between; border-left: 4px solid #2e8b57; box-sizing: border-box;">
                <div style="flex: 1; text-align: center;">
                    <img src="<?= $image ?>" alt="image descriptive" style="max-height: 150px; max-width: 100%; object-fit: contain;">
                </div>
                
                <div style="flex: 2; text-align: center;">
                    <h4 style="color: #2e8b57; margin-bottom: 5px;"><?= $description ?></h4>
                    <p style="color: #777; font-size: 0.9em; margin-bottom: 10px;">Produit de la catégorie <?= htmlspecialchars($unProduit->idCategorie ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                    
                    <div style="font-weight: bold; margin-bottom: 10px;"><?= number_format($prix, 2) ?>€</div>
                    
                    <div style="margin-bottom: 15px;">
                        <form action="index.php" method="post" style="display:inline; margin:0;">
                            <input type="hidden" name="uc" value="gererPanier">
                            <input type="hidden" name="action" value="mettreAJourQuantite">
                            <input type="hidden" name="produit" value="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>">
                            <label for="quantite_<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>" style="color: #555;">Quantité: </label>
                            <select name="quantite" id="quantite_<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>" onchange="this.form.submit()" style="padding: 2px; border: 1px solid #ccc; border-radius: 3px;">
                                <?php for($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>" <?= $i == $quantite ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <noscript><button type="submit">OK</button></noscript>
                        </form>
                    </div>
                    
                    <div>
                        <a href="index.php?uc=voirProduits&produit=<?= urlencode($id) ?>&action=voirDetails" style="display: inline-block; padding: 5px 15px; background-color: #2e8b57; color: white; text-decoration: none; border-radius: 3px; font-size: 0.9em;">Voir</a>
                        <a href="index.php?uc=gererPanier&produit=<?= urlencode($id) ?>&action=supprimerUnProduit" onclick="return confirm('Voulez-vous vraiment retirer cet article ?');" style="display: inline-block; padding: 4px 14px; background-color: white; color: #555; text-decoration: none; border: 1px solid #ccc; border-radius: 3px; font-size: 0.9em; margin-left: 5px;">Retirer</a>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <div class="panier-recap" style="flex: 1; min-width: 250px; max-width: 350px;">
        <div style="border: 1px solid #eee; padding: 20px; border-radius: 5px; background: #fff; position: sticky; top: 20px;">
            <h3 style="margin-top: 0; color: #333; font-size: 1.5em; margin-bottom: 20px;">Total</h3>
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.95em; color: #555;">
                <span>Sous-total</span>
                <span><?= number_format($totalTTC ?? 0, 2) ?> €</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 0.95em; color: #555;">
                <span>Livraison</span>
                <span>(Gratuit) 0.00 €</span>
            </div>
            <hr style="border: none; border-top: 1px solid #eee; margin-bottom: 15px;">
            <div style="display: flex; justify-content: space-between; font-weight: bold; margin-bottom: 25px; font-size: 1.1em; color: #333;">
                <span>Total TTC</span>
                <span><?= number_format($totalTTC ?? 0, 2) ?> €</span>
            </div>
            
            <div style="display: flex; gap: 10px; justify-content: center;">
                <a href="index.php?uc=gererPanier&action=passerCommande" style="flex: 1; text-align: center; display: inline-block; padding: 8px 15px; background-color: #2e8b57; color: white; text-decoration: none; border-radius: 3px; font-weight: bold; font-size: 0.9em; box-sizing: border-box;">Commander</a>
                <a href="index.php?uc=gererPanier&action=viderPanier" onclick="return confirm('Voulez-vous vraiment vider tout le panier ?');" style="flex: 1; text-align: center; display: inline-block; padding: 7px 10px; background-color: white; color: #2e8b57; text-decoration: none; border: 1px solid #2e8b57; border-radius: 3px; font-size: 0.9em; box-sizing: border-box;">Vider le panier</a>
            </div>
        </div>
    </div>
</div>