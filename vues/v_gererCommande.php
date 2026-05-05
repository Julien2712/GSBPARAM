<div class="alert alert-light" role="alert" id="categorie">Gérer les commandes :</div>

<div class="card card-body col-10 m-auto mb-4">
    <?php if (empty($lesCommandes)): ?>
        <p class="text-center mb-0">Aucune commande trouvée.</p>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($lesCommandes as $uneCommande): ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Commande N°<?= htmlspecialchars($uneCommande->id ?? '', ENT_QUOTES, 'UTF-8') ?></strong>
                        <br>
                        <small class="text-muted">
                            Date : <?= htmlspecialchars($uneCommande->date ?? '', ENT_QUOTES, 'UTF-8') ?> | 
                            Utilisateur ID : <?= htmlspecialchars($uneCommande->utilisateurId ?? 'Inconnu', ENT_QUOTES, 'UTF-8') ?>
                        </small>
                    </div>
                    <div>
                        <span class="badge bg-<?= ($uneCommande->etat ?? '') === 'validée' ? 'success' : 'secondary' ?> me-2">
                            <?= htmlspecialchars(ucfirst($uneCommande->etat ?? 'Inconnu'), ENT_QUOTES, 'UTF-8') ?>
                        </span>
                        <a href="index.php?uc=gererCommande&action=afficherDetails&id=<?= htmlspecialchars($uneCommande->id, ENT_QUOTES, 'UTF-8') ?>" class="btn btn-sm btn-primary">Détails</a>
                        <a href="index.php?uc=gererCommande&action=supprimer&id=<?= htmlspecialchars($uneCommande->id, ENT_QUOTES, 'UTF-8') ?>" class="btn btn-sm btn-danger ms-1" onclick="return confirm('Voulez-vous vraiment supprimer cette commande ? Cette action est irréversible.');">Supprimer</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>