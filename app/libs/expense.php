<?php
require_once __DIR__ . "/../libs/init.php";

function getExpenses(PDO $pdo, int $user_id): array
{
    try {
        $sql = "SELECT amount, title, expense_date, category.name as category_name
            from expense 
            JOIN category ON category.id_category = expense.id_category
            WHERE id_user = :id";
        $query = $pdo->prepare($sql);
        $query->bindValue(":id", $user_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}
