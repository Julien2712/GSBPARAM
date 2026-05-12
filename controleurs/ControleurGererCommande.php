<?php
require_once __DIR__ . '/../modele/ModeleFront.php';

class ControleurGererCommande
{
    private $modeleFront;

    public function __construct()
    {
        $this->modeleFront = new ModeleFront();
    }

    public function gererCommande()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : 'afficher';

        switch ($action) {
            case 'afficher':
                $lesCommandes = $this->modeleFront->getLesCommandes();
                include("vues/v_gererCommande.php");
                break;
            case 'afficherDetails':
                if (isset($_GET['id'])) {
                    $idCommande = $_GET['id'];
                    $infosCommande = $this->modeleFront->getInfosCommande($idCommande);
                    $lesDetails = $this->modeleFront->getDetailsCommande($idCommande);
                    include("vues/v_gererCommandeDetails.php");
                } else {
                    echo '<script>window.location.href="index.php?uc=gererCommande&action=afficher";</script>';
                    exit;
                }
                break;
            case 'supprimer':
                if (isset($_GET['id'])) {
                    $idCommande = $_GET['id'];
                    $this->modeleFront->supprimerCommande($idCommande);
                }
                echo '<script>window.location.href="index.php?uc=gererCommande&action=afficher";</script>';
                exit;
                break;
            case 'changerEtat':
                if (isset($_POST['idCommande']) && isset($_POST['etat'])) {
                    $idCommande = $_POST['idCommande'];
                    $etat = $_POST['etat'];
                    $this->modeleFront->changerEtatCommande($idCommande, $etat);
                    echo '<script>window.location.href="index.php?uc=gererCommande&action=afficherDetails&id=' . urlencode($idCommande) . '";</script>';
                } else {
                    echo '<script>window.location.href="index.php?uc=gererCommande&action=afficher";</script>';
                }
                exit;
                break;
        }
    }
}
?>