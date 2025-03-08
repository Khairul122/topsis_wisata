<?php
session_start();
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_kriteria = $_POST['id_kriteria'];
    $nama = $_POST['nama'];
    $bobot = $_POST['bobot'];
    $jenis = $_POST['jenis'];

    $query = "INSERT INTO kriteria (id_kriteria, nama, bobot, jenis) VALUES ('$id_kriteria', '$nama', '$bobot', '$jenis')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: ../kriteria.php?status=success-add");
    } else {
        header("Location: ../kriteria.php?status=error-add");
    }
    exit();
}
?>
