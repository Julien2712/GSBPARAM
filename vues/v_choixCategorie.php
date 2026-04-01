<div id="choixC" style="border: 1px solid #ddd; padding: 15px; border-radius: 5px; width: 250px; background-color: #fff; text-align: center; margin-right: 20px;">
    <h3>Filtre</h3>
    <hr>
    <form action="index.php" method="GET">
        <input type="hidden" name="uc" value="voirProduits">
        <input type="hidden" name="action" value="filtrer">
        <!-- Sauvegarde du contexte (tous vs categorie) -->
        <input type="hidden" name="context" value="<?= isset($pageContext) ? htmlspecialchars($pageContext) : 'tous' ?>">

        <?php if (!isset($pageContext) || $pageContext === 'tous'): ?>
        <div style="margin-bottom: 15px;">
            <label style="display:block; margin-bottom: 5px;">Prix</label>
            <div style="display: flex; justify-content: space-between;">
                <div style="width: 45%;">
                    <label style="font-size: 0.8em; color: #666;">Minimum</label>
                    <div style="display: flex; align-items: center; border: 1px solid #ccc; border-radius: 3px;">
                        <input type="number" name="prixMin" placeholder="Min" style="width: 100%; border: none; padding: 5px;" value="<?= isset($_REQUEST['prixMin']) ? htmlspecialchars($_REQUEST['prixMin']) : '' ?>">
                        <span style="padding: 0 5px; background: #eee;">€</span>
                    </div>
                </div>
                <div style="width: 45%;">
                    <label style="font-size: 0.8em; color: #666;">Maximum</label>
                    <div style="display: flex; align-items: center; border: 1px solid #ccc; border-radius: 3px;">
                        <input type="number" name="prixMax" placeholder="Max" style="width: 100%; border: none; padding: 5px;" value="<?= isset($_REQUEST['prixMax']) ? htmlspecialchars($_REQUEST['prixMax']) : '' ?>">
                        <span style="padding: 0 5px; background: #eee;">€</span>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display:block; margin-bottom: 5px;">Marque</label>
            <select name="marque" style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;">
                <option value="">- Choisissez une marque -</option>
                <?php
                if (isset($lesMarques) && is_array($lesMarques)) {
                    foreach ($lesMarques as $uneMarque) {
                        $selected = (isset($_REQUEST['marque']) && $_REQUEST['marque'] == $uneMarque->id) ? 'selected' : '';
                        echo '<option value="' . $uneMarque->id . '" ' . $selected . '>' . htmlspecialchars($uneMarque->libelle) . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <?php endif; ?>

        <?php if (isset($pageContext) && $pageContext === 'categorie'): ?>
        <div style="margin-bottom: 15px;">
            <label style="display:block; margin-bottom: 5px;">Catégories</label>
            <select name="categorie" style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;">
                <option value="">- Choisissez une catégorie -</option>
                <?php
                if (isset($lesCategories) && is_array($lesCategories)) {
                    foreach ($lesCategories as $uneCategorie) {
                        // $categ est défini dans le controleur
                        $selected = (isset($_REQUEST['categorie']) && $_REQUEST['categorie'] == $uneCategorie->id) || (isset($categ) && $categ == $uneCategorie->id) ? 'selected' : '';
                        echo '<option value="' . $uneCategorie->id . '" ' . $selected . '>' . htmlspecialchars($uneCategorie->libelle) . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <?php else: ?>
            <!-- Si on est dans "Tous les produits", on s'assure que la catégorie n'est pas envoyée par accident ou on envoie la catégorie vide -->
            <input type="hidden" name="categorie" value="">
        <?php endif; ?>

        <button type="submit" style="background-color: #156c40; color: white; border: none; padding: 8px 15px; width: 100%; border-radius: 3px; cursor: pointer; margin-bottom: 10px;">Filtrer</button>
        <?php 
            $resetLink = (isset($pageContext) && $pageContext === 'categorie') 
                ? "index.php?uc=voirProduits&action=voirProduits&categorie=". (isset($categ) ? $categ : '') 
                : "index.php?uc=voirProduits&action=nosProduits";
        ?>
        <a href="<?= $resetLink ?>" style="display: block; width: 100%; text-decoration: none; padding: 8px 0; background-color: #f8f9fa; color: #333; border: 1px solid #ccc; border-radius: 3px; cursor: pointer; text-align: center; box-sizing: border-box;">Réinitialiser</a>
    </form>
</div>