<?php
/** @file ControleurAccueil.php
 * @author Marielle Jouin <jouin.marielle@gmail.com>
 * @version    3.0
 * @details Gère l'affichage de la page d'accueil du site
*/
require_once __DIR__ . '/../modele/ModeleFront.php';
/**
 * @class ControleurAccueil
 * @brief contient la fonction qui gère l'accueil
 */
class ControleurAccueil{
    private $modele;

    public function __construct()
    {
        $this->modele = new ModeleFront();
    }
    /**
	 * affiche la page d'accueil
	*/
    public function accueil(){
        // Nettoyer les promotions expirées
        $this->modele->nettoyerPromotionsExpirees();
        
        // Récupérer les produits mis en avant
        $produitsMisEnAvant = $this->modele->getProduitsMisEnAvant();
        
        include("vues/v_accueil.php");
    }

    /**
     * affiche la page des mentions légales
     */
    public function mentionsLegales(){
        include("vues/v_mentionsLegales.php");
    }
}
