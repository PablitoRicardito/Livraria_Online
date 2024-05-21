<?php
include 'config.php';
include 'navbar.php';

$result = $conn->query("SELECT * FROM books");

while ($row = $result->fetch_assoc()) {
    echo "<div>";
    echo "<h2>" . $row['title'] . "</h2>";
    echo "<p>Autor: " . $row['author'] . "</p>";
    echo "<p>Gênero: " . $row['genre'] . "</p>";
    echo "<p>Preço: R$ " . $row['price'] . "</p>";
    echo "</div>";
}

$conn->close();
?>
