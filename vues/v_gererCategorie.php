<div class="alert alert-light" role="alert" id="categorie">Gérer les catégories :</div>

<?php


foreach ($lesCategories as $uneCategorie) {
    $id = $uneCategorie->id;
    $libelle = $uneCategorie->libelle;
    ?>
    <div class="categorie-item border p-3 mb-2 rounded" id="categorie-<?= $id ?>">
        <div class="d-flex justify-content-between align-items-center">
            <span><strong>Nom :</strong> <?= $libelle ?> | <strong>ID :</strong> <?= $id ?></span>
            <div class="d-flex gap-2">
                <a href="index.php?uc=gererCategorie&idCategorie=<?= $id ?>&action=afficherModifier"
                    class="btn btn-warning btn-sm" type="button">
                    Modifier
                </a>
                <a href="index.php?uc=gererCategorie&idCategorie=<?= $id ?>&action=supprimer" class="btn btn-danger btn-sm"
                    type="button">
                    Supprimer
                </a>
                <a href="index.php?uc=gererCategorie&idCategorie=<?= $id ?>&action=ajouterProduit"
                    class="btn btn-primary btn-sm" type="button">
                    Ajouter un produit
                </a>
            </div>
        </div>
    </div>
    <?php
}
?>