<div class="alert alert-light" role="alert" id="categorie">
    <a href="index.php?uc=gererCommande&action=afficher" class="btn btn-sm btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
    Détails de la Commande N°<?= htmlspecialchars($idCommande, ENT_QUOTES, 'UTF-8') ?>
</div>

<div class="col-10 m-auto mb-4">
    <?php if (isset($_GET['succes']) && $_GET['succes'] === 'etat'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Succès !</strong> L'état de la commande a été mis à jour avec succès.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($infosCommande) && $infosCommande): ?>
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0 bg-light">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="bi bi-info-circle"></i> Informations de la commande</h5>
                    <p class="mb-2"><strong>Date :</strong> <?= htmlspecialchars($infosCommande->dateCommande ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                    <form action="index.php?uc=gererCommande&action=changerEtat" method="POST" class="d-flex align-items-center">
                        <input type="hidden" name="idCommande" value="<?= htmlspecialchars($idCommande, ENT_QUOTES, 'UTF-8') ?>">
                        <strong class="me-2">État :</strong>
                        <select name="etat" class="form-select form-select-sm w-auto d-inline-block me-2">
                            <?php 
                            $etats = ['validée', 'expédiée', 'livrée', 'annulée'];
                            $etatActuel = strtolower($infosCommande->etat ?? '');
                            foreach ($etats as $e) {
                                $selected = ($e === $etatActuel) ? 'selected' : '';
                                echo "<option value=\"$e\" $selected>" . ucfirst($e) . "</option>";
                            }
                            ?>
                        </select>
                        <button type="submit" class="btn btn-sm btn-outline-primary">Mettre à jour</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0 bg-light">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="bi bi-person-lines-fill"></i> Coordonnées Client</h5>
                    <?php if ($infosCommande->nom): ?>
                        <p class="mb-1"><strong>Nom :</strong> <?= htmlspecialchars($infosCommande->nom, ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="mb-1"><strong>Email :</strong> <?= htmlspecialchars($infosCommande->mail, ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="mb-1"><strong>Adresse :</strong> <?= htmlspecialchars(($infosCommande->adresse ?? '') . ' ' . ($infosCommande->cp ?? '') . ' ' . ($infosCommande->ville ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
                    <?php else: ?>
                        <p class="text-muted fst-italic">Aucune coordonnée (Client invité ou supprimé)</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="card card-body shadow-sm">
    <?php if (empty($lesDetails)): ?>
        <p class="text-center mb-0">Aucun détail trouvé pour cette commande.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID Produit</th>
                        <th>Description</th>
                        <th class="text-center">Quantité</th>
                        <th class="text-end">Prix Unitaire</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $totalCommande = 0;
                    foreach ($lesDetails as $unDetail): 
                        $totalLigne = $unDetail->prix * $unDetail->quantite;
                        $totalCommande += $totalLigne;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($unDetail->id, ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($unDetail->description, ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="text-center"><?= htmlspecialchars($unDetail->quantite, ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="text-end"><?= number_format($unDetail->prix, 2, ',', ' ') ?> €</td>
                            <td class="text-end fw-bold"><?= number_format($totalLigne, 2, ',', ' ') ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="4" class="text-end fw-bold">Total de la commande :</td>
                        <td class="text-end fw-bold text-primary fs-5"><?= number_format($totalCommande, 2, ',', ' ') ?> €</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php endif; ?>
</div>
