<?php

function addUser(PDO $pdo, string $email, string $password): bool
{
    // insert user
    $query = $pdo->prepare("INSERT INTO user(email, password) VALUES (:email, :password ) ");
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $query->bindValue(":email", $email, PDO::PARAM_STR);
    $query->bindValue(":password", $passwordHash, PDO::PARAM_STR);
    $query->execute();
    return true;
}

function verifyUserLogn(PDO $pdo, string $email, string $password): bool|array
{
    $query = $pdo->prepare("SELECT id_user, email, password FROM user WHERE email = :email");
    $query->bindValue(":email", $email, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    } else {
        return false;
    }
}
