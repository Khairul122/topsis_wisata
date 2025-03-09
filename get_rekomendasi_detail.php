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
    
    $nama_user = $data['nama_user'];
    $tanggal = date('d-m-Y H:i', strtotime($data['tanggal']));
    
    $rekomendasi = json_decode($data['rekomendasi'], true);
    
    if ($rekomendasi === null && json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid JSON data: ' . json_last_error_msg()
        ]);
        exit;
    }
    
    $jawaban_query = mysqli_query($koneksi, "SELECT j.*, k.id_kriteria, k.pertanyaan 
                                           FROM jawaban_user j 
                                           JOIN kuesioner k ON j.id_kuesioner = k.id_kuesioner 
                                           WHERE j.nama_user = '$nama_user' 
                                           ORDER BY k.id_kriteria, k.pertanyaan");
    
    $jawaban_user = [];
    while ($jawaban_row = mysqli_fetch_assoc($jawaban_query)) {
        $kriteria_id = $jawaban_row['id_kriteria'];
        $pertanyaan = $jawaban_row['pertanyaan'];
        $id_kuesioner = $jawaban_row['id_kuesioner'];
        
        if (!isset($jawaban_user[$kriteria_id])) {
            $jawaban_user[$kriteria_id] = [];
        }
        
        $jawaban_user[$kriteria_id][$id_kuesioner] = [
            'pertanyaan' => $pertanyaan,
            'jawaban' => $jawaban_row['jawaban'],
            'nilai' => $jawaban_row['nilai'],
            'id_kuesioner' => $id_kuesioner
        ];
    }
    
    $kuesioner_data = [];
    foreach ($rekomendasi as $rec) {
        $alternatif_id = $rec['id_alternatif'];
        
        $matrix_query = mysqli_query($koneksi, "SELECT m.id_alternatif, m.id_kriteria, m.nilai, k.nama, k.jenis 
                                                FROM matrix m 
                                                JOIN kriteria k ON m.id_kriteria = k.id_kriteria 
                                                WHERE m.id_alternatif = '$alternatif_id'");
        
        $matrix_data = [];
        while ($matrix_row = mysqli_fetch_assoc($matrix_query)) {
            $kriteria_id = $matrix_row['id_kriteria'];
            $nilai_matrix = $matrix_row['nilai'];
            
            $kuesioner_query = mysqli_query($koneksi, "SELECT * FROM kuesioner WHERE id_kriteria = '$kriteria_id' ORDER BY pertanyaan, id_kuesioner ASC");
            
            $pertanyaan_data = [];
            $current_pertanyaan = '';
            
            while ($kuesioner_row = mysqli_fetch_assoc($kuesioner_query)) {
                $pertanyaan = $kuesioner_row['pertanyaan'];
                $id_kuesioner = $kuesioner_row['id_kuesioner'];
                
                if (!isset($pertanyaan_data[$pertanyaan])) {
                    $pertanyaan_data[$pertanyaan] = [
                        'pertanyaan' => $pertanyaan,
                        'opsi' => []
                    ];
                }
                
                $selected = false;
                if (isset($jawaban_user[$kriteria_id]) && 
                    array_key_exists($id_kuesioner, $jawaban_user[$kriteria_id])) {
                    $selected = true;
                }
                
                $pertanyaan_data[$pertanyaan]['opsi'][] = [
                    'id_kuesioner' => $id_kuesioner,
                    'opsi_jawaban' => $kuesioner_row['opsi_jawaban_pertanyaan'],
                    'bobot' => $kuesioner_row['bobot_opsi_jawaban_pertanyaan'],
                    'selected' => $selected
                ];
            }
            
            $pertanyaan_grouped = array_values($pertanyaan_data);
            
            $matrix_data[] = [
                'kriteria_id' => $kriteria_id,
                'kriteria_nama' => $matrix_row['nama'],
                'kriteria_jenis' => $matrix_row['jenis'],
                'nilai' => $nilai_matrix,
                'pertanyaan_grouped' => $pertanyaan_grouped
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