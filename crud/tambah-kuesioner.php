<?php
session_start();
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_kriteria = $_POST['id_kriteria'];
    $pertanyaan = mysqli_real_escape_string($koneksi, $_POST['pertanyaan']);
    $opsi_jawaban = mysqli_real_escape_string($koneksi, $_POST['opsi_jawaban_pertanyaan']);
    $bobot = $_POST['bobot_opsi_jawaban_pertanyaan'];

    $query = "INSERT INTO kuesioner (id_kriteria, pertanyaan, opsi_jawaban_pertanyaan, bobot_opsi_jawaban_pertanyaan) 
              VALUES ('$id_kriteria', '$pertanyaan', '$opsi_jawaban', '$bobot')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['status'] = 'success-add';
    } else {
        $_SESSION['status'] = 'error-add';
    }
    
    header("Location: ../kuesioner.php");
    exit();
}
?>