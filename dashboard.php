<?php include('template/header.php'); ?>

<body class="with-welcome-text">
  <div class="container-scroller">
    <?php include 'template/navbar.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include 'template/setting_panel.php'; ?>
      <?php include 'template/sidebar.php'; ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Selamat Datang di Sistem Pendukung Keputusan Destinasi Wisata</h3>
                  <h6 class="font-weight-normal mb-0">Temukan rekomendasi destinasi wisata terbaik di kawasan Berastagi berdasarkan preferensi Anda</h6>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card tale-bg">
                <div class="card-body">
                  <h4 class="card-title">Cuaca di Berastagi</h4>
                  <div class="weather-info mt-3" id="weather-container">
                    <div class="d-flex align-items-center">
                      <div class="weather-icon">
                        <i class="icon-refresh text-primary mr-2" style="font-size: 2em;"></i>
                      </div>
                      <div class="ml-3">
                        <h5 class="location font-weight-medium">Memuat data cuaca...</h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 grid-margin transparent">
              <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-tale">
                    <div class="card-body">
                      <p class="mb-4">Total Destinasi Wisata</p>
                      <?php
                      include 'koneksi.php';
                      $query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM alternatif");
                      $data = mysqli_fetch_assoc($query);
                      ?>
                      <p class="fs-30 mb-2"><?= $data['total'] ?></p>
                      <p>Objek Wisata Alam</p>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 mb-4 stretch-card transparent">
                  <div class="card card-dark-blue">
                    <div class="card-body">
                      <p class="mb-4">Total Kriteria</p>
                      <?php
                      $query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM kriteria");
                      $data = mysqli_fetch_assoc($query);
                      ?>
                      <p class="fs-30 mb-2"><?= $data['total'] ?></p>
                      <p>Parameter Penilaian</p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                  <div class="card card-light-blue">
                    <div class="card-body">
                      <p class="mb-4">Total Kuesioner</p>
                      <?php
                      $query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM kuesioner");
                      $data = mysqli_fetch_assoc($query);
                      ?>
                      <p class="fs-30 mb-2"><?= $data['total'] ?></p>
                      <p>Pertanyaan & Opsi</p>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 stretch-card transparent">
                  <div class="card card-light-danger">
                    <div class="card-body">
                      <p class="mb-4">Riwayat Rekomendasi</p>
                      <?php
                      $query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM riwayat_rekomendasi");
                      $data = mysqli_fetch_assoc($query);
                      ?>
                      <p class="fs-30 mb-2"><?= $data['total'] ?></p>
                      <p>Hasil Analisis</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Destinasi Wisata Populer</p>
                  <div class="row">
                    <div class="col-12">
                      <div class="table-responsive">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Nama Destinasi</th>
                              <th>Koordinat</th>
                              <th>Foto</th>
                              <th>Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM alternatif LIMIT 5");
                            if (mysqli_num_rows($query) > 0) {
                              $no = 1;
                              while ($data = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                  <td><?= $no ?></td>
                                  <td><?= $data['nama_wisata'] ?></td>
                                  <td><?= $data['koordinat'] ?></td>
                                  <td>
                                    <?php if (!empty($data['foto'])): ?>
                                      <img src="foto_wisata/<?= $data['foto'] ?>" alt="<?= $data['nama_wisata'] ?>" width="100">
                                    <?php else: ?>
                                      <span class="text-muted">Tidak ada foto</span>
                                    <?php endif; ?>
                                  </td>
                                  <td>
                                    <a href="<?= $data['url'] ?>" target="_blank" class="btn btn-sm btn-primary">Lihat Maps</a>
                                  </td>
                                </tr>
                              <?php
                                $no++;
                              }
                            } else {
                              ?>
                              <tr>
                                <td colspan="5" class="text-center">Tidak ada data destinasi wisata</td>
                              </tr>
                            <?php
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card position-relative">
                <div class="card-body">
                  <div id="detailedReports" class="carousel slide detailed-report-carousel position-static pt-2" data-ride="carousel">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <div class="row">
                          <div class="col-md-12 col-xl-12">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="table-responsive mb-3 mb-md-0">
                                  <h4 class="text-center mb-4">Kriteria Penilaian Destinasi Wisata</h4>
                                  <table class="table table-borderless report-table">
                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY id_kriteria ASC");
                                    while ($data = mysqli_fetch_array($query)) {
                                    
                                      $progressColor = ($data['jenis'] == 'benefit') ? 'bg-success' : 'bg-danger';
                                      
                                      $progressWidth = floatval($data['bobot']) * 100;
                                    ?>
                                      <tr>
                                        <td class="text-muted"><?= $data['id_kriteria'] ?></td>
                                        <td class="w-100 px-0">
                                          <div class="d-flex justify-content-between align-items-center mb-1">
                                            <div class="font-weight-medium"><?= $data['nama'] ?></div>
                                            <div class="font-weight-medium"><?= $data['bobot'] ?> (<?= $data['jenis'] ?>)</div>
                                          </div>
                                          <div class="progress progress-md">
                                            <div class="progress-bar <?= $progressColor ?>" role="progressbar" style="width: <?= $progressWidth ?>%" aria-valuenow="<?= $progressWidth ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                          </div>
                                        </td>
                                      </tr>
                                    <?php
                                    }
                                    ?>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <?php include 'template/script.php'; ?>
  <script>
    $(document).ready(function() {
      const lat = 3.186190728124692;
      const lon = 98.50504165992739;
      const apiKey = 'e871e0e8e8d671f5db6d62f46567c2cd';

      $.ajax({
        url: `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&units=metric&appid=${apiKey}&lang=id`,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          const timestamp = data.dt * 1000;
          const date = new Date(timestamp);
          const formattedDate = date.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
          });
          const formattedTime = date.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
          });

          const iconCode = data.weather[0].icon;
          const weatherDescription = data.weather[0].description;
          const capitalizedDescription = weatherDescription.charAt(0).toUpperCase() + weatherDescription.slice(1);
          const temp = Math.round(data.main.temp);
          const feelsLike = Math.round(data.main.feels_like);

          const humidity = data.main.humidity;

          const windSpeed = data.wind.speed;

          let weatherHTML = `
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="d-flex align-items-center">
                <img src="https://openweathermap.org/img/wn/${iconCode}@2x.png" alt="${weatherDescription}" class="mr-3" style="width: 70px; height: 70px;">
                <div>
                  <h2 class="mb-0 font-weight-bold">${temp}<sup>°C</sup></h2>
                  <p class="text-muted mb-0">Terasa seperti ${feelsLike}°C</p>
                </div>
                <div class="ps-4 ml-auto text-right">
                  <h4 class="location font-weight-medium">Berastagi</h4>
                  <h6 class="font-weight-normal text-muted">Sumatera Utara</h6>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card bg-gradient-light">
                <div class="card-body py-3">
                  <div class="row">
                    <div class="col-md-4 text-center">
                      <p class="mb-1 text-muted">Cuaca</p>
                      <h5>${capitalizedDescription}</h5>
                    </div>
                    <div class="col-md-4 text-center">
                      <p class="mb-1 text-muted">Kelembapan</p>
                      <h5>${humidity}%</h5>
                    </div>
                    <div class="col-md-4 text-center">
                      <p class="mb-1 text-muted">Angin</p>
                      <h5>${windSpeed} m/s</h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-12 text-right">
              <small class="text-muted">Update terakhir: ${formattedDate} ${formattedTime}</small>
            </div>
          </div>
        `;

          $('#weather-container').html(weatherHTML);
        },
        error: function(error) {
          console.error('Error fetching weather data:', error);
          let errorHTML = `
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="d-flex align-items-center">
                <div class="weather-icon mr-3">
                  <i class="icon-sun text-warning" style="font-size: 3em;"></i>
                </div>
                <div>
                  <h2 class="mb-0 font-weight-bold">18-25<sup>°C</sup></h2>
                  <p class="text-muted mb-0">Suhu rata-rata</p>
                </div>
                <div class="ml-auto text-right">
                  <h4 class="location font-weight-medium">Berastagi</h4>
                  <h6 class="font-weight-normal text-muted">Sumatera Utara</h6>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card bg-gradient-light">
                <div class="card-body py-3">
                  <div class="row">
                    <div class="col-md-4 text-center">
                      <p class="mb-1 text-muted">Ketinggian</p>
                      <h5>1.300-1.400 mdpl</h5>
                    </div>
                    <div class="col-md-4 text-center">
                      <p class="mb-1 text-muted">Iklim</p>
                      <h5>Sejuk</h5>
                    </div>
                    <div class="col-md-4 text-center">
                      <p class="mb-1 text-muted">Musim Terbaik</p>
                      <h5>Mei-September</h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-12">
              <p class="text-muted">Data cuaca aktual tidak dapat dimuat. Silakan refresh halaman untuk mencoba kembali.</p>
            </div>
          </div>
        `;

          $('#weather-container').html(errorHTML);
        }
      });
    });
  </script>
</body>

</html>