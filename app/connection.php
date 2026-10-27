<?php
require_once __DIR__ . "/libs/init.php";
require_once __DIR__ . "/libs/users.php";
function validateForm()
{
    $errors = [];
    if (!isset($_POST['submit'])) {
        return $errors;
    }
    $postElements = ['email', 'password'];
    foreach ($postElements as $postElement) {
        if (empty($_POST[$postElement])) {
            $errors[] = "La case {$postElement} est obligatoire";
        }
    }
    if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email invalide";
    }
    if (!empty($_POST['password']) && mb_strlen($_POST['password']) < 8) {
        $errors[] = "Le mot de passe doit contenir au minimum 8 caractères";
    }

    return $errors;
}

$errors = validateForm();

if (isset($_POST['submit']) && count($errors) === 0) {
    $user = verifyUserLogn($pdo, $_POST['email'], $_POST['password']);
    if ($user) {
        session_regenerate_id(true);
        $_SESSION['user'] = [
            "id_user" => $user['id_user'],
            "email" => $user["email"]
        ];
        header("Location: index.php");
        exit;
    } else {
        $errors[] = "Email ou mot de passe incorrects";
    }
}

require_once __DIR__ . "/templates/header.php";


?>


<div class="container col-xxl-8 px-4 py-5">
    <?php if ($errors) : foreach ($errors as $error) : ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        <h1>Connection</h1>
        <form action="" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">email</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required minlength="8">
            </div>
            <input name="submit" type="submit" value="Envoyer" class="btn btn-primary">
        </form>
    </div>
</div>

<?php
require_once __DIR__ .  "/templates/footer.php";
