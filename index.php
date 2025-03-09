<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Berastagi tourism</title>
    <link rel="stylesheet" href="style/style.css" />
    <link rel="icon" href="img/kominfo logo.png" type="image/x-icon" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Rubik:ital@0;1&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="style/transition.css" />
</head>

<body>
    <section class="section-1">
        <header class="header fade-in">
            <a href="#section-2">Home</a>
            <a href="#section-4">Rekomendasi Wisata</a>
            <a href="login.php">Login</a>
        </header>
        <img src="img/mount-batur.jpg" alt="" class="home-img" />
        <div class="content">
            <div class="welcome fade-out">
                <p>Welcome to</p>
                <p class="home-pulesari fade-out">Berastagi Tourism</p>
            </div>

            <a href="#section-3" class="explore-button fade-scroll">Explore</a>
        </div>
    </section>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        #berastagi-map {
            width: 100%;
            height: 500px;
            margin-top: 20px;
            background: #eee;
            border: 1px solid #ccc;
        }

        .name-input-container {
            margin-bottom: 30px;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .name-input-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .name-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2E8B57;
            font-size: 1.1rem;
        }

        .name-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .name-input:focus {
            outline: none;
            border-color: #2E8B57;
            box-shadow: 0 0 0 3px rgba(46, 139, 87, 0.25);
        }

        .name-input::placeholder {
            color: #aaa;
        }
    </style>

    <section id="section-2" class="section-2">
        <div class="container-section2">
            <p class="introduction-village fade-scroll">Peta Lokasi Wisata Berastagi</p>
            <hr class="line-section2 fade-scroll" />
            <div class="content-explore">
                <div id="berastagi-map"></div>
            </div>
        </div>
    </section>

    <?php
    include 'koneksi.php';

    $sql_map = "SELECT * FROM alternatif";
    $result_map = $koneksi->query($sql_map);

    $map_data = array();
    if ($result_map->num_rows > 0) {
        while ($row = $result_map->fetch_assoc()) {
            $map_data[] = $row;
        }
    }

    $map_json = json_encode($map_data);
    ?>

    <script>
        window.onload = function() {
            var mapElement = document.getElementById('berastagi-map');
            if (!mapElement) {
                console.error("Element berastagi-map tidak ditemukan!");
                return;
            }

            console.log("Map element found, initializing...");

            mapElement.style.height = '600px';
            mapElement.style.width = '1900px';

            var berastagiCoords = [3.1944, 98.5078];

            var map = L.map('berastagi-map').setView(berastagiCoords, 11);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19
            }).addTo(map);

            L.marker(berastagiCoords).addTo(map)
                .bindPopup('<b>Berastagi</b><br>Karo, North Sumatra, Indonesia.')
                .openPopup();

            var poisData = <?php echo $map_json; ?>;

            poisData.forEach(function(poi) {
                var coords = poi.koordinat.split(',').map(function(item) {
                    return parseFloat(item.trim());
                });

                var popupContent = '<div style="text-align: center;">';

                if (poi.foto) {
                    popupContent += '<img src="foto_wisata/' + poi.foto + '" style="max-width: 200px; max-height: 150px; margin-bottom: 10px;"><br>';
                }

                popupContent += '<b>' + poi.nama_wisata + '</b><br>' +
                    poi.deskripsi + '<br><br>' +
                    '<a href="' + poi.url + '" target="_blank" style="color: blue; text-decoration: underline;">Lihat di Google Maps</a>';

                popupContent += '</div>';

                L.marker(coords).addTo(map)
                    .bindPopup(popupContent);
            });

            setTimeout(function() {
                map.invalidateSize();
            }, 500);
        };
    </script>

    <?php
    include 'koneksi.php';

    $sql_kriteria = "SELECT DISTINCT k.id_kriteria, kr.nama 
                FROM kuesioner k 
                INNER JOIN kriteria kr ON k.id_kriteria = kr.id_kriteria 
                ORDER BY k.id_kriteria ASC";
    $result_kriteria = $koneksi->query($sql_kriteria);

    function getPertanyaanByKriteria($koneksi, $id_kriteria)
    {
        $sql = "SELECT pertanyaan FROM (
                SELECT pertanyaan, MIN(id_kuesioner) as min_id 
                FROM kuesioner 
                WHERE id_kriteria = '$id_kriteria' 
                GROUP BY pertanyaan
            ) AS temp 
            ORDER BY min_id";

        return $koneksi->query($sql);
    }

    function getOpsiJawaban($koneksi, $id_kriteria, $pertanyaan)
    {
        $pertanyaan = $koneksi->real_escape_string($pertanyaan);
        $sql = "SELECT id_kuesioner, opsi_jawaban_pertanyaan, bobot_opsi_jawaban_pertanyaan 
            FROM kuesioner 
            WHERE id_kriteria = '$id_kriteria' AND pertanyaan = '$pertanyaan'
            ORDER BY bobot_opsi_jawaban_pertanyaan DESC";
        return $koneksi->query($sql);
    }
    ?>

    <section class="section-4" id="section-4">
        <div class="center">
            <p class="tour-packages fade-scroll">Rekomendasi Wisata</p>
        </div>

        <div class="kuesioner-wrapper">
            <div class="kuesioner-container">
                <form action="crud/proses-kuesioner.php" method="post" id="formKuesioner">
                    <div class="form-group name-input-container">
                        <label for="nama_user" class="name-label">Nama Anda</label>
                        <input type="text" name="nama_user" id="nama_user" class="form-control name-input" placeholder="Masukkan nama lengkap anda" required>
                    </div>
                    <?php
                    if ($result_kriteria->num_rows > 0) {
                        $counter = 1;
                        while ($row_kriteria = $result_kriteria->fetch_assoc()) {
                            $id_kriteria = $row_kriteria['id_kriteria'];
                            $nama_kriteria = $row_kriteria['nama'];
                            echo "<div class='kriteria-section' id='kriteria-{$id_kriteria}'>";
                            echo "<h2 class='kriteria-title'>{$nama_kriteria}</h2>";

                            $result_pertanyaan = getPertanyaanByKriteria($koneksi, $id_kriteria);
                            if ($result_pertanyaan->num_rows > 0) {
                                $question_num = 1;
                                while ($row_pertanyaan = $result_pertanyaan->fetch_assoc()) {
                                    $pertanyaan = $row_pertanyaan['pertanyaan'];
                                    echo "<div class='question-container'>";
                                    echo "<p class='question'><span class='question-number'>{$counter}.</span> {$pertanyaan}</p>";

                                    $result_opsi = getOpsiJawaban($koneksi, $id_kriteria, $pertanyaan);
                                    if ($result_opsi->num_rows > 0) {
                                        echo "<div class='options-container'>";
                                        while ($row_opsi = $result_opsi->fetch_assoc()) {
                                            $id_kuesioner = $row_opsi['id_kuesioner'];
                                            $opsi = $row_opsi['opsi_jawaban_pertanyaan'];
                                            $bobot = $row_opsi['bobot_opsi_jawaban_pertanyaan'];

                                            echo "<div class='option'>";
                                            echo "<input type='radio' id='option-{$id_kuesioner}' name='jawaban[{$id_kriteria}][{$pertanyaan}]' value='{$id_kuesioner}' required>";
                                            echo "<label for='option-{$id_kuesioner}'>{$opsi}</label>";
                                            echo "</div>";
                                        }
                                        echo "</div>";
                                    }

                                    echo "</div>";
                                    $question_num++;
                                    $counter++;
                                }
                            }

                            echo "</div>";
                        }
                    } else {
                        echo "<p>Tidak ada kuesioner yang tersedia.</p>";
                    }
                    ?>

                    <div class="form-group">
                        <button type="submit" class="submit-btn">Kirim Jawaban</button>
                    </div>
                </form>
            </div>
    </section>

    <style>
        .kuesioner-wrapper {
            max-width: 1800px;
            margin: 0 auto;
            height: 2000px;
            position: relative;
        }

        .kuesioner-container {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            overflow-y: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .kuesioner-container::-webkit-scrollbar {
            width: 8px;
        }

        .kuesioner-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .kuesioner-container::-webkit-scrollbar-thumb {
            background: #2E8B57;
            border-radius: 10px;
        }

        .kuesioner-container::-webkit-scrollbar-thumb:hover {
            background: #3aa76d;
        }

        .kriteria-section {
            margin-bottom: 30px;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .kriteria-title {
            color: #2E8B57;
            padding-bottom: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #2E8B57;
            font-size: 1.5rem;
        }

        .question-container {
            margin-bottom: 25px;
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .question-container:hover {
            transform: translateY(-5px);
        }

        .question {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 15px;
            color: #333;
        }

        .question-number {
            color: #2E8B57;
            font-weight: bold;
            margin-right: 8px;
        }

        .options-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 10px;
        }

        .option {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.2s ease;
        }

        .option:hover {
            background-color: #f0f0f0;
        }

        .option input[type="radio"] {
            margin-right: 10px;
            cursor: pointer;
        }

        .option label {
            cursor: pointer;
            font-size: 1rem;
            flex-grow: 1;
        }

        .form-group {
            margin-top: 30px;
            text-align: center;
        }

        .submit-btn {
            background-color: #2E8B57;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .submit-btn:hover {
            background-color: #3aa76d;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 992px) {
            .options-container {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }

            .kuesioner-wrapper {
                height: 500px;
            }
        }

        @media (max-width: 768px) {
            .kuesioner-container {
                padding: 15px;
            }

            .kriteria-section {
                padding: 15px;
            }

            .options-container {
                grid-template-columns: 1fr;
            }

            .question {
                font-size: 1rem;
            }

            .submit-btn {
                width: 100%;
                padding: 10px;
            }

            .kuesioner-wrapper {
                height: 450px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questionContainers = document.querySelectorAll('.question-container');

            const fadeInOptions = {
                threshold: 0.1,
                rootMargin: "0px 0px -100px 0px"
            };

            const fadeInObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = "1";
                        entry.target.style.transform = "translateY(0)";
                        observer.unobserve(entry.target);
                    }
                });
            }, fadeInOptions);

            questionContainers.forEach(container => {
                container.style.opacity = "0";
                container.style.transform = "translateY(20px)";
                container.style.transition = "opacity 0.5s ease, transform 0.5s ease";
                fadeInObserver.observe(container);
            });

            const form = document.getElementById('formKuesioner');

            form.addEventListener('submit', function(e) {
                let allQuestionsAnswered = true;
                const kriteriaSection = document.querySelectorAll('.kriteria-section');

                kriteriaSection.forEach(section => {
                    const questions = section.querySelectorAll('.question-container');

                    questions.forEach(question => {
                        const options = question.querySelectorAll('input[type="radio"]');
                        const questionText = question.querySelector('.question').textContent;
                        let questionAnswered = false;

                        options.forEach(option => {
                            if (option.checked) {
                                questionAnswered = true;
                            }
                        });

                        if (!questionAnswered) {
                            allQuestionsAnswered = false;
                            question.style.border = "2px solid #ff6b6b";
                            question.style.boxShadow = "0 0 10px rgba(255, 107, 107, 0.3)";
                        } else {
                            question.style.border = "none";
                            question.style.boxShadow = "0 2px 5px rgba(0, 0, 0, 0.05)";
                        }
                    });
                });

                if (!allQuestionsAnswered) {
                    e.preventDefault();
                    alert('Harap jawab semua pertanyaan sebelum mengirim.');
                    window.scrollTo({
                        top: document.querySelector('.question-container[style*="border"]').offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
    <section class="section-gradient">
        <div class="container-grd">
            <p class="head-grd fade-scroll">Temukan Destinasi Wisata Terbaik</p>
            <p class="desc-grd fade-scroll">
                Dapatkan rekomendasi wisata terbaik berdasarkan preferensi Anda. <br />
                Jelajahi keindahan alam, budaya, dan kuliner khas di berbagai destinasi menarik.
            </p>
            <hr class="line-sectiongrd fade-scroll" />
            <div class="contact-grd fade-scroll">
                <p>Kontak: 08123456789</p>
                <p>Email: info@wisataindonesia.com</p>
            </div>
        </div>
    </section>
    <section class="section-5">
        <img src="img/footer.jpg" alt="" class="home-img" />
    </section>
    <footer class="footer">
        <div class="container-footer fade-scroll">
            <a href="#">About</a>
            <a href="#">Events</a>
            <a href="#">FAQs</a>
        </div>
    </footer>
</body>
<script src="animation.js"></script>

</html>