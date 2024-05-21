<?php
include 'config.php';
include 'navbar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os valores do formulário
    $firstname = $_POST['firstname'];
    $lastname = $_POST['sobrenome'];
    $cpf = $_POST['cpf'];
    $birthdate = $_POST['data'];
    $email = $_POST['email'];
    $phone = $_POST['number'];
    $cep = $_POST['cep'];
    $address = $_POST['endereco'];
    $neighborhood = $_POST['bairro'];
    $city = $_POST['cidade'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];

    // Verificação básica dos dados do formulário
    if (!empty($birthdate)) {
        $date = DateTime::createFromFormat('Y-m-d', $birthdate);
        if ($date && $date->format('Y-m-d') === $birthdate) {
            // Criptografe a senha
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare a consulta SQL para inserir os dados no banco de dados
            $sql = "INSERT INTO users (firstname, lastname, cpf, birthdate, email, phone, cep, address, neighborhood, city, gender, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Use prepared statements para prevenir SQL Injection
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssssssssssss", $firstname, $lastname, $cpf, $birthdate, $email, $phone, $cep, $address, $neighborhood, $city, $gender, $hashed_password);

                // Execute a consulta
                if ($stmt->execute()) {
                    echo "Registro bem-sucedido!";
                } else {
                    echo "Erro: " . $stmt->error;
                }

                // Feche a declaração
                $stmt->close();
            } else {
                echo "Erro: " . $conn->error;
            }
        } else {
            echo "Data de nascimento inválida.";
        }
    } else {
        echo "A data de nascimento é obrigatória.";
    }

    // Feche a conexão
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-image">
            <div class="content">            
                <h2>Já Possui Conta?</h2>        
                <p>Faça login para entrar em sua conta</p>
                <br>    
                <button class="btn" id="login"><a href="login.php">Login</a></button>
                <br><br>
                <img src="imagem/img.svg" alt="">
            </div>
        </div>
        <div class="form">
            <form method="post" action="register.php">
                <div class="form-header">                 
                    <div class="title">
                        <a href="home.php"><img src="imagem/logo.png" alt="" class="logo"></a> 
                        <h3>Cadastre-se</h3>                   
                    </div>                    
                </div>
                <div class="input-group">
                    <div class="input-box">
                        <label for="firstname">Primeiro Nome</label>
                        <input id="firstname" type="text" name="firstname" placeholder="Digite seu primeiro nome" required>
                    </div>
                    <div class="input-box">
                        <label for="sobrenome">Sobrenome</label>
                        <input id="sobrenome" type="text" name="sobrenome" placeholder="Digite seu sobrenome" required>
                    </div>
                    <div class="input-box">
                        <label for="cpf">CPF</label>
                        <input id="cpfForm" type="text" name="cpf" placeholder="Digite seu CPF" required>
                    </div>
                    <div class="input-box">
                        <label for="data">Data de Nascimento:</label>
                        <input id="data" type="date" name="data" required>
                    </div>
                    <div class="input-box">
                        <label for="email">E-mail</label>
                        <input id="email" type="email" name="email" placeholder="Digite seu e-mail" required>
                    </div>
                    <div class="input-box">
                        <label for="number">Celular</label>
                        <input id="number" type="tel" name="number" placeholder="(xx) xxxx-xxxx" required>
                    </div>
                    <div class="input-box">
                        <label for="cep">CEP</label>
                        <input id="cep" type="text" name="cep" placeholder="Digite seu CEP" required>
                    </div>
                    <div class="input-box">
                        <label for="endereco">Endereço</label>
                        <input id="endereco" type="text" name="endereco" placeholder="Digite nome da rua" required>
                    </div>  
                    <div class="input-box">
                        <label for="bairro">Bairro</label>
                        <input id="bairro" type="text" name="bairro" placeholder="Digite nome do bairro" required>
                    </div> 
                    <div class="input-box">
                        <label for="cidade">Cidade</label>
                        <input id="cidade" type="text" name="cidade" placeholder="Digite nome da cidade" required>
                    </div> 
                    <div class="input-box">
                        <label for="password">Senha</label>
                        <input id="password" type="password" name="password" placeholder="Digite sua senha" required>
                    </div>
                    <div class="input-box">
                        <label for="confirmPassword">Confirme sua Senha</label>
                        <input id="confirmPassword" type="password" name="confirmPassword" placeholder="Digite sua senha novamente" required>
                    </div>               
                </div>
                <div class="gender-inputs">
                    <div class="gender-title">
                        <h6>Gênero</h6>
                    </div>
                    <div class="gender-group">
                        <div class="gender-input">
                            <input id="female" type="radio" name="gender" value="Feminino" required>
                            <label for="female">Feminino</label>
                        </div>
                        <div class="gender-input">
                            <input id="male" type="radio" name="gender" value="Masculino" required>
                            <label for="male">Masculino</label>
                        </div>
                        <div class="gender-input">
                            <input id="others" type="radio" name="gender" value="Outros" required>
                            <label for="others">Outros</label>
                        </div>
                        <div class="gender-input">
                            <input id="none" type="radio" name="gender" value="Prefiro não dizer" required>
                            <label for="none">Prefiro não dizer</label>
                        </div>
                    </div>
                </div>
                <div class="continue-button">                    
                    <button type="submit">Continuar</button>                                
                </div>
            </form>
        </div>
    </div>
    <?php include 'footer.php'?>
</body>
</html>

