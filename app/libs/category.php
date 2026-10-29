<?php

function getCategories(PDO $pdo): array
{
    $query = $pdo->prepare("SELECT id_category, name FROM category c");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function addCategory(PDO $pdo, string $name): int
{
    $sql = "INSERT INTO category (name) VALUES (:name)";
    $query = $pdo->prepare($sql);
    $query->bindValue(":name", $name);
    $query->execute();
    return $pdo->lastInsertId();
}
