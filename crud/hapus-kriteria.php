<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id_kriteria = $_GET['id'];
    $query = "DELETE FROM kriteria WHERE id_kriteria='$id_kriteria'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['status'] = 'success-delete';
    } else {
        $_SESSION['status'] = 'error-delete';
    }
    header("Location: ../kriteria.php");
    exit();
}
?>
