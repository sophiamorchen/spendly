<?php

require_once __DIR__ . "/../libs/pdo.php";
$mainMenu = [
    "index.php" => "Accueil",
    "a-propos.php" => "A propos",
    "inscription.php" => "Inscription",
    "connection.php" => "Connection"
]

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="./assets/css/override-bootstrap.css">
    <title>Spendly</title>
</head>

<body>
    <div class="container">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
            <div class="col-md-3 mb-2 mb-md-0">
                <img src="/assets/images/spendly.svg" alt="">

            </div>
            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <?php foreach ($mainMenu as $key => $value): ?>

                    <li class="nav-item"><a href="/<?= $key ?>" class="nav-link px-2 link-secondary"><?= $value ?></a></li>
                <?php endforeach ?>

            </ul>
            <div class="col-md-3 text-end">
                <a href="inscription.php" type="button" class="btn btn-outline-primary me-2">Inscription</a>
                <a href="connection.php" type="button" class="btn btn-primary">Se connecter</a>
            </div>
        </header>
    </div>
    <main>