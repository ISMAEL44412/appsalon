<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function esUltimo(string $actual, string $proximo): bool {

    if($actual !== $proximo) {
        return true;
    } else {
        return false;
    }
}


// Verificar si esta autenticado
function isAuth() {
    if(!isset($_SESSION["login"])) {
        Header("Location: /");
    }
}

function isAdmin(){
    if(!isset($_SESSION["admin"])){
        Header("Location: /");
    }
}