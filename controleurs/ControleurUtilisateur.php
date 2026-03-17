<?php
// dev: afficher les erreurs (en local seulement)
if (php_sapi_name() !== 'cli') { ini_set('display_errors', 1); error_reporting(E_ALL); }

require_once __DIR__ . '/../modele/ModeleFront.php';

class ControleurUtilisateur {
    private $modeleFront;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->modeleFront = new ModeleFront();
    }

    public function afficherConnexion() {
        include __DIR__ . '/../vues/v_connexion.php';
    }

    public function seConnecter() {
        $login = trim($_POST['login'] ?? '');
        $mdp   = $_POST['mdp'] ?? '';
        $msgErreurs = [];

        if ($login === '' || $mdp === '') {
            $msgErreurs[] = 'Login et mot de passe obligatoires.';
            include __DIR__ . '/../vues/v_connexion.php';
            return;
        }

        $user = $this->modeleFront->getUserByLogin($login);
        if ($user && isset($user->motdepasse) && password_verify($mdp, $user->motdepasse)) {
            unset($user->motdepasse);
            $_SESSION['utilisateur'] = $user;

            // fusion panier DB -> session si méthodes disponibles
            if (method_exists($this->modeleFront, 'getPanierUtilisateur')) {
                $dbPanier = $this->modeleFront->getPanierUtilisateur($user->id) ?: [];
                if (!isset($_SESSION['produits']) || !is_array($_SESSION['produits'])) $_SESSION['produits'] = [];
                foreach ($dbPanier as $pid => $q) {
                    $pid = (string)$pid; $q = max(0, (int)$q);
                    if ($q <= 0) continue;
                    $_SESSION['produits'][$pid] = (isset($_SESSION['produits'][$pid]) ? (int)$_SESSION['produits'][$pid] : 0) + $q;
                }
                if (method_exists($this->modeleFront, 'sauvegarderPanierUtilisateur')) {
                    $this->modeleFront->sauvegarderPanierUtilisateur($user->id, $_SESSION['produits']);
                }
                $_SESSION['panier_fusionne'] = true;
            }

            header('Location: index.php');
            exit;
        }

        $msgErreurs[] = 'Login ou mot de passe incorrect.';
        include __DIR__ . '/../vues/v_connexion.php';
    }

    public function afficherInscription() {
        include __DIR__ . '/../vues/v_inscription.php';
    }

    public function creerCompte() {
        $login = trim($_POST['login'] ?? '');
        $mdp = $_POST['mdp'] ?? '';
        $mdp2 = $_POST['mdp2'] ?? '';
        $nom  = trim($_POST['nom'] ?? '');
        $mail = trim($_POST['mail'] ?? '');
        $msgErreurs = [];

        if ($login === '' || $mdp === '' || $mdp2 === '') $msgErreurs[] = 'Tous les champs obligatoires.';
        if ($mdp !== $mdp2) $msgErreurs[] = 'Les mots de passe ne correspondent pas.';
        if ($this->modeleFront->getUserByLogin($login)) $msgErreurs[] = 'Login déjà utilisé.';

        if (!empty($msgErreurs)) {
            include __DIR__ . '/../vues/v_inscription.php';
            return;
        }

        $hash = password_hash($mdp, PASSWORD_DEFAULT);
        $this->modeleFront->creerUtilisateur($login, $hash, $nom, $mail);

        // auto-login après inscription
        $user = $this->modeleFront->getUserByLogin($login);
        if ($user) {
            unset($user->motdepasse);
            $_SESSION['utilisateur'] = $user;
            if (method_exists($this->modeleFront, 'sauvegarderPanierUtilisateur') && isset($_SESSION['produits']) && is_array($_SESSION['produits'])) {
                $this->modeleFront->sauvegarderPanierUtilisateur($user->id, $_SESSION['produits']);
            }
            $_SESSION['panier_fusionne'] = true;
        }

        header('Location: index.php');
        exit;
    }

    public function deconnecter() {
        if (!empty($_SESSION['utilisateur']->id) && isset($_SESSION['produits']) && is_array($_SESSION['produits'])) {
            if (method_exists($this->modeleFront, 'sauvegarderPanierUtilisateur')) {
                $this->modeleFront->sauvegarderPanierUtilisateur($_SESSION['utilisateur']->id, $_SESSION['produits']);
            }
        }
        unset($_SESSION['utilisateur']);
        $_SESSION['produits'] = [];
        unset($_SESSION['panier_fusionne']);
        header('Location: index.php');
        exit;
    }
}
?>