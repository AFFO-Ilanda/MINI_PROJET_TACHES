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
}

if (isset($_GET["action"]) && $_GET["action"] === "changerStatut") {
    changerStatut($_GET["id"]);
}

if (isset($_GET["action"]) && $_GET["action"] === "delete") {
    deleteTache($_GET["id"]);
}

header("Location: ../index.php?page=indexTache");
exit;