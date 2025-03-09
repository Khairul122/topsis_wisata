<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id_riwayat = $_GET['id'];

    $query = "DELETE FROM riwayat_rekomendasi WHERE id_riwayat = '$id_riwayat'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['status'] = 'success-delete';
    } else {
        $_SESSION['status'] = 'error-delete';
    }
    
    header("Location: ../riwayat-rekomendasi.php");
    exit();
}
?>