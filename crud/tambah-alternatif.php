<?php
session_start();
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_wisata = $_POST['nama_wisata'];
    $koordinat = $_POST['koordinat'];
    $deskripsi = $_POST['deskripsi'];
    $url = $_POST['url'];

    $foto = "";
    if (!empty($_FILES['foto']['name'])) {
        $foto_name = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_path = "../foto_wisata/" . $foto_name;

        if (move_uploaded_file($foto_tmp, $foto_path)) {
            $foto = $foto_name;
        }
    }

    $query = "INSERT INTO alternatif (nama_wisata, koordinat, deskripsi, foto, url) VALUES ('$nama_wisata', '$koordinat', '$deskripsi', '$foto', '$url')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['status'] = 'success-add';
    } else {
        $_SESSION['status'] = 'error-add';
    }
    header("Location: ../alternatif.php");
    exit();
}
?>
