<?php
/** 
 * Mission : architecture MVC GsbParam

 * @file ModeleFront.php
 * @author Marielle Jouin <jouin.marielle@gmail.com>
 * @version    3.0
 * @details contient les fonctions d'accès BD pour le FrontEnd
 */
require_once __DIR__ . '/Modele.php';
/**
 * @class ModeleFront
 * @brief contient les fonctions d'accès aux infos de la BD pour les utilisateurs
 */
class ModeleFront extends Modele
{
	/**
	 * Retourne toutes les catégories 
	 *
	 * @return array $lesLignes le tableau des catégories (tableau d'objets)
	 */
	public function getLesCategories()
	{
		try {
			$req = 'select id, libelle from categorie';
			$res = $this->executerRequete($req);
			$lesLignes = $res->fetchAll(PDO::FETCH_OBJ);
			return $lesLignes;
		} catch (PDOException $e) {
			print "Erreur !: " . $e->getMessage();
			die();
		}
	}
	/**
	 * Retourne toutes les informations d'une catégorie passée en paramètre
	 *
	 * @param string $idCategorie l'id de la catégorie
	 * @return object $laLigne la catégorie (objet)
	 */
	public function getLesInfosCategorie($idCategorie)
	{
		try {
			$req = 'SELECT id, libelle FROM categorie WHERE id="' . $idCategorie . '"';
			$res = $this->executerRequete($req);
			$laLigne = $res->fetch(PDO::FETCH_OBJ);
			return $laLigne;
		} catch (PDOException $e) {
			print "Erreur !: " . $e->getMessage();
			die();
		}
	}
	/**
	 * Retourne sous forme d'un tableau tous les produits de la
	 * catégorie passée en argument
	 * 
	 * @param string $idCategorie  l'id de la catégorie dont on veut les produits
	 * @return array $lesLignes un tableau des produits de la categ passée en paramètre (tableau d'objets)
	 */

	public function getLesProduitsDeCategorie($idCategorie)
	{
		try {
			$req = 'select id, description, prix, image, idCategorie from produit where idCategorie ="' . $idCategorie . '"';
			$res = $this->executerRequete($req);
			$lesLignes = $res->fetchAll(PDO::FETCH_OBJ);
			return $lesLignes;
		} catch (PDOException $e) {
			print "Erreur !: " . $e->getMessage();
			die();
		}
	}
	/**
	 * Retourne les produits concernés par le tableau des idProduits passé en argument (si null retourne tous les produits)
	 *
	 * @param array $desIdsProduit tableau d'idProduits
	 * @return array $lesProduits un tableau contenant les infos des produits dont les id ont été passé en paramètre
	 */
	public function getLesProduitsDuTableau($desIdsProduit = null)
	{
		try {
			$lesProduits = array();
			if ($desIdsProduit != null) {
				foreach ($desIdsProduit as $unIdProduit) {
					$req = 'select id, description, prix, image, idCategorie from produit where id = "' . $unIdProduit . '"';
					$res = $this->executerRequete($req);
					$unProduit = $res->fetch(PDO::FETCH_OBJ);
					$lesProduits[] = $unProduit;
				}
			} else // on souhaite tous les produits
			{
				$req = 'select id, description, prix, image, idCategorie from produit;';
				$res = $this->executerRequete($req);
				$lesProduits = $res->fetchAll(PDO::FETCH_OBJ);
			}
			return $lesProduits;
		} catch (PDOException $e) {
			print "Erreur !: " . $e->getMessage();
			die();
		}
	}
	/**
	 * Crée une commande 
	 *
	 * Crée une commande à partir des arguments validés passés en paramètre, l'identifiant est
	 * construit à partir du maximum existant ; crée les lignes de commandes dans la table contenir à partir du
	 * tableau d'idProduit passé en paramètre
	 * @param string $nom nom du client
	 * @param string $rue rue du client
	 * @param string $cp cp du client
	 * @param string $ville ville du client
	 * @param string $mail mail du client
	 * @param array $lesIdProduit tableau contenant les id des produits commandés

	*/
	public function creerCommande($nom, $rue, $cp, $ville, $mail, $lesIdProduit)
	{
		try {
			// on récupère le dernier id de commande
			$req = 'select max(id) as maxi from commande';
			$res = $this->executerRequete($req);
			$laLigne = $res->fetch();
			$maxi = $laLigne['maxi'];// on place le dernier id de commande dans $maxi
			$idCommande = $maxi + 1; // on augmente le dernier id de commande de 1 pour avoir le nouvel idCommande
			$date = date('Y/m/d'); // récupération de la date système
			$req = "insert into commande values ('$idCommande','$date','$nom','$rue','$cp','$ville','$mail')";
			$res = $this->executerRequete($req);
			// insertion produits commandés (on dédoublonne pour éviter l'erreur de clé primaire)
			$lesIdProduitUniques = array_unique($lesIdProduit);
			foreach ($lesIdProduitUniques as $unIdProduit) {
				$req = "insert into contenir values ('$idCommande','$unIdProduit')";
				$res = $this->executerRequete($req);
			}
		} catch (PDOException $e) {
			print "Erreur !: " . $e->getMessage();
			die();
		}
	}
	/**
	 * Récupère un utilisateur par login
	 */
	public function getUserByLogin($login)
	{
		try {
			$req = 'SELECT id, login, motdepasse, nom, mail FROM utilisateur WHERE login = :login';
			$stmt = $this->getBdd()->prepare($req);
			$stmt->bindParam(':login', $login, PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			print "Erreur !: " . $e->getMessage();
			die();
		}
	}

	/**
	 * Crée un utilisateur (login unique)
	 */
	public function creerUtilisateur($login, $hashMdp, $nom, $prenom, $rue, $cp, $ville, $mail)
	{
		try {
			$req = 'INSERT INTO utilisateur (login, motdepasse, nom, prenom, rue, cp, ville, mail) VALUES (:login, :mdp, :nom, :prenom, :rue, :cp, :ville, :mail)';
			$stmt = $this->getBdd()->prepare($req);
			$stmt->bindParam(':login', $login, PDO::PARAM_STR);
			$stmt->bindParam(':mdp', $hashMdp, PDO::PARAM_STR);
			$stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
			$stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
			$stmt->bindParam(':rue', $rue, PDO::PARAM_STR);
			$stmt->bindParam(':cp', $cp, PDO::PARAM_STR);
			$stmt->bindParam(':ville', $ville, PDO::PARAM_STR);
			$stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			print "Erreur !: " . $e->getMessage();
			die();
		}
	}

	/**
	 * Vérifie les identifiants, retourne l'utilisateur (objet) ou false
	 */
	public function verifierUtilisateur($login, $motdepasse)
	{
		$user = $this->getUserByLogin($login);
		if ($user && isset($user->motdepasse) && password_verify($motdepasse, $user->motdepasse)) {
			// ne renvoyer que les infos utiles (éviter le mot de passe)
			unset($user->motdepasse);
			return $user;
		}
		return false;
	}
	/**
	 * Récupère le panier (tableau associatif idProduit => quantite) pour un utilisateur
	 */
	public function getPanierUtilisateur($idUser)
	{
		try {
			$req = 'SELECT panier FROM utilisateur WHERE id = :id';
			$stmt = $this->getBdd()->prepare($req);
			$stmt->bindParam(':id', $idUser, PDO::PARAM_INT);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if (!$row || empty($row['panier']))
				return [];
			$data = json_decode($row['panier'], true);
			return is_array($data) ? $data : [];
		} catch (PDOException $e) {
			// gérer/logguer l'erreur correctement en prod
			return [];
		}
	}

	/**
	 * Sauvegarde le panier (assoc id=>quantité) pour un utilisateur
	 */
	public function sauvegarderPanierUtilisateur($idUser, array $panierAssoc)
	{
		try {
			$json = json_encode($panierAssoc);
			$req = 'UPDATE utilisateur SET panier = :panier WHERE id = :id';
			$stmt = $this->getBdd()->prepare($req);
			$stmt->bindParam(':panier', $json, PDO::PARAM_STR);
			$stmt->bindParam(':id', $idUser, PDO::PARAM_INT);
			return $stmt->execute();
		} catch (PDOException $e) {
			// gérer/logguer l'erreur correctement en prod
			return false;
		}
	}
}
?>