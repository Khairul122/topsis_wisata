<?php
session_start();
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_kuesioner = $_POST['id_kuesioner'];
    $id_kriteria = $_POST['id_kriteria'];
    $pertanyaan = mysqli_real_escape_string($koneksi, $_POST['pertanyaan']);
    $opsi_jawaban = mysqli_real_escape_string($koneksi, $_POST['opsi_jawaban_pertanyaan']);
    $bobot = $_POST['bobot_opsi_jawaban_pertanyaan'];

    $query = "UPDATE kuesioner SET 
                id_kriteria = '$id_kriteria',
                pertanyaan = '$pertanyaan',
                opsi_jawaban_pertanyaan = '$opsi_jawaban',
                bobot_opsi_jawaban_pertanyaan = '$bobot'
              WHERE id_kuesioner = '$id_kuesioner'";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['status'] = 'success-edit';  
    } else {
        $_SESSION['status'] = 'error-edit';   
    }
    
    header("Location: ../kuesioner.php");  
    exit();
}
?>