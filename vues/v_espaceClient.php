<?php
// Vue pour l'espace client
$onglet = $_GET['onglet'] ?? 'infos';
$user = $_SESSION['utilisateur'] ?? null;

if ($user) {
    $parts = explode(' ', $user->nom, 2);
    $nomDefaut = $parts[0] ?? '';
    $prenomDefaut = $parts[1] ?? '';
}
?>
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2>Espace Client</h2>
        </div>
    </div>

    <?php if (!empty($msgErreurs)): ?>
        <div class="alert alert-danger text-center w-75 mx-auto">
            <?= htmlspecialchars($msgErreurs[0]) ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($msgSucces)): ?>
        <div class="alert alert-success text-center w-75 mx-auto">
            <?= htmlspecialchars($msgSucces) ?>
        </div>
    <?php endif; ?>

    <!-- Navigation par onglets -->
    <ul class="nav nav-tabs justify-content-center mb-4">
        <li class="nav-item">
            <a class="nav-link <?= $onglet === 'infos' ? 'active text-success fw-bold' : 'text-muted' ?>" href="index.php?uc=utilisateur&action=espaceClient&onglet=infos">Mes informations</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $onglet === 'commandes' ? 'active text-success fw-bold' : 'text-muted' ?>" href="index.php?uc=utilisateur&action=espaceClient&onglet=commandes">Mes commandes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $onglet === 'avis' ? 'active text-success fw-bold' : 'text-muted' ?>" href="index.php?uc=utilisateur&action=espaceClient&onglet=avis">Mes avis</a>
        </li>
    </ul>

    <!-- Contenu -->
    <div class="row w-75 mx-auto">
        <div class="col-12">
            
            <?php if ($onglet === 'infos' && $user): ?>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form method="POST" action="index.php?uc=utilisateur&action=modifierInfos">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Nom</label>
                                    <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($nomDefaut) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Prénom</label>
                                    <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($prenomDefaut) ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Adresse e-mail</label>
                                <input type="email" name="mail" class="form-control" value="<?= htmlspecialchars($user->mail) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Adresse (N° et rue)</label>
                                <input type="text" name="rue" class="form-control" value="<?= htmlspecialchars($user->adresse) ?>" required>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="form-label text-muted">Code postal</label>
                                    <input type="text" name="cp" class="form-control" value="<?= htmlspecialchars($user->cp) ?>" required>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label text-muted">Ville</label>
                                    <input type="text" name="ville" class="form-control" value="<?= htmlspecialchars($user->ville) ?>" required>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success px-5">Enregistrer les modifications</button>
                            </div>
                        </form>
                    </div>
                </div>

            <?php elseif ($onglet === 'commandes'): ?>
                <?php if (empty($lesCommandes)): ?>
                    <div class="alert alert-info text-center">
                        Vous n'avez passé aucune commande.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>N° Commande</th>
                                    <th>Date</th>
                                    <th>État</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lesCommandes as $cmd): ?>
                                    <tr>
                                        <td>#<?= htmlspecialchars($cmd->id) ?></td>
                                        <td><?= date('d/m/Y', strtotime($cmd->date)) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $cmd->etat === 'validée' ? 'success' : 'secondary' ?>">
                                                <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $cmd->etat))) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

            <?php elseif ($onglet === 'avis'): ?>
                <?php if (empty($lesAvis)): ?>
                    <div class="alert alert-info text-center">
                        Vous n'avez déposé aucun avis.
                    </div>
                <?php else: ?>
                    <?php foreach ($lesAvis as $avis): ?>
                        <div class="card mb-3 border-0 border-bottom rounded-0 pb-3">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-2 text-center">
                                    <a href="index.php?uc=voirProduits&produit=<?= $avis->idProduit ?>&action=voirDetails" class="text-decoration-none">
                                        <img src="<?= htmlspecialchars($avis->imageProduit, ENT_QUOTES, 'UTF-8') ?>" class="img-fluid rounded-start" alt="Image Produit" style="max-height: 100px;">
                                        <div class="small mt-2 text-success" style="font-size: 0.8rem; line-height: 1.1;">
                                            <?= htmlspecialchars($avis->nomProduit, ENT_QUOTES, 'UTF-8') ?>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-10">
                                    <div class="card-body py-0">
                                        <div class="row mb-2">
                                            <div class="col-3 border-end">
                                                <div class="text-warning mb-1">
                                                    <?php 
                                                    for($i=1; $i<=5; $i++){
                                                        echo $i <= $avis->note ? '★' : '☆';
                                                    }
                                                    ?>
                                                </div>
                                                <small class="text-muted" style="font-size: 0.75rem;">Avis déposé le <?= date('d/m/Y', strtotime($avis->date)) ?></small>
                                            </div>
                                            <div class="col-9">
                                                <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Commentaire</h6>
                                                <p class="card-text mb-0"><?= htmlspecialchars($avis->description, ENT_QUOTES, 'UTF-8') ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>
</div>
