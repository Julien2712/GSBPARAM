<div id="accueil">

<div id="textAccueil">
<h1>La société Gsb</h1>


<h2> <p>vous souhaite la bienvenue sur son site de vente en ligne,<br/>
de produits paramédicaux et bien-être  <br/>
à destination des particuliers.</p>

<p>Avec plus de 2000 produits paramédicaux à la vente, GsbPara vous propose à 
un tarif compétitif un large panel de produits livrés rapidement chez vous !</p>
</h2>
</div>

<?php if (isset($produitsMisEnAvant) && count($produitsMisEnAvant) > 0): ?>
    <div class="produits-mis-en-avant" style="margin-top: 40px;">
        <h2 style="text-align: center; color: #28a745; margin-bottom: 20px;">Produits mis en avant</h2>
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;">
            <?php foreach($produitsMisEnAvant as $unProduit): ?>
                <div class="card" style="width: 250px; border: 1px solid #ccc; padding: 15px; border-radius: 10px; text-align: center;">
                    <br>
                    <?php if (!empty($unProduit->image)): ?>
                        <div style="text-align: center;">
                            <img src="<?php echo htmlspecialchars($unProduit->image); ?>" alt="image produit" style="max-height: 150px; max-width: 100%; border-radius: 5px;">
                        </div>
                    <?php endif; ?>
                    <br>
                    <h5 style="color: #28a745;"><?php echo htmlspecialchars($unProduit->description); ?></h5>
                    <p style="font-weight: bold;">À partir de <?php echo $unProduit->prix; ?> €</p>
                    <a href="index.php?uc=voirProduits&action=voirDetails&produit=<?php echo $unProduit->id; ?>" class="btn btn-outline-success" style="padding: 5px 15px; border: 1px solid #28a745; color: #28a745; text-decoration: none; border-radius: 5px;">Voir</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

</div>