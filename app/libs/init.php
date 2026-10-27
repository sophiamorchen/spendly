<?php
require_once __DIR__ . "/../libs/pdo.php";



// exemples de ce qu'on pourrait avoir ici :
// 1. Afficher toutes les erreurs (seulement pendant le développement)
// error_reporting(E_ALL);              // signaler tous les types d'erreurs
// ini_set('display_errors', '1');      // les afficher dans la page

// 2. Fuseau horaire, pour que les dates des dépenses soient à l'heure française
// date_default_timezone_set('Europe/Paris');

// 3. Démarrer la session, pour se souvenir de l'utilisatrice connectée
session_start();                     // doit être appelé avant tout HTML


// 4. Charger les fonctions de l'application
// require_once __DIR__ . "/users.php"; // addUser(), et plus tard getUserByEmail()...