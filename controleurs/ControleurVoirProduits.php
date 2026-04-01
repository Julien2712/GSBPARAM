<?php
/**
 * @file ControleurVoirProduits.php
 * @author Marielle Jouin <jouin.marielle@gmail.com>
 * @version    3.0
 * @details contient les fonctions pour voir les produits

 * regroupe les fonctions pour voir les produits
 */
/**
 * @class ControleurVoirProduits
 * @brief contient les fonctions pour gérer l'affichage des produits
 */
class ControleurVoirProduits{
    private $modeleFront;

    public function __construct()
    {
        $this->modeleFront=new ModeleFront();
    }
	/**
	 * Affiche les produits
	 *
	 * si $categ contient un idCategorie affiche les produits d'une catégorie
	 * @param $categ un identifiant de la catégorie de produits à afficher
	*/
    public function voirProduits($categ){
        if ($categ == null) {
            $categ = 'CH';
        }
        $lesProduits = $this->modeleFront->getLesProduitsDeCategorie($categ);
        $lesCategories = $this->modeleFront->getLesCategories();
        $lesMarques = $this->modeleFront->getLesMarques();
        $infosCategorie = $this->modeleFront->getLesInfosCategorie($categ);

        $titreCategorie = "Produits de la catégorie : " . strtolower($infosCategorie->libelle);
        
        $pageContext = 'categorie';

        include("vues/v_choixCategorie.php");
        include("vues/v_produits.php");
    }

    public function voirTousLesProduits() {
        $lesProduits = $this->modeleFront->getLesProduitsDuTableau();
        $lesCategories = $this->modeleFront->getLesCategories();
        $lesMarques = $this->modeleFront->getLesMarques();
        $titreCategorie = "Tous les produits : ";
        $categ = null;
        
        $pageContext = 'tous';
        
        include("vues/v_choixCategorie.php");
        include("vues/v_produits.php");
    }

    public function filtrer() {
        $categorie = isset($_REQUEST['categorie']) && $_REQUEST['categorie'] !== '' ? $_REQUEST['categorie'] : null;
        $prixMin = isset($_REQUEST['prixMin']) && $_REQUEST['prixMin'] !== '' ? $_REQUEST['prixMin'] : null;
        $prixMax = isset($_REQUEST['prixMax']) && $_REQUEST['prixMax'] !== '' ? $_REQUEST['prixMax'] : null;
        $marqueId = isset($_REQUEST['marque']) && $_REQUEST['marque'] !== '' ? $_REQUEST['marque'] : null;
        
        $pageContext = isset($_REQUEST['context']) ? $_REQUEST['context'] : 'tous';

        $lesCategories = $this->modeleFront->getLesCategories();
        $lesMarques = $this->modeleFront->getLesMarques();
        
        $erreurFiltre = null;
        $lesProduits = [];
        try {
            $lesProduits = $this->modeleFront->getLesProduitsFiltres($categorie, $prixMin, $prixMax, $marqueId);
        } catch (Exception $e) {
            $erreurFiltre = $e->getMessage();
        }
        
        $titreCategorie = "Produits filtrés : ";
        
        // On conserve la sélection pour la vue
        $categ = $categorie;
        
        include("vues/v_choixCategorie.php");
        include("vues/v_produits.php");
    }

	/**
	 * Affiche le menu à gauche contenant les catégories
	*/
    public function voirCategories(){
		$lesCategories=$this->modeleFront->getLesCategories();
		$pageContext = 'categorie';
        include("vues/v_choixCategorie.php");
	}
}

?>

