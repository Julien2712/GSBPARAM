<?php
echo "<h2>$titreCategorie</h2>";
if (isset($erreurFiltre)) {
    echo "<div style='color: white; background-color: #dc3545; padding: 10px; border-radius: 5px; margin-bottom: 20px;'>$erreurFiltre</div>";
}
?>
<div id="produits">
	<?php

	foreach ($lesProduits as $unProduit) {
		$id = $unProduit->id;
		$description = $unProduit->description;
		$image = $unProduit->image;
		$prix = $unProduit->prix;

		?>
		<div id="card">
			<div>
				<div class="photoCard"><a target="_blank" href="index.php?uc=voirProduits&produit=<?= $id ?>&action=voirDetails"><img src="<?= $image ?? '' ?>" alt="image" /></a></div>
				<div class="descrCard"><a target="_blank" href="index.php?uc=voirProduits&produit=<?= $id ?>&action=voirDetails" style="text-decoration:none; color:inherit;"><?= htmlspecialchars($description ?? '', ENT_QUOTES, 'UTF-8') ?></a></div>
				<div class="prixCard"><?= htmlspecialchars($prix ?? '', ENT_QUOTES, 'UTF-8') . " €" ?></div>
			</div>
			<div style="display: flex; justify-content: space-between; align-items: center; padding: 0 10px;">
				<div class="imgCard"><a href="index.php?uc=gererPanier&produit=<?= $id ?>&action=ajouterAuPanier">
						<img src="assets/images/mettrepanier.png" title="Ajouter au panier" alt="Mettre au panier"> </a></div>
				<a target="_blank" href="index.php?uc=voirProduits&produit=<?= $id ?>&action=voirDetails" style="background-color: #28a745; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; font-size: 14px;">Infos du produit</a>
			</div>
		</div>
		<?php
	}
	?>
</div>