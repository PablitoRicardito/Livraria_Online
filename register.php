<?php
include 'config.php';
include 'navbar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os valores do formulário
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $cpf = $_POST['cpf'];
    $birthdate = $_POST['birthdate'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $cep = $_POST['cep'];
    $address = $_POST['address'];
    $neighborhood = $_POST['neighborhood'];
    $city = $_POST['city'];
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function applyMask(input, mask) {
                input.addEventListener("input", function() {
                    var value = input.value.replace(/\D/g, '');
                    var newValue = '';
                    var maskIndex = 0;
                    for (var i = 0; i < value.length; i++) {
                        while (maskIndex < mask.length && mask[maskIndex].match(/\D/)) {
                            newValue += mask[maskIndex++];
                        }
                        if (maskIndex < mask.length) {
                            newValue += value[i];
                            maskIndex++;
                        }
                    }
                    input.value = newValue;
                });
            }

            var cpfInput = document.getElementById("cpf");
            var phoneInput = document.getElementById("phone");
            var cepInput = document.getElementById("cep");

            applyMask(cpfInput, "999.999.999-99");
            applyMask(phoneInput, "(99) 9 9999-9999");
            applyMask(cepInput, "99999-999");

            cpfInput.setAttribute("maxlength", "14"); // Máximo de caracteres para CPF (11 dígitos + 3 pontos + hífen)
            phoneInput.setAttribute("maxlength", "16"); // Máximo de caracteres para telefone (11 dígitos + 4 espaços e parênteses)
            cepInput.setAttribute("maxlength", "9"); // Máximo de caracteres para CEP (8 dígitos + hífen)
        });
    </script>
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
                <div class="input-group . form">
                    <div class="input-box">
                    <label for="firstname">Primeiro Nome</label>
                    <input type="text" id="firstname" name="firstname" required>
                </div>
                <div class="input-box">
                    <label for="lastname">Sobrenome</label>
                    <input type="text" id="lastname" name="lastname" required>
                </div>
                <div class="input-box">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="cpf" required>
                </div>
                <div class="input-box">
                    <label for="birthdate">Data de Nascimento</label>
                    <input type="date" id="birthdate" name="birthdate" required>
                </div>
                <div class="input-box">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-box">
                    <label for="phone">Celular</label>
                    <input type="text" id="phone" name="phone" required>
                </div>
                <div class="input-box">
                    <label for="cep">CEP</label>
                    <input type="text" id="cep" name="cep" required>
                </div>
                <div class="input-box">
                    <label for="address">Endereço</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <div class="input-box">
                    <label for="neighborhood">Bairro</label>
                    <input type="text" id="neighborhood" name="neighborhood" required>
                </div>
                <div class="input-box">
                    <label for="city">Cidade</label>
                    <input type="text" id="city" name="city" required>
                </div>

                <div class="gender-inputs">
                    
                <div class="gender-title">Gênero</div>
                    
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
                <div class="input-box">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" maxlength="8" required>
                </div>

                <div class="input-box">
                    <label for="confirmPassword">Confirme sua Senha</label>
                    <input id="confirmPassword" type="password" name="confirmPassword" maxlength="8" required>
                    </div>           
                <div class="continue-button">
                    <button type="submit">Registrar</button>
                </div>
            </form>
        </div>
    </div>
    <?php include 'footer.php'?>
</body>
</html>
