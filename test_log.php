<?php
// Script sederhana untuk menguji file log
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Test Log Reader</h2>";

// Cek direktori yang mungkin
$dirs = ['logs/'];
$foundDir = false;
$foundFile = false;
$fileContent = null;

foreach ($dirs as $dir) {
    echo "<p>Mencari di direktori: $dir ... ";
    if (is_dir($dir)) {
        echo "<strong>DITEMUKAN!</strong></p>";
        $foundDir = true;
        
        // Cari file log
        $pattern = $dir . 'topsis_calculation_*.log';
        $files = glob($pattern);
        
        echo "<p>File yang ditemukan: " . count($files) . "</p>";
        echo "<ul>";
        foreach ($files as $file) {
            echo "<li>$file (size: " . filesize($file) . " bytes)</li>";
            
            // Baca isi file
            $content = file_get_contents($file);
            if ($content !== false) {
                $foundFile = true;
                $fileContent = $content;
                echo " - <strong>File berhasil dibaca!</strong>";
                
                // Cari informasi user Fikri
                $matches = [];
                if (preg_match('/User: (Fikri|FIkri)/i', $content, $matches)) {
                    echo " - DITEMUKAN: " . htmlspecialchars($matches[0]);
                } else {
                    echo " - <span style='color:red'>User Fikri TIDAK DITEMUKAN!</span>";
                }
            } else {
                echo " - <span style='color:red'>GAGAL membaca file!</span>";
            }
        }
        echo "</ul>";
    } else {
        echo "tidak ditemukan</p>";
    }
}

if (!$foundDir) {
    echo "<p style='color:red'>PERINGATAN: Tidak ada direktori log yang ditemukan!</p>";
}

if (!$foundFile) {
    echo "<p style='color:red'>PERINGATAN: Tidak ada file log yang ditemukan!</p>";
} else {
    // Tampilkan struktur file log untuk analisis
    echo "<h3>Struktur File Log:</h3>";
    $entries = explode('==================================================', $fileContent);
    echo "<p>Jumlah entri terpisah: " . count($entries) . "</p>";
    
    echo "<h4>10 Baris Pertama:</h4>";
    $lines = explode("\n", $fileContent);
    echo "<pre>";
    for ($i = 0; $i < min(10, count($lines)); $i++) {
        echo htmlspecialchars($lines[$i]) . "\n";
    }
    echo "</pre>";
    
    echo "<h3>Mencari Entries:</h3>";
    foreach ($entries as $index => $entry) {
        $entry = trim($entry);
        if (empty($entry)) continue;
        
        echo "<p><strong>Entry #$index:</strong> " . substr(htmlspecialchars($entry), 0, 100) . "...</p>";
        
        if (stripos($entry, "Fikri") !== false) {
            echo "<p style='color:green'>MATCH di Entry #$index!</p>";
        }
    }
}
?>