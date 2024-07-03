<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, arahkan kembali ke halaman login
    header("Location: login.html");
    exit();
}

// Kode untuk memproses penambahan resep dimulai di sini
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root"; // Ganti dengan username MySQL Anda jika berbeda
    $password = ""; // Ganti dengan password MySQL Anda jika berbeda
    $dbname = "login_db";

    // Buat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];

    // Amankan input user
    $title = mysqli_real_escape_string($conn, $title);
    $ingredients = mysqli_real_escape_string($conn, $ingredients);
    $instructions = mysqli_real_escape_string($conn, $instructions);

    // Masukkan resep ke database
    $sql = "INSERT INTO recipes (user_id, title, ingredients, instructions) VALUES ('$user_id', '$title', '$ingredients', '$instructions')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('RESEP BERHASIL DI TAMBAHKAN');
                document.location.href='list_recipes.php';
            </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "Metode tidak diizinkan.";
}
?>
