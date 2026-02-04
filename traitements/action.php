<?php
require_once "requets.php";

if (isset($_POST["addTache"])) {
    addTache(
        $_POST["titre"],
        $_POST["description"],
        $_POST["priorite"],
        $_POST["date_limite"],
        $_POST["responsable"]
    );
    header("Location: ../index.php?page=indexTache");
    exit;
}

if (isset($_POST["updateTache"])) {
    updateTache(
        $_POST["id"],
        $_POST["titre"],
        $_POST["description"],
        $_POST["priorite"],
        $_POST["date_limite"],
        $_POST["responsable"]
    );
    header("Location: ../index.php?page=indexTache");
    exit;
}

if (isset($_GET["action"]) && $_GET["action"] === "changerStatut") {
    changerStatut($_GET["id"]);
    header("Location: ../index.php?page=indexTache");
    exit;
}

if (isset($_GET["action"]) && $_GET["action"] === "delete") {
    deleteTache($_GET["id"]);
    header("Location: ../index.php?page=indexTache");
    exit;
}
