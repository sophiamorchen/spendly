<?php
require_once __DIR__ . '/libs/init.php';
require_once __DIR__ . "/libs/expense.php";
require_once __DIR__ . "/libs/category.php";

if (!isset($_SESSION['user'])) {
    header("Location: connection.php");
}
$categories = getCategories($pdo);
$showModalAddExpense = false;

$errors = [];
if (isset($_POST['saveExpense'])) {
    $title = trim($_POST['title']);
    $amount = (float)$_POST['amount'];
    $category = isset($_POST['category']) ? (int)$_POST['category'] : 0;
    $expense_date = $_POST['date'];
    if (!is_numeric($amount) || $amount <= 0) {
        $errors['amount'] = "Le montant doit être supérieur à zéro";
    }
    if ($category <= 0) {
        $errors['category'] = "la catégorie est obligatoire";
    }

    if ($title === "") {
        $errors['title'] = "Le titre est obligatoire";
    }
    if (!$errors) {
        $res = saveExpense($pdo, $title, $amount, $expense_date, $category, $_SESSION['user']['id_user']);
        var_dump($res);
    } else {
        // Il y a une erreur, on veut afficher la modale
        $showModalAddExpense = true;
    }
}
$depenses = getExpenses($pdo, $_SESSION['user']['id_user']);
$expensesTotal = getExpensesTotal($pdo, $_SESSION['user']['id_user']);

require_once __DIR__ . "/templates/header.php";
?>

<div class="container col-xxl-8 col-md-8 px-4 py-5">
    <h1 class="mb-5">Mes dépenses</h1>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#depenseModal">
        Ajouter une dépense
    </button>

    <!-- Modal -->
    <div class="modal fade" id="depenseModal" tabindex="-1" aria-labelledby="depenseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="depenseModalLabel">Dépense</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre</label>
                            <input type="text" name="title" id="title" class="form-control" value="<?php if (isset($_POST['title'])) {
                                                                                                        echo $_POST['title'];
                                                                                                    }    ?>">
                        </div>
                        <?php if (isset($errors['title'])) :  ?>
                            <div class="alert alert-danger">
                                <?= htmlspecialchars($errors['title']); ?>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Montant</label>
                            <input type="number" name="amount" id="amount" step=".01" class="form-control" value="<?php if (isset($_POST['amount'])) {
                                                                                                                        echo $_POST['amount'];
                                                                                                                    }    ?>">
                        </div>
                        <?php if (isset($errors['amount'])) :  ?>
                            <div class="alert alert-danger">
                                <?= htmlspecialchars($errors['amount']); ?>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" id="date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Catégorie</label>
                            <select name="category" id="category" class="form-control form-select">

                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category["id_category"] ?>"><?= $category['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php if (isset($errors['category'])) :  ?>
                            <div class="alert alert-danger">
                                <?= htmlspecialchars($errors['category']); ?>
                            </div>
                        <?php endif; ?>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <input name="saveExpense" type="submit" class="btn btn-primary" value="Enregistrer">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <form method="GET">
        <table class="table mt-3">
            <thead>
                <tr class="table-dark">
                    <th scope="col">Titre</th>
                    <th scope="col">Montant</th>
                    <th scope="col">Date</th>
                    <th scope="col">
                        <select onchange="this.form.submit()" name="category" id="category" class="form-control form-select">
                            <option value="">Catégorie</option>
                            <?php foreach ($categories as $category): ?>
                                <option <?php (isset($_GET['category']) && (int)$_GET['category'] === $category['id_category']) ? "selected" : "" ?>value="<?= $category["id_category"] ?>"><?= $category['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if ($depenses): ?>
                    <?php foreach ($depenses as $depense): ?>
                        <tr>
                            <td><?= htmlspecialchars($depense['title']); ?></td>
                            <td><?= htmlspecialchars(formatPrice($depense['amount'])); ?></td>
                            <td><?= htmlspecialchars($depense['expense_date']); ?></td>
                            <td><?= htmlspecialchars($depense['category_name']); ?></td>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <td>Aucune dépense trouvée.</td>
                        </tr>
                    <?php endif; ?>
            <tfoot>
                <tr class="table-dark">
                    <td>Total</td>
                    <td><?= htmlspecialchars(formatPrice($expensesTotal['total'])); ?></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
            </tbody>
        </table>
    </form>
</div>

<script>
    <?php if ($showModalAddExpense): ?>
        document.addEventListener('DOMContentLoaded', (event) => {
            const depenseModal = new bootstrap.Modal(document.getElementById("depenseModal"));
            depenseModal.show();
        })

    <?php endif ?>
</script>


<?php
require_once __DIR__ . "/templates/footer.php";
