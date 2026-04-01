<?php
require_once __DIR__ . '/../modele/ModeleFront.php';

class ControleurGererProduit
{
    private $modeleFront;
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $this->modeleFront = new ModeleFront();
    }

    public function gererProduit()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : 'afficher';
        $idProduit = isset($_GET['idProduit']) ? $_GET['idProduit'] : null;

        switch ($action) {
            case 'afficher':
                $lesProduits = $this->modeleFront->getLesProduitsDuTableau();
                include("vues/v_produit_gerer.php");
                break;

            case 'afficherAjouter':
                $lesCategories = $this->modeleFront->getLesCategories();
                $lesMarques = $this->modeleFront->getLesMarques();
                $prochainID = count($this->modeleFront->getLesProduitsDuTableau()) + 1;
                include("vues/v_produit_ajout.php");
                break;

            case 'afficherModifier':
                $leProduit = $this->modeleFront->getLesInfosProduit($idProduit);
                $lesCategories = $this->modeleFront->getLesCategories();
                $lesMarques = $this->modeleFront->getLesMarques();
                include("vues/v_produit_edit.php");
                break;

            case 'ajouter':
                $id = isset($_POST['id']) ? trim($_POST['id']) : '';
                $description = isset($_POST['description']) ? trim($_POST['description']) : '';
                $prix = isset($_POST['prix']) ? trim($_POST['prix']) : 0;
                $image = isset($_POST['image']) ? trim($_POST['image']) : '';
                $idCategorie = !empty($_POST['idCategorie']) ? $_POST['idCategorie'] : null;
                $stock = isset($_POST['stock']) ? intval($_POST['stock']) : 0;
                $marqueID = isset($_POST['marqueID']) ? intval($_POST['marqueID']) : 1;
                
                if ($id !== '') {
                    $this->modeleFront->creerProduit($id, $description, $prix, $image, $idCategorie, $stock, $marqueID);
                }
                header("Location: index.php?uc=gererProduit&action=afficher");
                break;

            case 'modifier':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
                    $prix = isset($_POST['prix']) ? trim($_POST['prix']) : 0;
                    $image = isset($_POST['image']) ? trim($_POST['image']) : '';
                    $idCategorie = !empty($_POST['idCategorie']) ? $_POST['idCategorie'] : null;
                    $stock = isset($_POST['stock']) ? intval($_POST['stock']) : 0;
                    $marqueID = isset($_POST['marqueID']) ? intval($_POST['marqueID']) : 1;

                    if ($idProduit) {
                        $this->modeleFront->modifierProduit($idProduit, $description, $prix, $image, $idCategorie, $stock, $marqueID);
                    }
                }
                header("Location: index.php?uc=gererProduit&action=afficher");
                break;

            case 'supprimer':
                if ($idProduit) {
                    $this->modeleFront->supprimerProduit($idProduit);
                }
                header("Location: index.php?uc=gererProduit&action=afficher");
                break;
        }
    }
}
?>
