<?php
require_once __DIR__ . '/libs/init.php';
require_once __DIR__ . "/libs/expense.php";

if (!isset($_SESSION['user'])) {
    header("Location: connection.php");
} else {
    $depenses = getExpenses($pdo, $_SESSION['user']['id_user']);
    // var_dump($depenses);
}
require_once __DIR__ . "/templates/header.php";
?>
<div class="container col-xxl-8 col-md-8 px-4 py-5">
    <h1 class="mb-5">Mes dépenses</h1>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Titre</th>
                <th scope="col">Montant</th>
                <th scope="col">Date</th>
                <th scope="col">Catégorie</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($depenses): ?>
                <?php foreach ($depenses as $depense): ?>
                    <tr>
                        <td><?= htmlspecialchars($depense['title']); ?></td>
                        <td><?= htmlspecialchars($depense['amount']); ?></td>
                        <td><?= htmlspecialchars($depense['expense_date']); ?></td>
                        <td><?= htmlspecialchars($depense['category_name']); ?></td>
                    <?php endforeach; ?>
                <?php else: ?>
                    <td>Aucune dépense trouvée.</td>
                <?php endif; ?>
                    </tr>
        </tbody>
    </table>
</div>




<?php
require_once __DIR__ . "/templates/footer.php";
