<?php
include 'config.php';
include 'navbar.php';

$admin_user = 'admin';
$admin_pass = 'admin123';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == $admin_user && $password == $admin_pass) {
        // Redirecionar para a página de administrador
        header('Location: admin.php');
        exit;
    } else {
        echo "Usuário ou senha de administrador incorretos.";
    }
}
?>

<h2>Login de Administrador</h2>
<form method="post">
    Usuário: <input type="text" name="username" required><br>
    Senha: <input type="password" name="password" required><br>
    <input type="submit" value="Login">
</form>
<?php include 'footer.php'; ?>
