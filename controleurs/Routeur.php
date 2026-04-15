<?php
$ctrlDir = __DIR__;
require_once $ctrlDir . '/ControleurVoirProduits.php';
require_once $ctrlDir . '/ControleurAccueil.php';
require_once $ctrlDir . '/ControleurGererPanier.php';
require_once $ctrlDir . '/ControleurGererCategorie.php';
require_once $ctrlDir . '/ControleurGererPoduit.php';
require_once $ctrlDir . '/ControleurMiseEnAvant.php';

// vérification explicite avant require
if (!is_file($ctrlDir . '/ControleurUtilisateur.php')) {
    die('Fichier manquant: ' . $ctrlDir . '/ControleurUtilisateur.php');
}
require_once $ctrlDir . '/ControleurUtilisateur.php';

class Routeur
{
    private $ctrlVoirProduits;
    private $ctrlAccueil;
    private $ctrlGererPanier;
    private $ctrlUtilisateur;

    private $ctrlGererCategorie;
    private $ctrlGererProduit;
    private $ctrlMiseEnAvant;

    public function __construct()
    {
        $this->ctrlVoirProduits = new ControleurVoirProduits();
        $this->ctrlAccueil = new ControleurAccueil();
        $this->ctrlGererPanier = new ControleurGererPanier();
        $this->ctrlUtilisateur = new ControleurUtilisateur();
        $this->ctrlGererCategorie = new ControleurGererCategorie();
        $this->ctrlGererProduit = new ControleurGererProduit();
        $this->ctrlMiseEnAvant = new ControleurMiseEnAvant();
    }

    public function routerRequete()
    {
        if (isset($_REQUEST['uc']))
            $uc = $_REQUEST['uc'];
        else
            $uc = 'accueil';
        if (isset($_REQUEST['action']))
            $action = $_REQUEST['action'];
        else
            $action = null;

        switch ($uc) {
            case 'accueil':
                $this->ctrlAccueil->accueil();
                break;

            case 'mentionsLegales':
                $this->ctrlAccueil->mentionsLegales();
                break;

            case 'voirProduits':
                switch ($action) {
                    case null:
                    case 'voirCategories': {
                        $this->ctrlVoirProduits->voirProduits(null);
                        break;
                    }
                    case 'voirProduits': {
                        $this->ctrlVoirProduits->voirProduits($_REQUEST['categorie']);
                        break;
                    }
                    case 'nosProduits': {
                        $this->ctrlVoirProduits->voirTousLesProduits();
                        break;
                    }
                    case 'voirDetails': {
                        $this->ctrlVoirProduits->voirDetails($_REQUEST['produit']);
                        break;
                    }
                    case 'filtrer': {
                        $this->ctrlVoirProduits->filtrer();
                        break;
                    }
                    case 'donnerAvis': {
                        $this->ctrlVoirProduits->donnerAvis($_REQUEST['produit']);
                        break;
                    }
                    case 'validerAvis': {
                        $this->ctrlVoirProduits->validerAvis($_REQUEST['produit'], $_POST);
                        break;
                    }
                }
                ;
                break;

            case 'gererPanier':
                switch ($action) {
                    case null:
                    case 'voirPanier': {
                        $this->ctrlGererPanier->voirPanier();
                        break;
                    }
                    case 'ajouterAuPanier': {
                        $q = isset($_REQUEST['quantite']) ? $_REQUEST['quantite'] : 1;
                        $this->ctrlGererPanier->ajouterAuPanier($_REQUEST['produit'], $q);
                        break;
                    }
                    case 'mettreAJourQuantite': {
                        $q = isset($_REQUEST['quantite']) ? $_REQUEST['quantite'] : 0;
                        // accepter POST aussi
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantite']))
                            $q = $_POST['quantite'];
                        $this->ctrlGererPanier->mettreAJourQuantite($_REQUEST['produit'], $q);
                        break;
                    }
                    case 'supprimerUnProduit': {
                        $this->ctrlGererPanier->supprimerProduitDuPanier($_REQUEST['produit']);
                        break;
                    }
                    case 'viderPanier': {
                        $this->ctrlGererPanier->viderPanier();
                        break;
                    }
                    case 'passerCommande':
                        $this->ctrlGererPanier->passerCommande();
                        break;
                    case 'confirmerCommande':
                        $this->ctrlGererPanier->confirmerCommande();
                        break;
                    default: {
                        $this->ctrlGererPanier->voirPanier();
                        break;
                    }
                }
                ;
                break;

            case 'gererCategorie':
                $this->ctrlGererCategorie->gererCategorie();
                break;

            case 'gererProduit':
                $this->ctrlGererProduit->gererProduit();
                break;

            case 'gererMiseEnAvant':
                $this->ctrlMiseEnAvant->gerer();
                break;

            case 'utilisateur':
                switch ($action) {
                    case 'connexion': {
                        $this->ctrlUtilisateur->afficherConnexion();
                        break;
                    }
                    case 'seConnecter': {
                        $this->ctrlUtilisateur->seConnecter();
                        break;
                    }
                    case 'deconnexion': {
                        $this->ctrlUtilisateur->deconnecter();
                        break;
                    }
                    case 'inscription': {
                        $this->ctrlUtilisateur->afficherInscription();
                        break;
                    }
                    case 'creerCompte': {
                        $this->ctrlUtilisateur->creerCompte();
                        break;
                    }
                    case 'espaceClient': {
                        $this->ctrlUtilisateur->afficherEspaceClient();
                        break;
                    }
                    default: {
                        $this->ctrlUtilisateur->afficherConnexion();
                        break;
                    }
                }
                ;
                break;

            case 'administrer':
                break;
        }
    }
}
?>