<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0); // Nonaktifkan pesan error untuk produksi

// Validasi parameter nama pengguna
if (!isset($_GET['user']) || empty($_GET['user'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Parameter user diperlukan'
    ]);
    exit;
}

$username = trim($_GET['user']);
$logDir = 'logs/'; // Gunakan direktori yang benar sesuai hasil test

// Fungsi untuk mencari data TOPSIS berdasarkan username
function findTopsisDataByUsername($username, $logDir) {
    // Cek apakah parameter tanggal disediakan
    $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
    
    // Cari file log berdasarkan tanggal
    $logFile = $logDir . 'topsis_calculation_' . $date . '.log';
    
    // Debug: Periksa apakah file ada
    if (!file_exists($logFile)) {
        // Jika tidak ada file untuk tanggal tertentu, coba cari semua file log
        $logFiles = glob($logDir . 'topsis_calculation_*.log');
        
        if (empty($logFiles)) {
            return [
                'status' => 'error',
                'message' => 'Tidak ada file log TOPSIS yang ditemukan di direktori ' . $logDir
            ];
        }
        
        // Urutkan file berdasarkan tanggal (terbaru dulu)
        usort($logFiles, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });
    } else {
        // Jika file untuk tanggal tertentu ditemukan, gunakan hanya file tersebut
        $logFiles = [$logFile];
    }
    
    // Periksa setiap file log
    foreach ($logFiles as $logFile) {
        if (!file_exists($logFile)) {
            continue;
        }
        
        $content = file_get_contents($logFile);
        if ($content === false) {
            continue;
        }
        
        // Pisahkan log berdasarkan pembatas
        $entries = explode('==================================================', $content);
        
        // Pendekatan baru: Loop melalui semua entri individual, bukan inkremen 2
        for ($i = 0; $i < count($entries); $i++) {
            $entry = trim($entries[$i]);
            
            // Lewati entri kosong
            if (empty($entry)) continue;
            
            // Cek jika entri ini berisi header dengan username
            if (stripos($entry, "User: $username") !== false) {
                // Jika ini adalah entri header, dan masih ada entri berikutnya, ambil data berikutnya
                if ($i + 1 < count($entries)) {
                    $data = trim($entries[$i + 1]);
                    
                    // Ambil timestamp dari header
                    $timestamp = '';
                    if (preg_match('/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/', $entry, $matches)) {
                        $timestamp = $matches[1];
                    }
                    
                    // Parse data TOPSIS
                    $topsisData = parseTopsisData($data, $timestamp);
                    return [
                        'status' => 'success',
                        'data' => $topsisData
                    ];
                }
            }
        }
    }
    
    return [
        'status' => 'error',
        'message' => "Tidak ditemukan data TOPSIS untuk pengguna '$username'"
    ];
}

function parseTopsisData($content, $timestamp) {
    $result = [
        'timestamp' => $timestamp,
        'alternatif' => [],
        'kriteria' => [],
        'nilai_kriteria' => [],
        'matrix_keputusan' => [],
        'matrix_ternormalisasi' => [],
        'matrix_ternormalisasi_berbobot' => [],
        'solusi_ideal' => [],
        'jarak_solusi_ideal' => [],
        'nilai_preferensi' => [],
        'hasil_rekomendasi' => []
    ];
    
    $sections = [
        'ALTERNATIF:' => 'alternatif',
        'KRITERIA:' => 'kriteria',
        'NILAI KRITERIA DARI JAWABAN USER:' => 'nilai_kriteria',
        'MATRIX KEPUTUSAN AWAL:' => 'matrix_keputusan',
        'MATRIX TERNORMALISASI:' => 'matrix_ternormalisasi',
        'MATRIX TERNORMALISASI BERBOBOT:' => 'matrix_ternormalisasi_berbobot',
        'SOLUSI IDEAL:' => 'solusi_ideal',
        'JARAK KE SOLUSI IDEAL:' => 'jarak_solusi_ideal',
        'NILAI PREFERENSI (SEBELUM NORMALISASI):' => 'nilai_preferensi',
        'HASIL REKOMENDASI AKHIR:' => 'hasil_rekomendasi'
    ];
    
    $lines = explode("\n", $content);
    $currentSection = null;
    
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) continue;
        
        // Periksa apakah line adalah header section
        foreach ($sections as $header => $section) {
            if (strpos($line, $header) === 0) {
                $currentSection = $section;
                continue 2; // Lanjut ke iterasi berikutnya
            }
        }
        
        if ($currentSection === null) continue;
        
        // Parsing sesuai bagian
        switch ($currentSection) {
            case 'alternatif':
                if (preg_match('/\[(\d+)\] (.+)/', $line, $matches)) {
                    $result['alternatif'][] = [
                        'id' => intval($matches[1]),
                        'nama' => trim($matches[2])
                    ];
                }
                continue 2; // Gunakan continue 2 untuk lanjut ke iterasi loop foreach
                
            case 'kriteria':
                if (preg_match('/\[K(\d+)\] (.+) - Bobot: ([\d.]+) - Jenis: (.+)/', $line, $matches)) {
                    $result['kriteria'][] = [
                        'id' => 'K' . $matches[1],
                        'nama' => trim($matches[2]),
                        'bobot' => floatval($matches[3]),
                        'jenis' => trim($matches[4])
                    ];
                }
                continue 2;
                
            case 'nilai_kriteria':
                if (preg_match('/\[K(\d+)\] (.+): ([\d.]+)/', $line, $matches)) {
                    $result['nilai_kriteria'][] = [
                        'id' => 'K' . $matches[1],
                        'nama' => trim($matches[2]),
                        'nilai' => floatval($matches[3])
                    ];
                }
                continue 2;
                
            case 'matrix_keputusan':
                // Skip header
                if (strpos($line, 'ID Alternatif') === 0 || strpos($line, '---') === 0) {
                    continue 2;
                }
                if (preg_match('/(\d+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|/', $line, $matches)) {
                    $result['matrix_keputusan'][] = [
                        'id_alternatif' => intval($matches[1]),
                        'nilai' => [
                            'K001' => floatval($matches[2]),
                            'K002' => floatval($matches[3]),
                            'K003' => floatval($matches[4]),
                            'K004' => floatval($matches[5]),
                            'K005' => floatval($matches[6]),
                            'K006' => floatval($matches[7])
                        ]
                    ];
                }
                continue 2;
                
            case 'matrix_ternormalisasi':
                // Skip header
                if (strpos($line, 'ID Alternatif') === 0 || strpos($line, '---') === 0) {
                    continue 2;
                }
                if (preg_match('/(\d+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|/', $line, $matches)) {
                    $result['matrix_ternormalisasi'][] = [
                        'id_alternatif' => intval($matches[1]),
                        'nilai' => [
                            'K001' => floatval($matches[2]),
                            'K002' => floatval($matches[3]),
                            'K003' => floatval($matches[4]),
                            'K004' => floatval($matches[5]),
                            'K005' => floatval($matches[6]),
                            'K006' => floatval($matches[7])
                        ]
                    ];
                }
                continue 2;
                
            case 'matrix_ternormalisasi_berbobot':
                // Skip header
                if (strpos($line, 'ID Alternatif') === 0 || strpos($line, '---') === 0) {
                    continue 2;
                }
                if (preg_match('/(\d+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|/', $line, $matches)) {
                    $result['matrix_ternormalisasi_berbobot'][] = [
                        'id_alternatif' => intval($matches[1]),
                        'nilai' => [
                            'K001' => floatval($matches[2]),
                            'K002' => floatval($matches[3]),
                            'K003' => floatval($matches[4]),
                            'K004' => floatval($matches[5]),
                            'K005' => floatval($matches[6]),
                            'K006' => floatval($matches[7])
                        ]
                    ];
                }
                continue 2;
                
            case 'solusi_ideal':
                // Skip header
                if (strpos($line, 'Tipe') === 0 || strpos($line, '---') === 0) {
                    continue 2;
                }
                if (preg_match('/(Positif|Negatif)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)\s+\|/', $line, $matches)) {
                    $result['solusi_ideal'][strtolower($matches[1])] = [
                        'K001' => floatval($matches[2]),
                        'K002' => floatval($matches[3]),
                        'K003' => floatval($matches[4]),
                        'K004' => floatval($matches[5]),
                        'K005' => floatval($matches[6]),
                        'K006' => floatval($matches[7])
                    ];
                }
                continue 2;
                
            case 'jarak_solusi_ideal':
                // Skip header
                if (strpos($line, 'ID Alternatif') === 0 || strpos($line, '---') === 0) {
                    continue 2;
                }
                if (preg_match('/(\d+)\s+\|\s+([\d.]+)\s+\|\s+([\d.]+)/', $line, $matches)) {
                    $result['jarak_solusi_ideal'][] = [
                        'id_alternatif' => intval($matches[1]),
                        'jarak_positif' => floatval($matches[2]),
                        'jarak_negatif' => floatval($matches[3])
                    ];
                }
                continue 2;
                
            case 'nilai_preferensi':
                // Skip header
                if (strpos($line, 'ID Alternatif') === 0 || strpos($line, '---') === 0) {
                    continue 2;
                }
                if (preg_match('/(\d+)\s+\|\s+(.+)\s+\|\s+([\d.]+)/', $line, $matches)) {
                    $result['nilai_preferensi'][] = [
                        'id_alternatif' => intval($matches[1]),
                        'nama_wisata' => trim($matches[2]),
                        'nilai' => floatval($matches[3])
                    ];
                }
                continue 2;
                
            case 'hasil_rekomendasi':
                // Skip header
                if (strpos($line, 'Peringkat') === 0 || strpos($line, '---') === 0) {
                    continue 2;
                }
                if (preg_match('/(\d+)\s+\|\s+(\d+)\s+\|\s+(.+)\s+\|\s+([\d.]+)/', $line, $matches)) {
                    $result['hasil_rekomendasi'][] = [
                        'peringkat' => intval($matches[1]),
                        'id_alternatif' => intval($matches[2]),
                        'nama_wisata' => trim($matches[3]),
                        'nilai' => floatval($matches[4])
                    ];
                }
                continue 2;
        }
    }
    
    return $result;
}

// Cek apakah direktori log ada
if (!file_exists($logDir)) {
    echo json_encode([
        'status' => 'error',
        'message' => "Direktori log tidak ditemukan di $logDir"
    ]);
    exit;
}

// Jalankan fungsi untuk mendapatkan data
$result = findTopsisDataByUsername($username, $logDir);

// Kembalikan hasil
echo json_encode($result, JSON_PRETTY_PRINT);
?>