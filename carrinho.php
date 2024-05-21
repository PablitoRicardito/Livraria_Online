<?php
include 'config.php';
include 'navbar.php';

$user_id = 1; // ID de usuário fixo para fins de exemplo

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_from_cart'])) {
    $cart_id = $_POST['cart_id'];

    $sql = "DELETE FROM cart WHERE id='$cart_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Livro removido do carrinho!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$result = $conn->query("SELECT cart.id as cart_id, books.title, books.author, books.genre, books.price 
                        FROM cart 
                        JOIN books ON cart.book_id = books.id 
                        WHERE cart.user_id='$user_id'");

echo "<h2>Seu Carrinho</h2>";

while ($row = $result->fetch_assoc()) {
    echo "<div>";
    echo "<h2>" . $row['title'] . "</h2>";
    echo "<p>Autor: " . $row['author'] . "</p>";
    echo "<p>Gênero: " . $row['genre'] . "</p>";
    echo "<p>Preço: R$ " . $row['price'] . "</p>";
    echo '<form method="post">';
    echo '<input type="hidden" name="cart_id" value="' . $row['cart_id'] . '">';
    echo '<input type="submit" name="remove_from_cart" value="Remover do Carrinho">';
    echo '</form>';
    echo "</div>";
}

if ($result->num_rows > 0) {
    echo '<form action="checkout.php" method="post">';
    echo '<input type="submit" value="Finalizar Compra">';
    echo '</form>';
}

$conn->close();
?>
<?php include 'footer.php'; ?>
