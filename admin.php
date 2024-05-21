<?php
include 'config.php';
include 'navbar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $price = $_POST['price'];

    $sql = "INSERT INTO books (title, author, genre, price) VALUES ('$title', '$author', '$genre', '$price')";
    if ($conn->query($sql) === TRUE) {
        echo "Livro adicionado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_book'])) {
    $book_id = $_POST['book_id'];

    $sql = "DELETE FROM books WHERE id='$book_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Livro removido com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM books");
?>

<h2>Adicionar Livro</h2>
<form method="post">
    Título: <input type="text" name="title" required><br>
    Autor: <input type="text" name="author" required><br>
    Gênero: <input type="text" name="genre" required><br>
    Preço: <input type="text" name="price" required><br>
    <input type="submit" name="add_book" value="Adicionar">
</form>

<h2>Remover Livro</h2>
<form method="post">
    <select name="book_id" required>
        <option value="">Selecione um livro</option>
        <?php while ($row = $result->fetch_assoc()): ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
        <?php endwhile; ?>
    </select><br>
    <input type="submit" name="remove_book" value="Remover">
</form>
<?php include 'footer.php'; ?>

