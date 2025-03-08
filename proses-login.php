<?php
session_start();
include 'koneksi.php'; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password =$_POST['password']; 

    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['level'] = $user['level'];

        echo "<script>
                alert('Login berhasil! Selamat datang, $username');
                window.location.href = 'dashboard.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Login gagal! Username atau password salah.');
                window.location.href = 'login.php';
              </script>";
        exit();
    }
}
?>
