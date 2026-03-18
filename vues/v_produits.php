<?php
echo "<h2>$titreCategorie</h2>";
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
				<div class="photoCard"><img src="<?= $image ?>" alt=image /></div>
				<div class="descrCard"><?= $description ?></div>
				<div class="prixCard"><?= $prix . "€" ?></div>
			</div>
			<div class="imgCard"><a href="index.php?uc=gererPanier&produit=<?= $id ?>&action=ajouterAuPanier">
					<img src="assets/images/mettrepanier.png" title="Ajouter au panier" alt="Mettre au panier"> </a></div>

		</div>
		<?php
	}
	?>
</div>