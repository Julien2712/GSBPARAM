<div class="alert alert-light" role="alert" id="panier">Votre panier :</div>
<div id="produits">
<?php
foreach( $lesProduitsDuPanier as $unProduit) 
{
    $id = $unProduit->id;
    $description = $unProduit->description;
    $image = $unProduit->image;
    $prix = $unProduit->prix;
?>
    <div id="card">
    <div>
    <div class="photoCard"><img src="<?= $image ?>" alt="image descriptive" /></div>
    <div class="descrCard"><?= $description ?></div>
    <div class="prixCard"><?= $prix."€" ?></div>
    </div>
    <div class="imgCard"><a href="index.php?uc=gererPanier&produit=<?= $id ?>&action=supprimerUnProduit" onclick="return confirm('Voulez-vous vraiment retirer cet article ?');">
    <img src="assets/images/retirerpanier.png" title="Retirer du panier" alt="retirer du panier"></a></div>
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