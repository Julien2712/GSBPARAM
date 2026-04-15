<?php
/** @file ControleurMiseEnAvant.php
 * @details Gère la programmation des mises en avant de produits
*/
require_once __DIR__ . '/../modele/ModeleFront.php';

class ControleurMiseEnAvant{
    private $modele;

    public function __construct()
    {
        $this->modele = new ModeleFront();
    }
    
    public function gerer() {
        if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']->habId != 2) {
            // Seulement l'administrateur
            header('Location: index.php?uc=accueil');
            exit;
        }

        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'afficher';
        
        switch ($action) {
            case 'afficher':
                $this->afficher();
                break;
            case 'ajouter':
                $this->ajouter();
                break;
            case 'supprimer':
                $this->supprimer($_REQUEST['id']);
                break;
            default:
                $this->afficher();
                break;
        }
    }

    private function afficher($messages = [], $erreurs = []) {
        $programmations = $this->modele->getToutesProgrammationMiseEnAvant();
        $tousLesProduits = $this->modele->getLesProduitsDuTableau(); // On récupère tous les produits pour le select
        
        include("vues/v_miseEnAvant.php");
    }

    private function ajouter() {
        $idProduit = $_POST['produit'] ?? null;
        $dateDebut = $_POST['dateDebut'] ?? null;
        $dateFin = $_POST['dateFin'] ?? null;
        
        $erreurs = [];
        $messages = [];
        
        if (!$idProduit || !$dateDebut || !$dateFin) {
            $erreurs[] = "Tous les champs sont obligatoires.";
        } else {
            $aujourdhui = date('Y-m-d');
            if ($dateDebut < $aujourdhui) {
                // 2.b.4
                $erreurs[] = "La date de début ne peut pas être inférieure à la date du jour.";
            }
            if ($dateFin < $dateDebut) {
                // 2.b.5
                $erreurs[] = "La date de fin ne peut pas être inférieure à la date de début.";
            }
            
            // Vérifier si le produit a déjà une programmation (2.b.6)
            $progExistante = $this->modele->getToutesProgrammationMiseEnAvant();
            foreach ($progExistante as $p) {
                if ($p->id == $idProduit) {
                    $erreurs[] = "Une programmation existe déjà pour ce produit.";
                    break;
                }
            }
        }
        
        if (empty($erreurs)) {
            $ok = $this->modele->programmerMiseEnAvant($idProduit, $dateDebut, $dateFin);
            if ($ok) {
                $messages[] = "La programmation a bien été enregistrée.";
            } else {
                $erreurs[] = "Erreur lors de l'enregistrement en base.";
            }
        }
        
        $this->afficher($messages, $erreurs);
    }
    
    private function supprimer($idProduit) {
        $erreurs = [];
        $messages = [];
        $ok = $this->modele->supprimerMiseEnAvant($idProduit);
        if ($ok) {
            $messages[] = "Programmation supprimée.";
        } else {
            $erreurs[] = "Erreur lors de la suppression.";
        }
        $this->afficher($messages, $erreurs);
    }
}
?>
