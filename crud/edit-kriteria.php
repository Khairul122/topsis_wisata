<?php
session_start();
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_kriteria = $_POST['id_kriteria'];
    $nama = $_POST['nama'];
    $bobot = $_POST['bobot'];
    $jenis = $_POST['jenis'];

    $query = "UPDATE kriteria SET nama='$nama', bobot='$bobot', jenis='$jenis' WHERE id_kriteria='$id_kriteria'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['status'] = 'success-edit';
    } else {
        $_SESSION['status'] = 'error-edit';
    }
    header("Location: ../kriteria.php");
    exit();
}
?>
