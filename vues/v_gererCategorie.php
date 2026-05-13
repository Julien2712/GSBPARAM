<div class="alert alert-light" role="alert" id="categorie">Gérer les catégories :</div>

<?php if (isset($_GET['succes']) && $_GET['succes'] === 'suppr'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Succès !</strong> La catégorie a été supprimée.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['erreur']) && $_GET['erreur'] === 'non_vide'): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Erreur !</strong> Cette catégorie contient des produits et ne peut pas être supprimée.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="mb-3 contenuCentre">
    <a href="index.php?uc=gererCategorie&action=afficherAjouter" class="btn btn-primary shadow-sm"">
        Créer une catégorie
    </a>
</div>

<?php


foreach ($lesCategories as $uneCategorie) {
    $id = $uneCategorie->id;
    $libelle = $uneCategorie->libelle;
    ?>
    <div class=" categorie-item border p-3 mb-2 rounded" id="categorie-<?= $id ?>">
            <div class="d-flex justify-content-between align-items-center">
                <span><strong>Nom :</strong> <?= $libelle ?> | <strong>ID :</strong> <?= $id ?></span>
                <div class="d-flex gap-2">
                    <a href="index.php?uc=gererCategorie&idCategorie=<?= $id ?>&action=afficherModifier"
                        class="btn btn-warning btn-sm" type="button">
                        Modifier
                    </a>
                    <a href="index.php?uc=gererCategorie&idCategorie=<?= $id ?>&action=supprimer"
                        class="btn btn-danger btn-sm" type="button">
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