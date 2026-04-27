<?php
require_once __DIR__ . '/../modele/ModeleFront.php';

class ControleurGererCategorie
{
    private $modeleFront;
    public function __construct()
    {
        $this->modeleFront = new ModeleFront();
    }

    public function gererCategorie()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : 'afficher';
        $idCategorie = isset($_GET['idCategorie']) ? $_GET['idCategorie'] : null;

        switch ($action) {
            case 'afficher':
                $lesCategories = $this->modeleFront->getLesCategories();
                $tousLesProduits = $this->modeleFront->getLesProduitsDuTableau();
                include("vues/v_gererCategorie.php");
                break;

            case 'afficherModifier':
                $laCategorie = $this->modeleFront->getLesInfosCategorie($idCategorie);
                include("vues/v_modifierCategorie.php");
                break;

            case 'afficherAjouter':
                include("vues/v_ajouterCategorie.php");
                break;

            case 'ajouterProduit':
                $laCategorie = $this->modeleFront->getLesInfosCategorie($idCategorie);
                $lesProduitsSansCategorie = $this->modeleFront->getLesProduitsSansCategorie();
                include("vues/v_aujouterProduitCategorie.php");
                break;

            case 'ajouter':
                $id = isset($_POST['id']) ? $_POST['id'] : '';
                $libelle = isset($_POST['libelle']) ? $_POST['libelle'] : '';
                $this->modeleFront->creerCategorie($id, $libelle);
                header("Location: index.php?uc=gererCategorie&action=afficher");
                break;

            case 'modifier':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $libelle = isset($_POST['libelle']) ? $_POST['libelle'] : '';
                    $nouvelId = isset($_POST['id']) ? $_POST['id'] : $idCategorie;
                    $this->modeleFront->modifierCategorie($idCategorie, $nouvelId, $libelle);
                }
                header("Location: index.php?uc=gererCategorie&action=afficher");
                break;

            case 'supprimer':
                $this->modeleFront->supprimerCategorie($idCategorie);
                header("Location: index.php?uc=gererCategorie&action=afficher");
                break;

            case 'changerCategorieProduit':
                $idProduit = isset($_POST['idProduit']) ? $_POST['idProduit'] : null;
                $nouvelleCategorie = isset($_POST['idCategorie']) ? $_POST['idCategorie'] : null;
                if ($idProduit && $nouvelleCategorie) {
                    $this->modeleFront->changerCategorieProduit($idProduit, $nouvelleCategorie);
                }
                header("Location: index.php?uc=gererCategorie&action=afficher");
                break;
        }
    }



}

?>