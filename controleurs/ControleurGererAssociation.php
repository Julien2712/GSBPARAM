<?php
require_once __DIR__ . '/../modele/ModeleFront.php';

class ControleurGererAssociation
{
    private $modeleFront;
    public function __construct()
    {
        $this->modeleFront = new ModeleFront();
    }

    public function gererAssociation()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : 'afficher';

        switch ($action) {
            case 'afficher':
                $lesAssociations = $this->modeleFront->getLesAssociations();
                $lesProduits = $this->modeleFront->getLesProduitsDuTableau();
                include("vues/v_gererAssociation.php");
                break;

            case 'ajouter':
                $prodId = isset($_POST['prodId']) ? $_POST['prodId'] : '';
                $prodIdAssocie = isset($_POST['prodIdAssocie']) ? $_POST['prodIdAssocie'] : '';
                if (!empty($prodId) && !empty($prodIdAssocie) && $prodId !== $prodIdAssocie) {
                    $this->modeleFront->ajouterAssociation($prodId, $prodIdAssocie);
                }
                header("Location: index.php?uc=gererAssociation&action=afficher");
                break;

            case 'supprimer':
                $prodId = isset($_GET['prodId']) ? $_GET['prodId'] : '';
                $prodIdAssocie = isset($_GET['prodIdAssocie']) ? $_GET['prodIdAssocie'] : '';
                if (!empty($prodId) && !empty($prodIdAssocie)) {
                    $this->modeleFront->supprimerAssociation($prodId, $prodIdAssocie);
                }
                header("Location: index.php?uc=gererAssociation&action=afficher");
                break;
        }
    }
}

?>
