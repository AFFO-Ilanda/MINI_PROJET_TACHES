<?php

define("DATA_FILE", __DIR__ . "/../data/taches.json");


function lireTaches() {
    if (!file_exists(DATA_FILE)) {
        file_put_contents(DATA_FILE, json_encode([]));
    }
    return json_decode(file_get_contents(DATA_FILE), true);
}

function ecrireTaches($taches) {
    file_put_contents(DATA_FILE, json_encode($taches, JSON_PRETTY_PRINT));
}


function getTaches() {
    return array_reverse(lireTaches());
}

function getTacheById($id) {
    foreach (lireTaches() as $t) {
        if ($t["id"] == $id) return $t;
    }
    return null;
}

function addTache($titre, $description, $priorite, $date_limite, $responsable) {
    $taches = lireTaches();

    $taches[] = [
        "id" => time(),
        "titre" => $titre,
        "description" => $description,
        "priorite" => $priorite,
        "statut" => "a_faire",
        "date_creation" => date("Y-m-d"),
        "date_limite" => $date_limite,
        "responsable" => $responsable
    ];

    ecrireTaches($taches);
}

function changerStatut($id) {
    $taches = lireTaches();

    foreach ($taches as &$t) {
        if ($t["id"] == $id) {
            if ($t["statut"] === "a_faire") $t["statut"] = "en_cours";
            elseif ($t["statut"] === "en_cours") $t["statut"] = "terminee";
        }
    }

    ecrireTaches($taches);
}

function deleteTache($id) {
    $taches = array_filter(lireTaches(), fn($t) => $t["id"] != $id);
    ecrireTaches(array_values($taches));
}


function statsDashboard() {
    $taches = lireTaches();
    $total = count($taches);
    $terminees = count(array_filter($taches, fn($t) => $t["statut"] === "terminee"));
    $retard = count(array_filter($taches, fn($t) =>
        $t["statut"] !== "terminee" && $t["date_limite"] < date("Y-m-d")
    ));

    $pourcentage = $total ? round(($terminees / $total) * 100, 2) : 0;

    return compact("total", "terminees", "retard", "pourcentage");
}