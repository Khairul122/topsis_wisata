<?php
include '../koneksi.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    $query = "SELECT * FROM riwayat_rekomendasi WHERE id_riwayat = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $rekomendasi = json_decode($row['rekomendasi'], true);
        
        echo "<div class='row mb-4'>";
        echo "<div class='col-md-6'>";
        echo "<h6>Nama Pengunjung</h6>";
        echo "<p><strong>" . $row['nama_user'] . "</strong></p>";
        echo "</div>";
        echo "<div class='col-md-6'>";
        echo "<h6>Tanggal Kuesioner</h6>";
        echo "<p><strong>" . date('d M Y, H:i', strtotime($row['tanggal'])) . "</strong></p>";
        echo "</div>";
        echo "</div>";
        
        echo "<h6 class='mb-3'>Rekomendasi Destinasi Wisata</h6>";
        echo "<div class='row'>";
        
        $rank = 1;
        foreach ($rekomendasi as $item) {
            $id_alternatif = $item['id_alternatif'];
            $query_alt = "SELECT * FROM alternatif WHERE id_alternatif = ?";
            $stmt_alt = $koneksi->prepare($query_alt);
            $stmt_alt->bind_param("i", $id_alternatif);
            $stmt_alt->execute();
            $result_alt = $stmt_alt->get_result();
            $alternatif = $result_alt->fetch_assoc();
            
            $persentase = number_format($item['nilai'] * 100, 1);
            
            echo "<div class='col-md-4 mb-4'>";
            echo "<div class='card'>";
            
            echo "<div class='position-relative'>";
            echo "<span class='badge badge-primary position-absolute' style='top: 10px; left: 10px; z-index: 1;'>Peringkat #" . $rank . "</span>";
            echo "<img class='card-img-top' src='../assets/img/" . $alternatif['foto'] . "' alt='" . $alternatif['nama_wisata'] . "' onerror=\"this.src='../assets/img/default.jpg'\" style='height: 150px; object-fit: cover;'>";
            echo "</div>";
            
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>" . $alternatif['nama_wisata'] . "</h5>";
            echo "<div class='d-flex align-items-center mb-2'>";
            echo "<div class='font-weight-bold mr-2'>" . $persentase . "%</div>";
            echo "<div class='progress flex-grow-1' style='height: 6px;'>";
            echo "<div class='progress-bar bg-success' role='progressbar' style='width: " . $persentase . "%' aria-valuenow='" . $persentase . "' aria-valuemin='0' aria-valuemax='100'></div>";
            echo "</div>";
            echo "</div>";
            echo "<p class='card-text' style='font-size: 0.9rem;'>" . substr($alternatif['deskripsi'], 0, 80) . "...</p>";
            echo "<a href='" . $alternatif['url'] . "' target='_blank' class='btn btn-sm btn-outline-primary'><i class='mdi mdi-map-marker'></i> Lihat di Maps</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            
            $rank++;
        }
        
        echo "</div>";
    } else {
        echo "<div class='alert alert-danger'>Data tidak ditemukan</div>";
    }
} else {
    echo "<div class='alert alert-danger'>ID tidak valid</div>";
}
?>