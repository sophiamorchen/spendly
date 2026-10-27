<?php
require_once __DIR__ . "/templates/header.php";
require_once __DIR__ . "/libs/expense.php";

if ($_SESSION['user']) {
    $depense = getExpenses($pdo, $_SESSION['user']['id_user']);
?>
    <pre>
<?php
    var_dump($depense);
?>
</pre>
<?php
}
?>


<?php
require_once __DIR__ . "/templates/footer.php";
