<?php
include 'config.php';
include 'navbar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $book_id = $_POST['book_id'];
    $user_id = 1; // ID de usuário fixo para fins de exemplo

    $sql = "INSERT INTO cart (user_id, book_id, quantity) VALUES ('$user_id', '$book_id', 1)";
    if ($conn->query($sql) === TRUE) {
        echo "Livro adicionado ao carrinho!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM books");

while ($row = $result->fetch_assoc()) {
    echo "<div>";
    echo "<h2>" . $row['title'] . "</h2>";
    echo "<p>Autor: " . $row['author'] . "</p>";
    echo "<p>Gênero: " . $row['genre'] . "</p>";
    echo "<p>Preço: R$ " . $row['price'] . "</p>";
    echo '<form method="post">';
    echo '<input type="hidden" name="book_id" value="' . $row['id'] . '">';
    echo '<input type="submit" name="add_to_cart" value="Adicionar ao Carrinho">';
    echo '</form>';
    echo "</div>";
}

$conn->close();
?>
<?php include 'footer.php'; ?>
