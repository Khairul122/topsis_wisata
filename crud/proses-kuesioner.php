<?php
session_start();
require_once '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['jawaban']) || !isset($_POST['nama_user'])) {
    header("Location: index.php?error=invalid_input");
    exit;
}

$jawaban = $_POST['jawaban'];
$nama_user = $_POST['nama_user'];

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

$query_matrix = "SELECT id_alternatif, id_kriteria, nilai FROM matrix";
$result_matrix = $koneksi->query($query_matrix);
$matrix = array();

if ($result_matrix->num_rows > 0) {
    while ($row = $result_matrix->fetch_assoc()) {
        $matrix[$row['id_alternatif']][$row['id_kriteria']] = $row['nilai'];
    }
}

foreach ($alternatif as $id_alternatif => $nama_wisata) {
    foreach ($kriteria as $id_kriteria => $nama_kriteria) {
        if (!isset($matrix[$id_alternatif][$id_kriteria])) {
            $matrix[$id_alternatif][$id_kriteria] = 0;
        }
    }
}

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

foreach ($alternatif as $id_alternatif => $nama_wisata) {
    foreach ($nilai_kriteria as $id_kriteria => $nilai) {
        $variasi = rand(90, 110) / 100;
        $nilai_variasi = $nilai * $variasi;
        
        $nilai_final = max(1, min(5, $nilai_variasi));
        
        $matrix[$id_alternatif][$id_kriteria] = $nilai_final;
    }
}

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

$weighted_matrix = array();

foreach ($normalized_matrix as $id_alternatif => $kriteria_values) {
    foreach ($kriteria_values as $id_kriteria => $nilai) {
        $weighted_matrix[$id_alternatif][$id_kriteria] = $nilai * $bobot_kriteria[$id_kriteria];
    }
}

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

$preference_values = array();

foreach ($alternatif as $id_alternatif => $nama_wisata) {
    $total_distance = $positive_distance[$id_alternatif] + $negative_distance[$id_alternatif];
    
    if ($total_distance > 0) {
        $preference_values[$id_alternatif] = $negative_distance[$id_alternatif] / $total_distance;
    } else {
        $preference_values[$id_alternatif] = 0;
    }
}

arsort($preference_values);

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