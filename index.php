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
    <!-- Maps -->
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
    </style>

    <section id="section-2" class="section-2">
        <div class="container-section2">
            <p class="introduction-village fade-scroll">Introduction Berastagi Tourism</p>
            <hr class="line-section2 fade-scroll" />
            <div class="content-explore">
                <div id="berastagi-map"></div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var mapElement = document.getElementById('berastagi-map');
            if (!mapElement) {
                console.error("Element berastagi-map tidak ditemukan!");
                return;
            }

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

            var pois = [{
                    name: 'Danau Lau Kawar',
                    coords: [3.1987281849257063, 98.38038606462712],
                    desc: 'Danau vulkanik di kaki Gunung Sinabung'
                },
                {
                    name: 'Gunung Sibayak',
                    coords: [3.239604173791476, 98.50494489062044],
                    desc: 'Gunung berapi aktif dengan pemandangan kawah'
                },
                {
                    name: 'Air Terjun Sipiso-Piso',
                    coords: [2.916680165952653, 98.51947160811206],
                    desc: 'Air terjun setinggi 120 meter di tepi Danau Toba'
                },
                {
                    name: 'Bukit Gundaling',
                    coords: [3.1934533211743528, 98.50169647186767],
                    desc: 'Bukit dengan pemandangan Gunung Sibayak dan Sinabung'
                },
                {
                    name: 'Air Panas Lau Sidebuk-Debuk',
                    coords: [3.2240343338718325, 98.51406952345782],
                    desc: 'Sumber air panas alami di kaki Gunung Sibayak'
                }
            ];


            pois.forEach(function(poi) {
                L.marker(poi.coords).addTo(map)
                    .bindPopup('<b>' + poi.name + '</b><br>' + poi.desc);
            });

            setTimeout(function() {
                map.invalidateSize();
            }, 500);
        });
    </script>

    <section class="section-4">
        <div class="center">
            <p class="tour-packages fade-scroll">Rekomendasi Wisata</p>
        </div>
        
    </section>
    <section class="section-gradient">
        <div class="container-grd">
            <p class="head-grd fade-scroll">Your Exploration Starts Here</p>
            <p class="desc-grd fade-scroll">
                Lorem Ipsum is simply dummy text of the printing and typesetting <br />
                industry. Lorem Ipsum has been the industry's standard dummy <br />
                text ever since the 1500s
            </p>
            <hr class="line-sectiongrd fade-scroll" />
            <div class="contact-grd fade-scroll">
                <p>085603964739</p>
                <p>rizalhajakubastarus@gmail.com</p>
            </div>
        </div>
    </section>
    <section class="section-5">
        <img src="img/footer.jpg" alt="" class="home-img" />
    </section>
    <footer class="footer">
        <div class="container-footer fade-scroll">
            <a href="#">About Camp</a>
            <a href="#">Events</a>
            <a href="#">FAQs</a>
        </div>
    </footer>
</body>
<script src="animation.js"></script>

</html>