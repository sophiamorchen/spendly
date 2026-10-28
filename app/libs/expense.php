<?php
require_once __DIR__ . "/../libs/init.php";

function getExpenses(PDO $pdo, int $user_id): array
{

    $sql = "SELECT e.id_expense, e.amount, e.title, e.expense_date,e.id_category, c.name as category_name
            from expense e
            JOIN category  c ON  e.id_category = c.id_category
            WHERE id_user = :id
            ORDER BY e.expense_date DESC";
    $query = $pdo->prepare($sql);
    $query->bindValue(":id", $user_id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}


function getExpensesTotal(PDO $pdo, int $userId): array
{
    $sql = "SELECT SUM(e.amount) as total 
            FROM expense e
            WHERE e.id_user = :userId";

    $query = $pdo->prepare($sql);
    $query->bindValue(":userId", $userId, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function saveExpense(PDO $pdo, string $title, float $amount, string $expense_date, int $category_id, int $user_id): bool
{
    $sql = "INSERT INTO expense (title, amount, expense_date, id_category, id_user) 
            VALUES(:title, :amount, :expense_date, :id_category, :id_user) ";
    $query = $pdo->prepare($sql);
    $query->bindValue(":title", $title);
    $query->bindValue(":amount", $amount, PDO::PARAM_STR);
    $query->bindValue(":expense_date", $expense_date);
    $query->bindValue(":id_category", $category_id, PDO::PARAM_INT);
    $query->bindValue(":id_user", $user_id, PDO::PARAM_INT);
    return $query->execute();
}


function formatPrice(float|int $price, $currency = "€", $decimal = 2): string
{
    $formattedPrice = number_format($price, 2);
    return "$formattedPrice €";
}
