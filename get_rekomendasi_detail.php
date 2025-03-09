<?php
header('Content-Type: application/json');

include 'koneksi.php';


if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'ID not provided'
    ]);
    exit;
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

$query = mysqli_query($koneksi, "SELECT * FROM riwayat_rekomendasi WHERE id_riwayat = '$id'");

if (mysqli_num_rows($query) > 0) {
    $data = mysqli_fetch_assoc($query);
    
    $tanggal = date('d-m-Y H:i', strtotime($data['tanggal']));
    
    $rekomendasi = json_decode($data['rekomendasi'], true);
    
    if ($rekomendasi === null && json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid JSON data: ' . json_last_error_msg()
        ]);
        exit;
    }
    
    $kuesioner_data = [];
    foreach ($rekomendasi as $rec) {
        $alternatif_id = $rec['id_alternatif'];
        
        $matrix_query = mysqli_query($koneksi, "SELECT m.id_alternatif, m.id_kriteria, m.nilai, k.nama 
                                                FROM matrix m 
                                                JOIN kriteria k ON m.id_kriteria = k.id_kriteria 
                                                WHERE m.id_alternatif = '$alternatif_id'");
        
        $matrix_data = [];
        while ($matrix_row = mysqli_fetch_assoc($matrix_query)) {
            $kriteria_id = $matrix_row['id_kriteria'];
            $nilai_matrix = $matrix_row['nilai'];
            
            $kuesioner_query = mysqli_query($koneksi, "SELECT * FROM kuesioner WHERE id_kriteria = '$kriteria_id'");
            
            $kuesioner_items = [];
            while ($kuesioner_row = mysqli_fetch_assoc($kuesioner_query)) {
                $kuesioner_items[] = [
                    'pertanyaan' => $kuesioner_row['pertanyaan'],
                    'opsi_jawaban' => $kuesioner_row['opsi_jawaban_pertanyaan'],
                    'bobot' => $kuesioner_row['bobot_opsi_jawaban_pertanyaan']
                ];
            }
            
            $matrix_data[] = [
                'kriteria_id' => $kriteria_id,
                'kriteria_nama' => $matrix_row['nama'],
                'nilai' => $nilai_matrix,
                'kuesioner' => $kuesioner_items
            ];
        }
        
        $kuesioner_data[$alternatif_id] = $matrix_data;
    }
    
    echo json_encode([
        'status' => 'success',
        'data' => [
            'nama_user' => $data['nama_user'],
            'tanggal' => $tanggal,
            'rekomendasi' => $rekomendasi,
            'kuesioner_data' => $kuesioner_data
        ]
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Record not found'
    ]);
}