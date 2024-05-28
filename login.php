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
    <link rel="stylesheet" href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="CSS/login.css">
    <title>Login</title>
</head>
<body>
    
<div class="container">
         <div>
            <a href="index.php"><img src="CSS/imagem/logo2.png" alt=""></a>
        </div>

        <div class="form">
            <form method="POST">
            <h3>Bem-vindo(a) de volta à Folster</h3>
            <p>Expanda seus conhecimentos</p>

            <div class="input-box">
            <input type="text" name="email" placeholder="E-mail" autofocus required>
            <i class='bx bxs-user'></i>
            </div>

            <div class="input-box">
            <input type="password" name="password" placeholder="Senha"required>
            <i class='bx bxs-lock-alt' ></i>
            </div>

            <div class="remember-forgot">
            <label> <input type="checkbox"> Lembrar senha</label>
            <a href="#"> Esqueceu senha? </a>        
            </div>

            <button type="submit" class="btn">Login</button>
            <div class="register-link">
            <br>
            <p> Não possui conta? <a href="register.php"> Cadastrar Aqui</a></p>
            </div>



               
            </form>
        </div>
    </div>
    <?php include 'footer.php'?>
</body>
</html>
