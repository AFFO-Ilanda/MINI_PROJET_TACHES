<?php

$editMode = false;
$tacheEdit = null;

if (isset($_GET["edit"])) {
    $tacheEdit = getTacheById($_GET["edit"]);
    if ($tacheEdit && $tacheEdit["statut"] !== "terminee") {
        $editMode = true;
    }
}

$taches = getTaches();
?>

<h1 class="mb-4">Gestion des tâches</h1>

<a href="index.php?page=dashboard" class="btn btn-outline-secondary mb-4">
    📊 Voir le tableau de bord
</a>


<div class="card shadow-sm mb-4">
    <div class="card-header fw-bold">
        <?= $editMode ? "Modifier la tâche" : "Ajouter une tâche" ?>
    </div>

    <div class="card-body">
        <form method="post" action="traitements/action.php" class="row g-3">

            <?php if ($editMode): ?>
                <input type="hidden" name="id" value="<?= $tacheEdit["id"] ?>">
            <?php endif; ?>

            <div class="col-md-6">
                <input type="text" name="titre" class="form-control" placeholder="Titre"
                       value="<?= $editMode ? htmlspecialchars($tacheEdit["titre"]) : "" ?>" required>
            </div>

            <div class="col-md-6">
                <input type="text" name="responsable" class="form-control" placeholder="Responsable"
                       value="<?= $editMode ? htmlspecialchars($tacheEdit["responsable"]) : "" ?>">
            </div>

            <div class="col-12">
                <textarea name="description" class="form-control" placeholder="Description"><?= $editMode ? htmlspecialchars($tacheEdit["description"]) : "" ?></textarea>
            </div>

            <div class="col-md-4">
                <select name="priorite" class="form-select" required>
                    <?php foreach (["basse", "moyenne", "haute"] as $p): ?>
                        <option value="<?= $p ?>" <?= ($editMode && $tacheEdit["priorite"] === $p) ? "selected" : "" ?>>
                            <?= ucfirst($p) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4">
                <input type="date" name="date_limite" class="form-control"
                       value="<?= $editMode ? $tacheEdit["date_limite"] : "" ?>" required>
            </div>

            <div class="col-md-4 d-grid">
                <button class="btn btn-dark" name="<?= $editMode ? "updateTache" : "addTache" ?>">
                    <?= $editMode ? "Mettre à jour" : "Ajouter" ?>
                </button>
            </div>

            <?php if ($editMode): ?>
                <div class="col-12">
                    <a href="index.php?page=indexTache" class="btn btn-link">Annuler</a>
                </div>
            <?php endif; ?>

        </form>
    </div>
</div>


<h3 class="mb-3">Liste des tâches</h3>

<div class="row g-4">
<?php foreach ($taches as $t): ?>
    <div class="col-md-4 col-sm-6">

        <div class="card shadow-sm h-100">
            <div class="card-body">

                <h5><?= htmlspecialchars($t["titre"]) ?></h5>

                <p class="text-muted">
                    <?= htmlspecialchars($t["description"]) ?>
                </p>

                <span class="badge bg-secondary"><?= $t["priorite"] ?></span>
                <span class="badge bg-info"><?= $t["statut"] ?></span>

                <?php if ($t["en_retard"]): ?>
                    <span class="badge bg-danger">En retard</span>
                <?php endif; ?>

                <hr>

                <small>
                    📅 <?= $t["date_limite"] ?><br>
                    👤 <?= htmlspecialchars($t["responsable"]) ?>
                </small>
            </div>

            <div class="card-footer text-end">

                <?php if ($t["statut"] !== "terminee"): ?>
                    <a href="index.php?page=indexTache&edit=<?= $t["id"] ?>"
                       class="btn btn-sm btn-outline-primary">
                        Modifier
                    </a>

                    <a href="traitements/action.php?action=changerStatut&id=<?= $t["id"] ?>"
                       class="btn btn-sm btn-outline-success">
                        Statut
                    </a>
                <?php endif; ?>

                <a href="traitements/action.php?action=delete&id=<?= $t["id"] ?>"
                   class="btn btn-sm btn-outline-danger"
                   onclick="return confirm('Supprimer cette tâche ?');">
                    Supprimer
                </a>

            </div>
        </div>

    </div>
<?php endforeach; ?>
</div>
