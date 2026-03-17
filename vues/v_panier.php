<div class="alert alert-light" role="alert" id="panier">Votre panier :</div>
<div id="produits">
<?php
if(!isset($lesProduitsDuPanier)) $lesProduitsDuPanier = [];
if(!isset($lesQuantites)) $lesQuantites = [];

foreach( $lesProduitsDuPanier as $unProduit)
{
    $id = (string)$unProduit->id;
    $description = htmlspecialchars($unProduit->description, ENT_QUOTES, 'UTF-8');
    $image = htmlspecialchars($unProduit->image, ENT_QUOTES, 'UTF-8');
    $prix = htmlspecialchars($unProduit->prix, ENT_QUOTES, 'UTF-8');
    $quantite = isset($lesQuantites[$id]) ? (int)$lesQuantites[$id] : 1;
?>
    <div id="card">
        <div class="photoCard"><img src="<?= $image ?>" alt="image descriptive" /></div>
        <div class="descrCard"><?= $description ?></div>
        <div class="prixCard"><?= $prix."€" ?></div>

        <div class="quantiteCard">
            <a href="index.php?uc=gererPanier&action=mettreAJourQuantite&produit=<?= urlencode($id) ?>&quantite=<?= $quantite+1 ?>"
               style="text-decoration:none; color:inherit; font-weight:bold;" aria-label="Ajouter quantité">+</a>

            <form action="index.php" method="post" style="display:inline; margin:0;">
                <input type="hidden" name="uc" value="gererPanier">
                <input type="hidden" name="action" value="mettreAJourQuantite">
                <input type="hidden" name="produit" value="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>">
                <input type="number" name="quantite" min="1" max="100" value="<?= $quantite ?>" style="width:60px;" onchange="this.form.submit()">
                <noscript><button type="submit">OK</button></noscript>
            </form>

            <a href="index.php?uc=gererPanier&action=mettreAJourQuantite&produit=<?= urlencode($id) ?>&quantite=<?= max(0,$quantite-1) ?>"
               style="text-decoration:none; color:inherit; font-weight:bold;" aria-label="Diminuer quantité">-</a>
        </div>

        <div class="imgCard">
            <a href="index.php?uc=gererPanier&produit=<?= urlencode($id) ?>&action=supprimerUnProduit" onclick="return confirm('Voulez-vous vraiment retirer cet article ?');">
                <img src="assets/images/retirerpanier.png" title="Retirer du panier" alt="retirer du panier">
            </a>
        </div>
    </div>
<?php
}
?>
</div>
<div class="contenuCentre">
    <a href="index.php?uc=gererPanier&action=passerCommande"><button type="button" class="btn btn-primary">Commander</button></a>
    <a href="index.php?uc=gererPanier&action=viderPanier" onclick="return confirm('Voulez-vous vraiment vider tout le panier ?');">
        <button type="button" class="btn btn-danger">Vider le panier</button></a>
</div>