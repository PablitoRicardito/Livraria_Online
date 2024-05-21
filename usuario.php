<?php
include 'config.php';

session_start();

// Verifique se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Obtenha os dados do usuário
$user_id = $_SESSION['user_id'];
$sql = "SELECT firstname, lastname, cpf, birthdate, email, phone, cep, address, neighborhood, city, gender FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Atualização dos dados do usuário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $sql = "UPDATE users SET firstname=?, lastname=?, cpf=?, birthdate=?, email=?, phone=?, cep=?, address=?, neighborhood=?, city=?, gender=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssi", $firstname, $lastname, $cpf, $birthdate, $email, $phone, $cep, $address, $neighborhood, $city, $gender, $user_id);
    if ($stmt->execute()) {
        echo "Dados atualizados com sucesso!";
    } else {
        echo "Erro ao atualizar dados: " . $stmt->error;
    }
    $stmt->close();

    header("Location: usuario.php");
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <div class="form">
            <h2>Perfil do Usuário</h2>
            <form method="POST">
                <div class="input-box">
                    <label for="firstname">Primeiro Nome</label>
                    <input type="text" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="lastname">Sobrenome</label>
                    <input type="text" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="cpf">CPF</label>
                    <input type="text" name="cpf" value="<?php echo htmlspecialchars($user['cpf']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="birthdate">Data de Nascimento</label>
                    <input type="date" name="birthdate" value="<?php echo htmlspecialchars($user['birthdate']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="phone">Celular</label>
                    <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="cep">CEP</label>
                    <input type="text" name="cep" value="<?php echo htmlspecialchars($user['cep']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="address">Endereço</label>
                    <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="neighborhood">Bairro</label>
                    <input type="text" name="neighborhood" value="<?php echo htmlspecialchars($user['neighborhood']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="city">Cidade</label>
                    <input type="text" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" required>
                </div>
                
                    
                <div class="gender-title">Gênero</div>

                <div class="input-box">
                    <input type="text" name="gender" value="<?php echo htmlspecialchars($user['gender']); ?>" required>
                </div>

            <div class="gender-inputs">
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
                    <button type="submit">Atualizar Dados</button>
                </div>
            </form>
            <div class="continue-button">
                <button><a href="?logout">Logout</a></button>
            </div>
        </div>
    </div>
</body>
</html>
