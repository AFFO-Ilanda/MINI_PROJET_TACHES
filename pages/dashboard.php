<?php
$stats = statsDashboard();
?>

<h1 class="mb-4">Tableau de bord</h1>

<div class="row g-4">

    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6 class="text-muted">Total tâches</h6>
                <h2><?= $stats["total"] ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6 class="text-muted">Tâches terminées</h6>
                <h2><?= $stats["terminees"] ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6 class="text-muted">% terminé</h6>
                <h2><?= $stats["pourcentage"] ?>%</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm text-center border-danger">
            <div class="card-body">
                <h6 class="text-muted">Tâches en retard</h6>
                <h2 class="text-danger"><?= $stats["retard"] ?></h2>
            </div>
        </div>
    </div>

</div>
