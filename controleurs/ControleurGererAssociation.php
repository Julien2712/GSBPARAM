<?php
require_once __DIR__ . '/../modele/ModeleFront.php';

class ControleurGererAssociation
{
    private $modeleFront;
    public function __construct()
    {
        $this->modeleFront = new ModeleFront();
    }

    public function gererAssociation()
    {
        if (!estAdmin()) {
            echo '<script>window.location.href="index.php?uc=accueil";</script>';
            exit;
        }

        $action = isset($_GET['action']) ? $_GET['action'] : 'afficher';

        switch ($action) {
            case 'afficher':
                $lesAssociations = $this->modeleFront->getLesAssociations();
                $lesProduits = $this->modeleFront->getLesProduitsDuTableau();
                include("vues/v_gererAssociation.php");
                break;

            case 'ajouter':
                $prodId = isset($_POST['prodId']) ? $_POST['prodId'] : '';
                $prodIdAssocie = isset($_POST['prodIdAssocie']) ? $_POST['prodIdAssocie'] : '';
                if (!empty($prodId) && !empty($prodIdAssocie) && $prodId !== $prodIdAssocie) {
                    $succes = $this->modeleFront->ajouterAssociation($prodId, $prodIdAssocie);
                    if ($succes) {
                        echo '<script>window.location.href="index.php?uc=gererAssociation&action=afficher&succes=ajout";</script>';
                    } else {
                        echo '<script>window.location.href="index.php?uc=gererAssociation&action=afficher&erreur=ajout_db";</script>';
                    }
                } else {
                    echo '<script>window.location.href="index.php?uc=gererAssociation&action=afficher&erreur=invalide";</script>';
                }
                exit;
                break;

            case 'supprimer':
                $prodId = isset($_GET['prodId']) ? $_GET['prodId'] : '';
                $prodIdAssocie = isset($_GET['prodIdAssocie']) ? $_GET['prodIdAssocie'] : '';
                if (!empty($prodId) && !empty($prodIdAssocie)) {
                    $this->modeleFront->supprimerAssociation($prodId, $prodIdAssocie);
                }
                echo '<script>window.location.href="index.php?uc=gererAssociation&action=afficher";</script>';
                exit;
                break;

            case 'afficherModifier':
                $prodId = isset($_GET['prodId']) ? $_GET['prodId'] : '';
                $prodIdAssocie = isset($_GET['prodIdAssocie']) ? $_GET['prodIdAssocie'] : '';
                $lesProduits = $this->modeleFront->getLesProduitsDuTableau();
                include("vues/v_association_edit.php");
                break;

            case 'modifier':
                $ancienProdId = isset($_POST['ancienProdId']) ? $_POST['ancienProdId'] : '';
                $ancienProdIdAssocie = isset($_POST['ancienProdIdAssocie']) ? $_POST['ancienProdIdAssocie'] : '';
                $nouveauProdId = isset($_POST['prodId']) ? $_POST['prodId'] : '';
                $nouveauProdIdAssocie = isset($_POST['prodIdAssocie']) ? $_POST['prodIdAssocie'] : '';
                
                if (!empty($ancienProdId) && !empty($ancienProdIdAssocie) && !empty($nouveauProdId) && !empty($nouveauProdIdAssocie) && $nouveauProdId !== $nouveauProdIdAssocie) {
                    $succes = $this->modeleFront->modifierAssociation($ancienProdId, $ancienProdIdAssocie, $nouveauProdId, $nouveauProdIdAssocie);
                    if ($succes) {
                        echo '<script>window.location.href="index.php?uc=gererAssociation&action=afficher&succes=modif";</script>';
                    } else {
                        echo '<script>window.location.href="index.php?uc=gererAssociation&action=afficher&erreur=modif_db";</script>';
                    }
                } else {
                    echo '<script>window.location.href="index.php?uc=gererAssociation&action=afficher&erreur=invalide";</script>';
                }
                exit;
                break;
        }
    }
}

?>
