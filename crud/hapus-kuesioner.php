<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id_kuesioner = $_GET['id'];

    $query = "DELETE FROM kuesioner WHERE id_kuesioner = '$id_kuesioner'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['status'] = 'success-delete';
    } else {
        $_SESSION['status'] = 'error-delete';
    }
    
    header("Location: ../kuesioner.php");
    exit();
}
?>  