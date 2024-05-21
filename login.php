<?php
include 'config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare a consulta SQL para buscar o usuário pelo email
    $sql = "SELECT id, password FROM users WHERE email = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        // Verifique se o usuário existe
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();
            
            // Verifique a senha
            if (password_verify($password, $hashed_password)) {
                // Senha correta, iniciar sessão e redirecionar
                $_SESSION['user_id'] = $id;
                header("Location: usuario.php");
                exit();
            } else {
                echo "Senha incorreta.";
            }
        } else {
            echo "Nenhum usuário encontrado com este email.";
        }
        
        $stmt->close();
    } else {
        echo "Erro: " . $conn->error;
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <div class="form">
            <form method="POST">
                <h2>Login</h2>
                <div class="input-box">
                    <label for="email">Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="input-box">
                    <label for="password">Senha</label>
                    <input type="password" name="password" required>
                </div>
                <div class="continue-button">
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
    <?php include 'footer.php'?>
</body>
</html>
