<div class="container mt-4">
    <h2 class="mb-4">Gestion des promotions (Mise en avant)</h2>

    <?php if (!empty($erreurs)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($erreurs as $erreur): ?>
                    <li><?= htmlspecialchars($erreur) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($messages)): ?>
        <div class="alert alert-success">
            <ul>
                <?php foreach ($messages as $message): ?>
                    <li><?= htmlspecialchars($message) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <h4>Nouvelle programmation</h4>
        </div>
        <div class="card-body">
            <form action="index.php?uc=gererMiseEnAvant&action=ajouter" method="post">
                <div class="mb-3">
                    <label for="produit" class="form-label">Produit :</label>
                    <select name="produit" id="produit" class="form-select" required>
                        <option value="">-- Sélectionnez un produit --</option>
                        <?php foreach ($tousLesProduits as $prod): ?>
                            <option value="<?= htmlspecialchars($prod->id) ?>">
                                <?= htmlspecialchars($prod->id . ' - ' . $prod->description) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="dateDebut" class="form-label">Date de début :</label>
                        <input type="date" name="dateDebut" id="dateDebut" class="form-control" required min="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="dateFin" class="form-label">Date de fin :</label>
                        <input type="date" name="dateFin" id="dateFin" class="form-control" required min="<?= date('Y-m-d') ?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Programmer la mise en avant</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Programmations existantes</h4>
        </div>
        <div class="card-body">
            <?php if (empty($programmations)): ?>
                <p>Aucune programmation n'existe actuellement.</p>
            <?php else: ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id Produit</th>
                            <th>Description</th>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($programmations as $prog): ?>
                            <tr>
                                <td><?= htmlspecialchars($prog->id) ?></td>
                                <td><?= htmlspecialchars($prog->description) ?></td>
                                <td><?= date('d/m/Y', strtotime($prog->dateDebut)) ?></td>
                                <td><?= date('d/m/Y', strtotime($prog->dateFin)) ?></td>
                                <td>
                                    <a href="index.php?uc=gererMiseEnAvant&action=supprimer&id=<?= urlencode($prog->id) ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette programmation ?');">
                                        Supprimer
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
