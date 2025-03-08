<?php
session_start();
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_alternatif = $_POST['id_alternatif'];
    $nama_wisata = $_POST['nama_wisata'];
    $koordinat = $_POST['koordinat'];
    $deskripsi = $_POST['deskripsi'];
    $url = $_POST['url'];

    if (!empty($_FILES['foto']['name'])) {
        $foto_name = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_path = "../foto_wisata/" . $foto_name;

        if (move_uploaded_file($foto_tmp, $foto_path)) {
            $foto_query = ", foto='$foto_name'";
        } else {
            $_SESSION['status'] = 'error-upload';
            header("Location: ../alternatif.php");
            exit();
        }
    } else {
        $foto_query = "";
    }

    $query = "UPDATE alternatif SET nama_wisata='$nama_wisata', koordinat='$koordinat', deskripsi='$deskripsi', url='$url' $foto_query WHERE id_alternatif='$id_alternatif'";
    $result = mysqli_query($koneksi, $query);

    $_SESSION['status'] = $result ? 'success-edit' : 'error-edit';
    header("Location: ../alternatif.php");
    exit();
}
?>
