<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Berastagi tourism</title>
    <link rel="icon" href="img/kominfo logo.png" type="image/x-icon" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Rubik:ital@0;1&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            overflow-x: hidden;
            background-color: #f9f9f9;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .section-1 {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 1.5rem;
            display: flex;
            justify-content: flex-end;
            gap: 2rem;
            z-index: 100;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), transparent);
            transition: all 0.3s ease;
        }

        .header.scrolled {
            background: rgba(46, 139, 87, 0.9);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header a {
            color: white;
            font-weight: 500;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .header a:hover {
            opacity: 0.8;
        }

        .header a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: white;
            transition: width 0.3s ease;
        }

        .header a:hover::after {
            width: 100%;
        }

        .mobile-menu-toggle {
            display: none;
            position: fixed;
            right: 1.5rem;
            top: 1.5rem;
            z-index: 101;
            background: transparent;
            border: none;
            cursor: pointer;
        }

        .mobile-menu-toggle span {
            display: block;
            width: 30px;
            height: 3px;
            margin: 6px 0;
            background-color: white;
            transition: all 0.3s ease;
        }

        .home-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            filter: brightness(0.8);
        }

        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            z-index: 1;
            width: 90%;
            max-width: 800px;
        }

        .welcome {
            font-size: 2rem;
            margin-bottom: 2rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        .home-pulesari {
            font-size: 3.8rem;
            font-weight: bold;
            margin-top: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            letter-spacing: 1px;
        }

        .explore-button {
            display: inline-block;
            background-color: #2E8B57;
            color: white;
            padding: 0.9rem 2.2rem;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-top: 2.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            letter-spacing: 1px;
        }

        .explore-button:hover {
            background-color: #3aa76d;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .section-2 {
            padding: 6rem 1rem;
            background-color: white;
        }

        .container-section2 {
            max-width: 1200px;
            margin: 0 auto;
        }

        .introduction-village {
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            color: #2E8B57;
            margin-bottom: 1rem;
        }

        .line-section2 {
            width: 100px;
            height: 3px;
            background-color: #2E8B57;
            border: none;
            margin: 0 auto 3rem;
        }

        #berastagi-map {
            width: 100%;
            height: 500px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(46, 139, 87, 0.2);
        }

        .section-4 {
            padding: 6rem 1rem;
            background-color: #f8f9fa;
            position: relative;
        }

        .section-4::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('img/pattern.png');
            background-size: 200px;
            opacity: 0.03;
            pointer-events: none;
        }

        .center {
            text-align: center;
            margin-bottom: 3rem;
        }

        .tour-packages {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2E8B57;
        }

        .kuesioner-wrapper {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
        }

        .kuesioner-container {
            position: relative;
            width: 100%;
            padding: 2.5rem;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .kuesioner-container:hover {
            transform: translateY(-5px);
        }

        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            width: 150px;
            font-weight: 600;
            color: #2E8B57;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .form-control {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid #eaeaea;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f9f9f9;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%232E8B57' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 20px;
        }

        .form-control:focus {
            outline: none;
            border-color: #2E8B57;
            box-shadow: 0 0 0 3px rgba(46, 139, 87, 0.25);
            background-color: white;
        }

        .form-control option {
            padding: 10px;
        }

        .submit-btn {
            background-color: #2E8B57;
            color: white;
            border: none;
            padding: 14px 30px;
            font-size: 1.1rem;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: block;
            width: 100%;
            margin-top: 2rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .submit-btn:hover {
            background-color: #3aa76d;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .section-gradient {
            background: linear-gradient(135deg, #2E8B57, #1a5632);
            padding: 6rem 1rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .section-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('img/pattern.png');
            background-size: 200px;
            opacity: 0.05;
            pointer-events: none;
        }

        .container-grd {
            max-width: 1000px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .head-grd {
            font-size: 2.8rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }

        .desc-grd {
            font-size: 1.2rem;
            line-height: 1.8;
            margin-bottom: 2.5rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .line-sectiongrd {
            width: 100px;
            height: 3px;
            background-color: white;
            border: none;
            margin: 0 auto 2.5rem;
        }

        .contact-grd {
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .contact-grd p {
            margin-bottom: 0.5rem;
        }

        .footer {
            background-color: #1a1a1a;
            padding: 2.5rem 1rem;
            color: white;
        }

        .container-footer {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            gap: 3rem;
        }

        .container-footer a {
            transition: color 0.3s ease;
            font-size: 1.1rem;
            position: relative;
        }

        .container-footer a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: #2E8B57;
            transition: width 0.3s ease;
        }

        .container-footer a:hover {
            color: #2E8B57;
        }

        .container-footer a:hover::after {
            width: 100%;
        }

        .fade-in {
            opacity: 0;
            animation: fadeIn 1s forwards;
        }

        .fade-out {
            opacity: 0;
            animation: fadeOut 1s forwards;
        }

        .fade-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @media screen and (max-width: 1200px) {
            #berastagi-map {
                height: 450px;
            }
        }

        @media screen and (max-width: 992px) {
            .header {
                padding: 1rem;
                gap: 1.5rem;
            }

            .home-pulesari {
                font-size: 3rem;
            }

            .welcome {
                font-size: 1.8rem;
            }

            .introduction-village,
            .tour-packages,
            .head-grd {
                font-size: 2.2rem;
            }

            #berastagi-map {
                height: 400px;
            }
        }

        @media screen and (max-width: 768px) {
            .header {
                display: none;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100vh;
                background-color: rgba(46, 139, 87, 0.95);
                gap: 2rem;
            }

            .header.active {
                display: flex;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .mobile-menu-toggle.active span:nth-child(1) {
                transform: rotate(-45deg) translate(-5px, 6px);
            }

            .mobile-menu-toggle.active span:nth-child(2) {
                opacity: 0;
            }

            .mobile-menu-toggle.active span:nth-child(3) {
                transform: rotate(45deg) translate(-5px, -6px);
            }

            .home-pulesari {
                font-size: 2.5rem;
            }

            .welcome {
                font-size: 1.5rem;
            }

            .introduction-village,
            .tour-packages,
            .head-grd {
                font-size: 2rem;
            }

            .kuesioner-container {
                padding: 1.5rem;
            }

            .form-group {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-group label {
                margin-bottom: 0.8rem;
                width: 100%;
            }

            .form-control {
                width: 100%;
            }

            #berastagi-map {
                height: 350px;
            }

            .container-footer {
                flex-direction: column;
                align-items: center;
                gap: 1.5rem;
            }
        }

        @media screen and (max-width: 576px) {
            .home-pulesari {
                font-size: 2rem;
            }

            .welcome {
                font-size: 1.3rem;
            }

            .introduction-village,
            .tour-packages,
            .head-grd {
                font-size: 1.8rem;
            }

            .desc-grd {
                font-size: 1rem;
            }

            #berastagi-map {
                height: 300px;
            }

            .kuesioner-container {
                padding: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <section class="section-1">
        <header class="header fade-in">
            <a href="#section-2">Home</a>
            <a href="#section-4">Rekomendasi Wisata</a>
            <a href="login.php">Login</a>
        </header>
        <button class="mobile-menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <img src="img/mount-batur.jpg" alt="" class="home-img" />
        <div class="content">
            <div class="welcome fade-out">
                <p>Welcome to</p>
                <p class="home-pulesari fade-out">Berastagi Tourism</p>
            </div>

            <a href="#section-3" class="explore-button fade-scroll">Explore</a>
        </div>
    </section>

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

    <section class="section-4" id="section-4">
        <div class="center">
            <p class="tour-packages fade-scroll">Cari Wisata Rekomendasi</p>
        </div>

        <div class="kuesioner-wrapper">
            <div class="kuesioner-container">
                <form action="crud/proses-kuesioner.php" method="post" id="formKuesioner">
                    <?php
                    include 'koneksi.php';

                    $sql_kriteria = "SELECT DISTINCT k.id_kriteria, kr.nama 
                        FROM kuesioner k 
                        INNER JOIN kriteria kr ON k.id_kriteria = kr.id_kriteria 
                        ORDER BY k.id_kriteria ASC";
                    $result_kriteria = $koneksi->query($sql_kriteria);

                    function getUniqueOptionsForKriteria($koneksi, $id_kriteria)
                    {
                        $sql = "SELECT DISTINCT opsi_jawaban_pertanyaan, bobot_opsi_jawaban_pertanyaan 
                            FROM kuesioner 
                            WHERE id_kriteria = '$id_kriteria'
                            ORDER BY bobot_opsi_jawaban_pertanyaan DESC";
                        return $koneksi->query($sql);
                    }

                    if ($result_kriteria->num_rows > 0) {
                        while ($row_kriteria = $result_kriteria->fetch_assoc()) {
                            $id_kriteria = $row_kriteria['id_kriteria'];
                            $nama_kriteria = $row_kriteria['nama'];

                            echo "<div class='form-group'>";
                            echo "<label for='kriteria-{$id_kriteria}'>{$nama_kriteria}</label>";
                            echo "<select name='jawaban[{$id_kriteria}]' id='kriteria-{$id_kriteria}' class='form-control'>";

                            $result_opsi = getUniqueOptionsForKriteria($koneksi, $id_kriteria);
                            if ($result_opsi->num_rows > 0) {
                                // Default option
                                $default_value = "";
                                if ($id_kriteria == 'K001') $default_value = "Pilih";
                                else if ($id_kriteria == 'K004') $default_value = "Pilih";
                                else if (in_array($id_kriteria, ['K005', 'K006'])) $default_value = "Pilih";
                                else if (in_array($id_kriteria, ['K002', 'K003'])) $default_value = "Pilih";
                                else $default_value = "Menarik";

                                echo "<option value=''>{$default_value}</option>";

                                while ($row_opsi = $result_opsi->fetch_assoc()) {
                                    $opsi = $row_opsi['opsi_jawaban_pertanyaan'];
                                    $bobot = $row_opsi['bobot_opsi_jawaban_pertanyaan'];
                                    echo "<option value='{$bobot}'>{$opsi}</option>";
                                }
                            }

                            echo "</select>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Tidak ada kriteria yang tersedia.</p>";
                    }
                    ?>

                    <div class="form-group">
                        <button type="submit" class="submit-btn cari-btn">CARI</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

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

    <footer class="footer">
        <div class="container-footer fade-scroll">
            <a href="#">About</a>
            <a href="#">Events</a>
            <a href="#">FAQs</a>
        </div>
    </footer>

    <script>
        // Mobile menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
            const header = document.querySelector('.header');

            mobileMenuToggle.addEventListener('click', function() {
                this.classList.toggle('active');
                header.classList.toggle('active');
            });

            // Close menu when clicking a link
            const headerLinks = document.querySelectorAll('.header a');
            headerLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenuToggle.classList.remove('active');
                    header.classList.remove('active');
                });
            });

            // Scroll animation
            const fadeElements = document.querySelectorAll('.fade-scroll');
            const fadeOptions = {
                threshold: 0.1,
                rootMargin: "0px 0px -50px 0px"
            };

            const fadeObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = "1";
                        entry.target.style.transform = "translateY(0)";
                        observer.unobserve(entry.target);
                    }
                });
            }, fadeOptions);

            fadeElements.forEach(element => {
                fadeObserver.observe(element);
            });

            // Question animation
            const questionContainers = document.querySelectorAll('.question-container');
            questionContainers.forEach(container => {
                container.style.opacity = "0";
                container.style.transform = "translateY(20px)";
                container.style.transition = "opacity 0.5s ease, transform 0.5s ease";
                fadeObserver.observe(container);
            });

            // Form validation
            const form = document.getElementById('formKuesioner');
            if (form) {
                form.addEventListener('submit', function(e) {
                    let allQuestionsAnswered = true;
                    const kriteriaSection = document.querySelectorAll('.kriteria-section');

                    kriteriaSection.forEach(section => {
                        const questions = section.querySelectorAll('.question-container');

                        questions.forEach(question => {
                            const options = question.querySelectorAll('input[type="radio"]');
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
            }
        });

        // Map initialization
        window.onload = function() {
            var mapElement = document.getElementById('berastagi-map');
            if (!mapElement) {
                console.error("Element berastagi-map tidak ditemukan!");
                return;
            }

            var berastagiCoords = [3.1944, 98.5078];
            var map = L.map('berastagi-map').setView(berastagiCoords, 11);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19
            }).addTo(map);

            L.marker(berastagiCoords).addTo(map)
                .bindPopup('<b>Berastagi</b><br>Karo, North Sumatra, Indonesia.')
                .openPopup();

            // Get data from PHP
            var poisData = <?php echo $map_json; ?>;

            if (poisData && poisData.length) {
                poisData.forEach(function(poi) {
                    if (poi.koordinat) {
                        var coords = poi.koordinat.split(',').map(function(item) {
                            return parseFloat(item.trim());
                        });

                        if (coords.length === 2 && !isNaN(coords[0]) && !isNaN(coords[1])) {
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
                        }
                    }
                });
            }

            // Resize the map when it becomes visible
            setTimeout(function() {
                map.invalidateSize();
            }, 500);

            // Resize the map when window is resized
            window.addEventListener('resize', function() {
                map.invalidateSize();
            });
        };
    </script>
</body>

</html>