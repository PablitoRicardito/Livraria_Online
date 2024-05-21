<?php
include 'config.php';
include 'navbar.php';

$user_id = 1; // ID de usuário fixo para fins de exemplo

// Buscar itens do carrinho
$result = $conn->query("SELECT books.title, books.price, cart.quantity 
                        FROM cart 
                        JOIN books ON cart.book_id = books.id 
                        WHERE cart.user_id='$user_id'");

$total = 0;
$items = [];

while ($row = $result->fetch_assoc()) {
    $items[] = $row;
    $total += $row['price'] * $row['quantity'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checkout'])) {
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];

    // Processar a compra (esta parte seria mais complexa em um sistema real)

    // Limpar o carrinho
    $conn->query("DELETE FROM cart WHERE user_id='$user_id'");

    echo "Compra realizada com sucesso!";
    exit;
}
?>

<h2>Finalizar Compra</h2>

<h3>Itens no Carrinho</h3>
<table>
    <tr>
        <th>Título</th>
        <th>Preço</th>
        <th>Quantidade</th>
        <th>Total</th>
    </tr>
    <?php foreach ($items as $item): ?>
        <tr>
            <td><?php echo $item['title']; ?></td>
            <td>R$ <?php echo number_format($item['price'], 2, ',', '.'); ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td>R$ <?php echo number_format($item['price'] * $item['quantity'], 2, ',', '.'); ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Total da Compra: R$ <?php echo number_format($total, 2, ',', '.'); ?></h3>

<form method="post">
    Endereço de Entrega: <input type="text" name="address" required><br>
    Método de Pagamento: 
    <select name="payment_method" required>
        <option value="credit_card">Cartão de Crédito</option>
        <option value="boleto">Boleto</option>
        <option value="pix">PIX</option>
    </select><br>
    <input type="submit" name="checkout" value="Finalizar Compra">
</form>
<?php include 'footer.php'; ?>
