<?php
include 'config.php';
include 'navbar.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $genre = isset($_GET['genre']) ? $_GET['genre'] : '';
    $author = isset($_GET['author']) ? $_GET['author'] : '';
    $query = "SELECT * FROM books WHERE 1=1";

    if (!empty($genre)) {
        $query .= " AND genre LIKE '%$genre%'";
    }

    if (!empty($author)) {
        $query .= " AND author LIKE '%$author%'";
    }

    $result = $conn->query($query);

    echo "<h2>Resultados da Pesquisa</h2>";
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h2>" . $row['title'] . "</h2>";
        echo "<p>Autor: " . $row['author'] . "</p>";
        echo "<p>Gênero: " . $row['genre'] . "</p>";
        echo "<p>Preço: R$ " . $row['price'] . "</p>";
        echo "</div>";
    }

    if ($result->num_rows == 0) {
        echo "<p>Nenhum livro encontrado.</p>";
    }

    $conn->close();
}
?>

<h2>Pesquisa Avançada</h2>
<form method="get">
    Gênero: <input type="text" name="genre"><br>
    Autor: <input type="text" name="author"><br>
    <input type="submit" value="Pesquisar">
</form>
<?php include 'footer.php'; ?>

