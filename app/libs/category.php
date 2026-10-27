<?php

function getCategories(PDO $pdo): array
{
    $query = $pdo->prepare("SELECT id_category, name FROM category c");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
