<?php
require_once __DIR__ . '/../modele/ModeleFront.php';

class ControleurGererPanier
{
    private $modeleFront;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $this->modeleFront = new ModeleFront();
        $this->initPanier();
        // si utilisateur connecté, fusionner le panier DB avec celui en session (une seule fois par session)
        if (!empty($_SESSION['utilisateur']->id) && empty($_SESSION['panier_fusionne'])) {
            $this->chargerEtFusionnerPanierUtilisateur($_SESSION['utilisateur']->id);
            $_SESSION['panier_fusionne'] = true;
        }
    }

    // initialise le panier au format associatif id => quantite
    private function initPanier()
    {
        if (!isset($_SESSION['produits']) || !is_array($_SESSION['produits'])) {
            $_SESSION['produits'] = [];
            return;
        }
        // si format ancien (liste numérique d'ids), convertir en associative
        $isList = array_values($_SESSION['produits']) === $_SESSION['produits'];
        if ($isList) {
            $assoc = [];
            foreach ($_SESSION['produits'] as $id) {
                $id = (string) $id;
                if (isset($assoc[$id]))
                    $assoc[$id]++;
                else
                    $assoc[$id] = 1;
            }
            $_SESSION['produits'] = $assoc;
        }
    }

    // affiche le panier (une carte par produit)
    public function voirPanier()
    {
        $n = $this->nbProduitsDuPanier();
        if ($n > 0) {
            $idsUniques = array_keys($_SESSION['produits']); // id => quantite
            $lesProduitsDuPanier = $this->modeleFront->getLesProduitsDuTableau($idsUniques);
            $lesQuantites = $_SESSION['produits'];
            include(__DIR__ . '/../vues/v_panier.php');
        } else {
            $message = "Le panier est vide !";
            include(__DIR__ . '/../vues/v_message.php');
        }
    }

    public function ajouterAuPanier($idProduit, $quantite = 1)
    {
        $this->initPanier();
        $id = (string) $idProduit;
        $q = max(1, (int)$quantite);
        
        if (isset($_SESSION['produits'][$id])) {
            $_SESSION['produits'][$id] = (int) $_SESSION['produits'][$id] + $q;
        } else {
            $_SESSION['produits'][$id] = $q;
        }
        $this->sauvegarderPanierUtilisateurSiConnecte();
        $this->voirPanier();
    }

    // met à jour la quantité (si q <= 0, supprime)
    public function mettreAJourQuantite($idProduit, $quantite)
    {
        $this->initPanier();
        $id = (string) $idProduit;
        $q = max(0, (int) $quantite);
        if ($q > 0) {
            $_SESSION['produits'][$id] = $q;
        } else {
            unset($_SESSION['produits'][$id]);
        }
        $this->sauvegarderPanierUtilisateurSiConnecte();
        $this->voirPanier();
    }

    // supprime entièrement un produit
    public function supprimerProduitDuPanier($idProduit)
    {
        $this->initPanier();
        $id = (string) $idProduit;
        if (isset($_SESSION['produits'][$id])) {
            unset($_SESSION['produits'][$id]);
        }
        $this->sauvegarderPanierUtilisateurSiConnecte();
        $this->voirPanier();
    }

    // vide le panier
    public function viderPanier()
    {
        $_SESSION['produits'] = [];
        $this->sauvegarderPanierUtilisateurSiConnecte();
        $this->voirPanier();
    }

    // renvoie un tableau d'ids répétés (utile pour la création de commande si attendu)
    public function getLesIdProduitsDuPanier()
    {
        $result = [];
        if (!isset($_SESSION['produits']) || !is_array($_SESSION['produits']))
            return $result;
        foreach ($_SESSION['produits'] as $id => $q) {
            for ($i = 0; $i < (int) $q; $i++)
                $result[] = $id;
        }
        return $result;
    }

    // nombre total d'articles (somme des quantités)
    public function nbProduitsDuPanier()
    {
        $n = 0;
        if (isset($_SESSION['produits']) && is_array($_SESSION['produits'])) {
            foreach ($_SESSION['produits'] as $q)
                $n += (int) $q;
        }
        return $n;
    }

    // --- gestion du panier lié à l'utilisateur en base ---

    // fusionne le panier DB dans la session (additionne les quantités) et sauvegarde
    private function chargerEtFusionnerPanierUtilisateur($idUser)
    {
        if (!method_exists($this->modeleFront, 'getPanierUtilisateur'))
            return;
        $dbPanier = $this->modeleFront->getPanierUtilisateur($idUser);
        if (!is_array($dbPanier))
            $dbPanier = [];
        foreach ($dbPanier as $pid => $q) {
            $pid = (string) $pid;
            $q = max(0, (int) $q);
            if ($q <= 0)
                continue;
            if (isset($_SESSION['produits'][$pid])) {
                $_SESSION['produits'][$pid] = (int) $_SESSION['produits'][$pid] + $q;
            } else {
                $_SESSION['produits'][$pid] = $q;
            }
        }
        $this->sauvegarderPanierUtilisateurSiConnecte();
    }

    // sauvegarde en base si utilisateur connecté
    private function sauvegarderPanierUtilisateurSiConnecte()
    {
        if (empty($_SESSION['utilisateur']->id))
            return;
        if (!method_exists($this->modeleFront, 'sauvegarderPanierUtilisateur'))
            return;
        $this->modeleFront->sauvegarderPanierUtilisateur($_SESSION['utilisateur']->id, $_SESSION['produits']);
    }

    // affiche le formulaire de commande (pré-rempli si utilisateur connecté)
    public function passerCommande()
    {
        if ($this->nbProduitsDuPanier() === 0) {
            $message = "Votre panier est vide, vous ne pouvez pas commander.";
            include(__DIR__ . '/../vues/v_message.php');
            return;
        }
        // pré-remplissage avec les infos de l'utilisateur connecté
        $nom = !empty($_SESSION['utilisateur']->nom) ? htmlspecialchars($_SESSION['utilisateur']->nom, ENT_QUOTES, 'UTF-8') : '';
        $mail = !empty($_SESSION['utilisateur']->mail) ? htmlspecialchars($_SESSION['utilisateur']->mail, ENT_QUOTES, 'UTF-8') : '';
        $rue = '';
        $cp = '';
        $ville = '';
        include(__DIR__ . '/../vues/v_commande.php');
    }

    // traite le formulaire de commande et enregistre en base
    public function confirmerCommande()
    {
        $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
        $rue = isset($_POST['rue']) ? trim($_POST['rue']) : '';
        $cp = isset($_POST['cp']) ? trim($_POST['cp']) : '';
        $ville = isset($_POST['ville']) ? trim($_POST['ville']) : '';
        $mail = isset($_POST['mail']) ? trim($_POST['mail']) : '';

        // validation simple
        if (empty($nom) || empty($rue) || empty($cp) || empty($ville) || empty($mail)) {
            $nom = htmlspecialchars($nom, ENT_QUOTES, 'UTF-8');
            $rue = htmlspecialchars($rue, ENT_QUOTES, 'UTF-8');
            $cp = htmlspecialchars($cp, ENT_QUOTES, 'UTF-8');
            $ville = htmlspecialchars($ville, ENT_QUOTES, 'UTF-8');
            $mail = htmlspecialchars($mail, ENT_QUOTES, 'UTF-8');
            $erreur = "Tous les champs sont obligatoires.";
            include(__DIR__ . '/../vues/v_commande.php');
            return;
        }

        // validation de l'email
        if (strpos($mail, '@') === false) {
            $nom = htmlspecialchars($nom, ENT_QUOTES, 'UTF-8');
            $rue = htmlspecialchars($rue, ENT_QUOTES, 'UTF-8');
            $cp = htmlspecialchars($cp, ENT_QUOTES, 'UTF-8');
            $ville = htmlspecialchars($ville, ENT_QUOTES, 'UTF-8');
            $mail = htmlspecialchars($mail, ENT_QUOTES, 'UTF-8');
            $erreur = "L'adresse e-mail doit obligatoirement contenir un '@'.";
            include(__DIR__ . '/../vues/v_commande.php');
            return;
        }

        if ($this->nbProduitsDuPanier() === 0) {
            $message = "Votre panier est vide, impossible de passer commande.";
            include(__DIR__ . '/../vues/v_message.php');
            return;
        }

        $lesIdProduit = $this->getLesIdProduitsDuPanier();
        $this->modeleFront->creerCommande(
            htmlspecialchars($nom, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($rue, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($cp, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($ville, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($mail, ENT_QUOTES, 'UTF-8'),
            $lesIdProduit
        );

        // vider le panier après commande
        $_SESSION['produits'] = [];
        $this->sauvegarderPanierUtilisateurSiConnecte();

        $message = "Votre commande a bien été enregistrée. Merci !";
        include(__DIR__ . '/../vues/v_message.php');
    }
}
?>