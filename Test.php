<?php
require_once 'modele/Modele.php';
require_once 'modele/ModeleFront.php';

$modeleFront = new ModeleFront();

var_dump($modeleFront->getLesCategories());


var_dump($modeleFront->getLesProduitsDeCategorie("CH"));
?>