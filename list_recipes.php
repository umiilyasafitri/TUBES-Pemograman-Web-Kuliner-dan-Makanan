<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Anda harus login terlebih dahulu.";
    exit();
}

$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password is empty
$dbname = "login_db";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil semua resep dari database
$sql = "SELECT * FROM recipes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<h2>" . $row['title'] . "</h2>";
        echo "<p><strong>Bahan-bahan:</strong><br>" . nl2br($row['ingredients']) . "</p>";
        echo "<p><strong>Instruksi:</strong><br>" . nl2br($row['instructions']) . "</p>";
    }
} else {
    echo "Belum ada resep.";
}

$conn->close();
?>
