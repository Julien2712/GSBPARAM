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
			$req = 'select prodId as id, prodDescription as description, prodPrix as prix, prodImage as image, idCategorie from produit where idCategorie ="' . $idCategorie . '"';
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
					$req = 'select prodId as id, prodDescription as description, prodPrix as prix, prodImage as image, idCategorie from produit where prodId = "' . $unIdProduit . '"';
					$res = $this->executerRequete($req);
					$unProduit = $res->fetch(PDO::FETCH_OBJ);
					$lesProduits[] = $unProduit;
				}
			} else // on souhaite tous les produits
			{
				$req = 'select prodId as id, prodDescription as description, prodPrix as prix, prodImage as image, idCategorie from produit;';
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
	 * Retourne les produits qui n'ont actuellement aucune catégorie
	 *
	 * @return array un tableau des produits sans catégorie
	 */
	public function getLesProduitsSansCategorie()
	{
		try {
			$req = "select prodId as id, prodDescription as description, prodPrix as prix, prodImage as image, idCategorie from produit where idCategorie IS NULL OR idCategorie = ''";
			$res = $this->executerRequete($req);
			return $res->fetchAll(PDO::FETCH_OBJ);
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
			$this->getBdd()->beginTransaction();

			// 1. Get next panierID
			$reqId = 'SELECT IFNULL(MAX(panierID), 0) + 1 as nextId FROM panier_commande';
			$resId = $this->getBdd()->query($reqId);
			$panierID = $resId->fetch()['nextId'];

			$date = date('Y-m-d');
			$utiId = null;
			if (isset($_SESSION['utilisateur']->id)) {
				$utiId = $_SESSION['utilisateur']->id;
			}

			// 2. Insert into panier_commande
			$reqPC = "INSERT INTO panier_commande (panierID, panierDate, dateCommande, etatCommande, utiId) 
					  VALUES (:id, :pdate, :cdate, 'validée', :utiId)";
			$stmtPC = $this->getBdd()->prepare($reqPC);
			$stmtPC->execute([
				':id' => $panierID,
				':pdate' => $date,
				':cdate' => $date,
				':utiId' => $utiId
			]);

			// 3. Insert into lignecommande (with deduplication and quantity count)
			$counts = array_count_values($lesIdProduit);
			
			$reqL = "INSERT INTO lignecommande (ligneID, ligneQuantite, prodId, panierID) 
					 VALUES (:lid, :qte, :pid, :panId)";
			$stmtL = $this->getBdd()->prepare($reqL);

			foreach ($counts as $pid => $qte) {
				// Get next ligneID
				$reqIdL = 'SELECT IFNULL(MAX(ligneID), 0) + 1 as nextId FROM lignecommande';
				$resIdL = $this->getBdd()->query($reqIdL);
				$ligneID = $resIdL->fetch()['nextId'];

				$stmtL->execute([
					':lid' => $ligneID,
					':qte' => $qte,
					':pid' => $pid,
					':panId' => $panierID
				]);
			}

			$this->getBdd()->commit();
		} catch (PDOException $e) {
			$this->getBdd()->rollBack();
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
			$req = 'SELECT utiId as id, utiLogin as login, conMdp as motdepasse, utiNom as nom, utiMail as mail FROM utilisateur JOIN connexion ON utilisateur.conId = connexion.conId WHERE utiLogin = :login';
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
			$this->getBdd()->beginTransaction();

			// 1. Get next conId
			$reqIdCon = 'SELECT IFNULL(MAX(conId), 0) + 1 as nextId FROM connexion';
			$resIdCon = $this->getBdd()->query($reqIdCon);
			$conId = $resIdCon->fetch()['nextId'];

			// 2. Insert into connexion
			$reqCon = 'INSERT INTO connexion (conId, conMdp) VALUES (:conId, :mdp)';
			$stmtCon = $this->getBdd()->prepare($reqCon);
			$stmtCon->bindParam(':conId', $conId, PDO::PARAM_INT);
			$stmtCon->bindParam(':mdp', $hashMdp, PDO::PARAM_STR);
			$stmtCon->execute();

			// 3. Get next utiId
			$reqIdUti = 'SELECT IFNULL(MAX(utiId), 0) + 1 as nextId FROM utilisateur';
			$resIdUti = $this->getBdd()->query($reqIdUti);
			$utiId = $resIdUti->fetch()['nextId'];

			// 4. Insert into utilisateur (habId = 1 for Client)
			$completNom = $nom . ' ' . $prenom;
			$reqUti = 'INSERT INTO utilisateur (utiId, utiLogin, utiNom, utiMail, utiCp, utiVille, utiAdresse, habId, conId) 
					   VALUES (:utiId, :login, :nom, :mail, :cp, :ville, :adresse, 1, :conId)';
			$stmtUti = $this->getBdd()->prepare($reqUti);
			$stmtUti->bindParam(':utiId', $utiId, PDO::PARAM_INT);
			$stmtUti->bindParam(':login', $login, PDO::PARAM_STR);
			$stmtUti->bindParam(':nom', $completNom, PDO::PARAM_STR);
			$stmtUti->bindParam(':mail', $mail, PDO::PARAM_STR);
			$stmtUti->bindParam(':cp', $cp, PDO::PARAM_STR);
			$stmtUti->bindParam(':ville', $ville, PDO::PARAM_STR);
			$stmtUti->bindParam(':adresse', $rue, PDO::PARAM_STR);
			$stmtUti->bindParam(':conId', $conId, PDO::PARAM_INT);
			$stmtUti->execute();

			$this->getBdd()->commit();
			return true;
		} catch (PDOException $e) {
			$this->getBdd()->rollBack();
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
			$req = "SELECT prodId, ligneQuantite 
					FROM panier_commande 
					JOIN lignecommande ON panier_commande.panierID = lignecommande.panierID 
					WHERE utiId = :id AND etatCommande = 'en_cours'";
			$stmt = $this->getBdd()->prepare($req);
			$stmt->bindParam(':id', $idUser, PDO::PARAM_INT);
			$stmt->execute();
			
			$panier = [];
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$panier[$row['prodId']] = $row['ligneQuantite'];
			}
			return $panier;
		} catch (PDOException $e) {
			return [];
		}
	}

	/**
	 * Sauvegarde le panier (assoc id=>quantité) pour un utilisateur
	 */
	public function sauvegarderPanierUtilisateur($idUser, array $panierAssoc)
	{
		try {
			$this->getBdd()->beginTransaction();

			// 1. Find or create 'en_cours' panier
			$req = "SELECT panierID FROM panier_commande WHERE utiId = :id AND etatCommande = 'en_cours'";
			$stmt = $this->getBdd()->prepare($req);
			$stmt->execute([':id' => $idUser]);
			$panier = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($panier) {
				$panierID = $panier['panierID'];
				// Delete old lines
				$reqDel = "DELETE FROM lignecommande WHERE panierID = :id";
				$stmtDel = $this->getBdd()->prepare($reqDel);
				$stmtDel->execute([':id' => $panierID]);
			} else {
				// Create new panier
				$reqId = 'SELECT IFNULL(MAX(panierID), 0) + 1 as nextId FROM panier_commande';
				$resId = $this->getBdd()->query($reqId);
				$panierID = $resId->fetch()['nextId'];

				$date = date('Y-m-d');
				$reqIns = "INSERT INTO panier_commande (panierID, panierDate, dateCommande, etatCommande, utiId) 
						   VALUES (:id, :date, :date, 'en_cours', :utiId)";
				$stmtIns = $this->getBdd()->prepare($reqIns);
				$stmtIns->execute([':id' => $panierID, ':date' => $date, ':utiId' => $idUser]);
			}

			// 2. Insert new lines
			$reqL = "INSERT INTO lignecommande (ligneID, ligneQuantite, prodId, panierID) VALUES (:lid, :qte, :pid, :panId)";
			$stmtL = $this->getBdd()->prepare($reqL);

			foreach ($panierAssoc as $pid => $qte) {
				if ($qte <= 0) continue;
				// Get next ligneID
				$reqIdL = 'SELECT IFNULL(MAX(ligneID), 0) + 1 as nextId FROM lignecommande';
				$resIdL = $this->getBdd()->query($reqIdL);
				$ligneID = $resIdL->fetch()['nextId'];

				$stmtL->execute([
					':lid' => $ligneID,
					':qte' => $qte,
					':pid' => $pid,
					':panId' => $panierID
				]);
			}

			$this->getBdd()->commit();
			return true;
		} catch (PDOException $e) {
			$this->getBdd()->rollBack();
			return false;
		}
	}

	public function creerCategorie($libelle)
	{
		try {
			$req = 'INSERT INTO categorie (libelle) VALUES (:libelle)';
			$stmt = $this->getBdd()->prepare($req);
			$stmt->bindParam(':libelle', $libelle, PDO::PARAM_STR);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			print "Erreur !: " . $e->getMessage();
			die();
		}
	}

	public function modifierCategorie($ancienIdCategorie, $nouvelIdCategorie, $libelle)
	{
		try {
			$this->getBdd()->exec('SET FOREIGN_KEY_CHECKS=0;');

			$req = 'UPDATE categorie SET id = :nouvelId, libelle = :libelle WHERE id = :ancienId';
			$stmt = $this->getBdd()->prepare($req);
			$stmt->bindParam(':nouvelId', $nouvelIdCategorie, PDO::PARAM_STR);
			$stmt->bindParam(':libelle', $libelle, PDO::PARAM_STR);
			$stmt->bindParam(':ancienId', $ancienIdCategorie, PDO::PARAM_STR);
			$stmt->execute();

			if ($ancienIdCategorie !== $nouvelIdCategorie) {
				$reqProd = 'UPDATE produit SET idCategorie = :nouvelId WHERE idCategorie = :ancienId';
				$stmtProd = $this->getBdd()->prepare($reqProd);
				$stmtProd->bindParam(':nouvelId', $nouvelIdCategorie, PDO::PARAM_STR);
				$stmtProd->bindParam(':ancienId', $ancienIdCategorie, PDO::PARAM_STR);
				$stmtProd->execute();
			}

			$this->getBdd()->exec('SET FOREIGN_KEY_CHECKS=1;');
			return true;
		} catch (PDOException $e) {
			$this->getBdd()->exec('SET FOREIGN_KEY_CHECKS=1;');
			print "Erreur !: " . $e->getMessage();
			die();
		}
	}

	public function supprimerCategorie($idCategorie)
	{
		try {
			$reqCheck = 'SELECT count(*) as nb FROM produit WHERE idCategorie = :id';
			$stmtCheck = $this->getBdd()->prepare($reqCheck);
			$stmtCheck->bindParam(':id', $idCategorie, PDO::PARAM_STR);
			$stmtCheck->execute();
			$resultat = $stmtCheck->fetch();

			if ($resultat['nb'] > 0) {
				return false;
			}

			$req = 'DELETE FROM categorie WHERE id = :id';
			$stmt = $this->getBdd()->prepare($req);
			$stmt->bindParam(':id', $idCategorie, PDO::PARAM_STR);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}
	public function changerCategorieProduit($idProduit, $nouvelleCategorie)
	{
		try {
			$req = 'UPDATE produit SET idCategorie = :idCategorie WHERE prodId = :id';
			$stmt = $this->getBdd()->prepare($req);
			$stmt->bindParam(':idCategorie', $nouvelleCategorie, PDO::PARAM_STR);
			$stmt->bindParam(':id', $idProduit, PDO::PARAM_STR);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}

}
?>