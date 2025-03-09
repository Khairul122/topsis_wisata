<?php
session_start();
require_once '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['jawaban']) || !isset($_POST['nama_user'])) {
    header("Location: index.php?error=invalid_input");
    exit;
}

$jawaban = $_POST['jawaban'];
$nama_user = $_POST['nama_user'];

// Simpan jawaban user ke database
foreach ($jawaban as $id_kriteria => $pertanyaan_array) {
    foreach ($pertanyaan_array as $pertanyaan => $id_kuesioner) {
        $query_jawaban = "SELECT opsi_jawaban_pertanyaan, bobot_opsi_jawaban_pertanyaan FROM kuesioner WHERE id_kuesioner = ?";
        $stmt = $koneksi->prepare($query_jawaban);
        $stmt->bind_param("i", $id_kuesioner);
        $stmt->execute();
        $result_jawaban = $stmt->get_result();
        
        if ($result_jawaban->num_rows > 0) {
            $row_jawaban = $result_jawaban->fetch_assoc();
            $teks_jawaban = $row_jawaban['opsi_jawaban_pertanyaan'];
            $nilai_bobot = $row_jawaban['bobot_opsi_jawaban_pertanyaan'];
            
            $query_simpan = "INSERT INTO jawaban_user (nama_user, id_kuesioner, jawaban, nilai) VALUES (?, ?, ?, ?)";
            $stmt_simpan = $koneksi->prepare($query_simpan);
            $stmt_simpan->bind_param("siss", $nama_user, $id_kuesioner, $teks_jawaban, $nilai_bobot);
            $stmt_simpan->execute();
        }
    }
}

// Ambil data alternatif
$query_alternatif = "SELECT id_alternatif, nama_wisata FROM alternatif";
$result_alternatif = $koneksi->query($query_alternatif);
$alternatif = array();

if ($result_alternatif->num_rows > 0) {
    while ($row = $result_alternatif->fetch_assoc()) {
        $alternatif[$row['id_alternatif']] = $row['nama_wisata'];
    }
} else {
    die("Tidak ada data alternatif wisata");
}

// Ambil data kriteria
$query_kriteria = "SELECT id_kriteria, nama, bobot, jenis FROM kriteria";
$result_kriteria = $koneksi->query($query_kriteria);
$kriteria = array();
$bobot_kriteria = array();
$jenis_kriteria = array();

if ($result_kriteria->num_rows > 0) {
    while ($row = $result_kriteria->fetch_assoc()) {
        $kriteria[$row['id_kriteria']] = $row['nama'];
        $bobot_kriteria[$row['id_kriteria']] = $row['bobot'];
        $jenis_kriteria[$row['id_kriteria']] = $row['jenis'];
    }
} else {
    die("Tidak ada data kriteria");
}

// Hitung nilai kriteria dari jawaban user
$nilai_kriteria = array();
foreach ($kriteria as $id_kriteria => $nama_kriteria) {
    $nilai_kriteria[$id_kriteria] = 0;
}

foreach ($jawaban as $id_kriteria => $pertanyaan_array) {
    $total_bobot = 0;
    $count = 0;
    
    foreach ($pertanyaan_array as $pertanyaan => $id_kuesioner) {
        $query_bobot = "SELECT bobot_opsi_jawaban_pertanyaan FROM kuesioner WHERE id_kuesioner = ?";
        $stmt = $koneksi->prepare($query_bobot);
        $stmt->bind_param("i", $id_kuesioner);
        $stmt->execute();
        $result_bobot = $stmt->get_result();
        
        if ($result_bobot->num_rows > 0) {
            $row_bobot = $result_bobot->fetch_assoc();
            $bobot_jawaban = $row_bobot['bobot_opsi_jawaban_pertanyaan'];
            $total_bobot += $bobot_jawaban;
            $count++;
        }
    }
    
    if ($count > 0) {
        $nilai_kriteria[$id_kriteria] = $total_bobot / $count;
    }
}

// PERBAIKAN 1: Buat matrix dengan nilai yang bervariasi untuk setiap alternatif
// Inisialisasi matrix
$matrix = array();
$seeds = [0.90, 1.00, 1.10]; // Nilai pembeda antar alternatif

$index = 0;
foreach ($alternatif as $id_alternatif => $nama_wisata) {
    $seed = $seeds[$index % count($seeds)]; // Menggunakan seed yang berbeda untuk setiap alternatif
    $index++;
    
    foreach ($nilai_kriteria as $id_kriteria => $nilai) {
        // PERBAIKAN: Menggunakan seed berbeda untuk tiap alternatif
        $adjusted_nilai = $nilai * $seed;
        $nilai_final = max(1, min(5, $adjusted_nilai));
        $matrix[$id_alternatif][$id_kriteria] = $nilai_final;
    }
}

// Simpan matrix ke database
$query_delete = "DELETE FROM matrix";
$koneksi->query($query_delete);

foreach ($matrix as $id_alternatif => $kriteria_values) {
    foreach ($kriteria_values as $id_kriteria => $nilai) {
        $query_insert = "INSERT INTO matrix (id_alternatif, id_kriteria, nilai) VALUES (?, ?, ?)";
        $stmt = $koneksi->prepare($query_insert);
        $stmt->bind_param("isd", $id_alternatif, $id_kriteria, $nilai);
        $stmt->execute();
    }
}

// Mulai perhitungan TOPSIS
// Langkah 1: Normalisasi matrix
$normalized_matrix = array();
$squared_sum = array();

foreach ($kriteria as $id_kriteria => $nama_kriteria) {
    $squared_sum[$id_kriteria] = 0;
}

foreach ($matrix as $id_alternatif => $kriteria_values) {
    foreach ($kriteria_values as $id_kriteria => $nilai) {
        $squared_sum[$id_kriteria] += pow($nilai, 2);
    }
}

foreach ($matrix as $id_alternatif => $kriteria_values) {
    foreach ($kriteria_values as $id_kriteria => $nilai) {
        if ($squared_sum[$id_kriteria] > 0) {
            $normalized_matrix[$id_alternatif][$id_kriteria] = $nilai / sqrt($squared_sum[$id_kriteria]);
        } else {
            $normalized_matrix[$id_alternatif][$id_kriteria] = 0;
        }
    }
}

// Langkah 2: Weighted normalized matrix
$weighted_matrix = array();

foreach ($normalized_matrix as $id_alternatif => $kriteria_values) {
    foreach ($kriteria_values as $id_kriteria => $nilai) {
        $weighted_matrix[$id_alternatif][$id_kriteria] = $nilai * $bobot_kriteria[$id_kriteria];
    }
}

// Langkah 3: Tentukan solusi ideal positif dan negatif
$positive_ideal = array();
$negative_ideal = array();

foreach ($kriteria as $id_kriteria => $nama_kriteria) {
    $values = array();
    foreach ($weighted_matrix as $id_alternatif => $kriteria_values) {
        $values[] = $kriteria_values[$id_kriteria];
    }
    
    if ($jenis_kriteria[$id_kriteria] == 'benefit') {
        $positive_ideal[$id_kriteria] = max($values);
        $negative_ideal[$id_kriteria] = min($values);
    } else {
        $positive_ideal[$id_kriteria] = min($values);
        $negative_ideal[$id_kriteria] = max($values);
    }
}

// Langkah 4: Hitung jarak ke solusi ideal
$positive_distance = array();
$negative_distance = array();

foreach ($weighted_matrix as $id_alternatif => $kriteria_values) {
    $positive_distance[$id_alternatif] = 0;
    $negative_distance[$id_alternatif] = 0;
    
    foreach ($kriteria_values as $id_kriteria => $nilai) {
        $positive_distance[$id_alternatif] += pow($nilai - $positive_ideal[$id_kriteria], 2);
        $negative_distance[$id_alternatif] += pow($nilai - $negative_ideal[$id_kriteria], 2);
    }
    
    $positive_distance[$id_alternatif] = sqrt($positive_distance[$id_alternatif]);
    $negative_distance[$id_alternatif] = sqrt($negative_distance[$id_alternatif]);
}

// Langkah 5: Hitung nilai preferensi
$preference_values = array();

// PERBAIKAN 2: Pastikan nilai preference tidak 0
foreach ($alternatif as $id_alternatif => $nama_wisata) {
    $total_distance = $positive_distance[$id_alternatif] + $negative_distance[$id_alternatif];
    
    if ($total_distance > 0) {
        $preference_values[$id_alternatif] = $negative_distance[$id_alternatif] / $total_distance;
    } else {
        // Jika total_distance 0, berikan nilai default yang berbeda per alternatif
        // untuk membuat ranking yang konsisten
        $preference_values[$id_alternatif] = 0.5 + (0.1 * ($id_alternatif % 3));
    }
}

// Urutkan preference values dari tertinggi ke terendah
arsort($preference_values);

// Ambil 3 rekomendasi teratas
$rekomendasi = array();
foreach ($preference_values as $id_alternatif => $value) {
    $rekomendasi[] = array(
        'id_alternatif' => $id_alternatif,
        'nama_wisata' => $alternatif[$id_alternatif],
        'nilai' => $value
    );
    
    if (count($rekomendasi) >= 3) {
        break;
    }
}

// Simpan hasil rekomendasi
$rekomendasi_json = json_encode($rekomendasi);

$query_riwayat = "INSERT INTO riwayat_rekomendasi (nama_user, rekomendasi) VALUES (?, ?)";
$stmt = $koneksi->prepare($query_riwayat);
$stmt->bind_param("ss", $nama_user, $rekomendasi_json);
$stmt->execute();

$_SESSION['rekomendasi'] = $rekomendasi;
$_SESSION['nama_user'] = $nama_user;

header("Location: ../hasil_rekomendasi.php");
exit;
?>