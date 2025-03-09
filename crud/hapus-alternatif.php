<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id_alternatif = $_GET['id'];

    $query = "SELECT foto FROM alternatif WHERE id_alternatif='$id_alternatif'";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);

    if (!empty($data['foto']) && file_exists("../foto_wisata/" . $data['foto'])) {
        unlink("../foto_wisata/" . $data['foto']);
    }

    $query = "DELETE FROM alternatif WHERE id_alternatif='$id_alternatif'";
    $result = mysqli_query($koneksi, $query);

    $_SESSION['status'] = $result ? 'success-delete' : 'error-delete';
    header("Location: ../alternatif.php");
    exit();
}
?>
