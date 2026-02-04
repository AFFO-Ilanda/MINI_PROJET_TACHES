<?php
require_once "db.php";



function getTaches() {
    global $pdo;
    $sql = "SELECT *,
            (date_limite < CURDATE() AND statut != 'terminee') AS en_retard
            FROM taches
            ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTacheById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM taches WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addTache($titre, $description, $priorite, $date_limite, $responsable) {
    global $pdo;
    $sql = "INSERT INTO taches
            (titre, description, priorite, statut, date_creation, date_limite, responsable)
            VALUES (?, ?, ?, 'a_faire', CURDATE(), ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        $titre, $description, $priorite, $date_limite, $responsable
    ]);
}

function updateTache($id, $titre, $description, $priorite, $date_limite, $responsable) {
    global $pdo;
    $sql = "UPDATE taches
            SET titre = ?, description = ?, priorite = ?, date_limite = ?, responsable = ?
            WHERE id = ? AND statut != 'terminee'";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        $titre, $description, $priorite, $date_limite, $responsable, $id
    ]);
}

function changerStatut($id) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT statut FROM taches WHERE id = ?");
    $stmt->execute([$id]);
    $tache = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$tache) return;

    if ($tache["statut"] === "a_faire") {
        $new = "en_cours";
    } elseif ($tache["statut"] === "en_cours") {
        $new = "terminee";
    } else {
        return;
    }

    $update = $pdo->prepare("UPDATE taches SET statut = ? WHERE id = ?");
    $update->execute([$new, $id]);
}

function deleteTache($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM taches WHERE id = ?");
    $stmt->execute([$id]);
}


function statsDashboard() {
    global $pdo;

    $total = $pdo->query("SELECT COUNT(*) FROM taches")->fetchColumn();
    $terminees = $pdo->query("SELECT COUNT(*) FROM taches WHERE statut = 'terminee'")->fetchColumn();
    $retard = $pdo->query("
        SELECT COUNT(*) FROM taches
        WHERE statut != 'terminee' AND date_limite < CURDATE()
    ")->fetchColumn();

    $pourcentage = ($total > 0) ? round(($terminees / $total) * 100, 2) : 0;

    return [
        "total" => $total,
        "terminees" => $terminees,
        "retard" => $retard,
        "pourcentage" => $pourcentage
    ];
}

function getStatsDashboard() {
    global $pdo;

    $total = $pdo->query("SELECT COUNT(*) FROM taches")->fetchColumn();
    $terminees = $pdo->query("SELECT COUNT(*) FROM taches WHERE statut='terminee'")->fetchColumn();
    $retard = $pdo->query("SELECT COUNT(*) FROM taches WHERE date_limite < CURDATE() AND statut!='terminee'")->fetchColumn();

    $pourcentage = $total > 0 ? round(($terminees / $total) * 100) : 0;

    return [
        "total" => $total,
        "terminees" => $terminees,
        "retard" => $retard,
        "pourcentage" => $pourcentage
    ];
}
