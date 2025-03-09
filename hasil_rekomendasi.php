<?php
session_start();
require_once 'koneksi.php';

if (!isset($_SESSION['rekomendasi'])) {
    header("Location: index.php?error=no_recommendation");
    exit;
}

$rekomendasi = $_SESSION['rekomendasi'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Rekomendasi Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #2E8B57;
            --secondary-color: #3aa76d;
            --light-color: #f9f9f9;
            --dark-color: #333;
            --white-color: #fff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: var(--dark-color);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px 0;
            background-color: var(--white-color);
            border-radius: 10px;
            box-shadow: var(--shadow);
        }
        
        .header h1 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        .header p {
            color: #666;
            font-size: 1.1rem;
        }
        
        .results-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .result-card {
            background-color: var(--white-color);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .result-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        
        .rank-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: var(--primary-color);
            color: var(--white-color);
            font-weight: bold;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 1.2rem;
            z-index: 1;
            box-shadow: var(--shadow);
        }
        
        .result-image {
            position: relative;
            height: 200px;
            background-color: #ddd;
            overflow: hidden;
        }
        
        .result-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .result-card:hover .result-image img {
            transform: scale(1.05);
        }
        
        .result-content {
            padding: 20px;
        }
        
        .result-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: var(--primary-color);
        }
        
        .result-score {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .score-value {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-right: 10px;
        }
        
        .score-bar {
            flex-grow: 1;
            height: 8px;
            background-color: #e0e0e0;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .score-fill {
            height: 100%;
            background-color: var(--primary-color);
            border-radius: 4px;
        }
        
        .result-description {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.5;
        }
        
        .result-actions {
            display: flex;
            justify-content: space-between;
        }
        
        .view-map {
            display: inline-flex;
            align-items: center;
            background-color: var(--primary-color);
            color: var(--white-color);
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        
        .view-map:hover {
            background-color: var(--secondary-color);
        }
        
        .view-map i {
            margin-right: 8px;
        }
        
        .back-button {
            display: block;
            width: 200px;
            margin: 0 auto;
            padding: 12px 30px;
            background-color: var(--primary-color);
            color: var(--white-color);
            text-align: center;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: var(--shadow);
        }
        
        .back-button:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .results-container {
                grid-template-columns: 1fr;
            }
            
            .header h1 {
                font-size: 1.8rem;
            }
            
            .header p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Rekomendasi Destinasi Wisata</h1>
            <p>Berdasarkan preferensi kuesioner Anda</p>
        </div>
        
        <div class="results-container">
            <?php 
            $rank = 1;
            foreach ($rekomendasi as $item): 
                $id_alternatif = $item['id_alternatif'];
                $query = "SELECT * FROM alternatif WHERE id_alternatif = ?";
                $stmt = $koneksi->prepare($query);
                $stmt->bind_param("i", $id_alternatif);
                $stmt->execute();
                $result = $stmt->get_result();
                $wisata = $result->fetch_assoc();
                
                $percentage = round($item['nilai'] * 100);
            ?>
            <div class="result-card">
                <div class="result-image">
                    <div class="rank-badge">#<?php echo $rank; ?></div>
                    <img src="foto_wisata/<?php echo $wisata['foto']; ?>" alt="<?php echo $wisata['nama_wisata']; ?>" onerror="this.src='assets/img/default.jpg'">
                </div>
                <div class="result-content">
                    <h2 class="result-title"><?php echo $wisata['nama_wisata']; ?></h2>
                    <div class="result-score">
                        <div class="score-value"><?php echo number_format($item['nilai'] * 100, 1); ?>%</div>
                        <div class="score-bar">
                            <div class="score-fill" style="width: <?php echo $percentage; ?>%"></div>
                        </div>
                    </div>
                    <p class="result-description"><?php echo $wisata['deskripsi']; ?></p>
                    <div class="result-actions">
                        <a href="<?php echo $wisata['url']; ?>" target="_blank" class="view-map">
                            <i class="fas fa-map-marker-alt"></i> Lihat di Maps
                        </a>
                    </div>
                </div>
            </div>
            <?php 
                $rank++;
            endforeach; 
            ?>
        </div>
        
        <a href="index.php" class="back-button">Kembali</a>
    </div>
</body>
</html>