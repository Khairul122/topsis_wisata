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
            <div class="col-sm-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Riwayat Rekomendasi</h4>
                  <p class="card-description">
                    Daftar riwayat rekomendasi wisata
                  </p>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama User</th>
                          <th>Tanggal</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        include 'koneksi.php';
                        $query = mysqli_query($koneksi, "SELECT * FROM riwayat_rekomendasi ORDER BY tanggal DESC");
                        if (mysqli_num_rows($query) > 0) {
                          $no = 1;
                          while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                              <td><?= $no ?></td>
                              <td><?= $data['nama_user'] ?></td>
                              <td><?= date('d-m-Y H:i', strtotime($data['tanggal'])) ?></td>
                              <td>
                                <button type="button" class="btn btn-primary btn-sm detail-btn"
                                  data-id="<?= $data['id_riwayat'] ?>">
                                  Detail
                                </button>
                              </td>
                            </tr>
                          <?php
                            $no++;
                          }
                        } else {
                          ?>
                          <tr>
                            <td colspan="4" class="text-center">Tidak ada data</td>
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

        <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Rekomendasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-6">
                    <p><strong>Nama User:</strong> <span id="modal-nama"></span></p>
                    <p><strong>Tanggal:</strong> <span id="modal-tanggal"></span></p>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <h5>Hasil Rekomendasi</h5>
                      <button type="button" class="btn btn-info btn-sm" id="lihat-kuesioner-btn">
                        Lihat Kuesioner
                      </button>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Nama Wisata</th>
                            <th>Nilai</th>
                            <th>Peringkat</th>
                          </tr>
                        </thead>
                        <tbody id="rekomendasi-body">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <div class="row mt-4" id="kuesioner-section" style="display: none;">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 id="kuesioner-title">Detail Kuesioner</h5>
                        <button type="button" class="btn btn-sm btn-secondary" id="tutup-kuesioner-btn">Tutup</button>
                      </div>
                      <div class="card-body">
                        <div style="max-height: 400px; overflow-y: auto;">
                          <div id="kuesioner-content">
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
      var responseData = null;
      var selectedAlternatifId = null;

      $('.detail-btn').on('click', function() {
        var id = $(this).data('id');

        $('#kuesioner-section').hide();
        $('#kuesioner-content').html('');

        $('#rekomendasi-body').html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');
        $('#detailModal').modal('show');

        $.ajax({
          url: 'get_rekomendasi_detail.php',
          type: 'GET',
          data: {
            id: id
          },
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              responseData = response.data;

              $('#modal-nama').text(response.data.nama_user);
              $('#modal-tanggal').text(response.data.tanggal);

              var rekomendasiData = response.data.rekomendasi;
              var tableBody = '';

              rekomendasiData.sort(function(a, b) {
                return b.nilai - a.nilai;
              });

              $.each(rekomendasiData, function(index, item) {
                tableBody += '<tr class="rekomendasi-row" data-id="' + item.id_alternatif + '">';
                tableBody += '<td>' + (index + 1) + '</td>';
                tableBody += '<td>' + item.nama_wisata + '</td>';
                tableBody += '<td>' + (item.nilai * 100).toFixed(2) + '%</td>';
                tableBody += '<td>' + (index + 1) + '</td>';
                tableBody += '</tr>';
              });

              $('#rekomendasi-body').html(tableBody);

              if (rekomendasiData.length > 0) {
                selectedAlternatifId = rekomendasiData[0].id_alternatif;
              }

              $('.rekomendasi-row').on('click', function() {
                $('.rekomendasi-row').removeClass('table-primary');
                $(this).addClass('table-primary');
                selectedAlternatifId = $(this).data('id');
              });

              $('.rekomendasi-row:first').addClass('table-primary');
            } else {
              $('#rekomendasi-body').html('<tr><td colspan="4" class="text-center">Error: ' + response.message + '</td></tr>');
            }
          },
          error: function(xhr, status, error) {
            $('#rekomendasi-body').html('<tr><td colspan="4" class="text-center">Error: Could not load data</td></tr>');
            console.error("AJAX error: " + status + " - " + error);
          }
        });
      });

      $('#lihat-kuesioner-btn').on('click', function() {
        if (selectedAlternatifId) {
          showKuesioner(selectedAlternatifId);
        } else {
          alert('Pilih destinasi wisata terlebih dahulu');
        }
      });

      $('#tutup-kuesioner-btn').on('click', function() {
        $('#kuesioner-section').hide();
      });

      function showKuesioner(alternatifId) {
        if (responseData && responseData.kuesioner_data && responseData.kuesioner_data[alternatifId]) {
          var namaWisata = '';
          $.each(responseData.rekomendasi, function(index, item) {
            if (item.id_alternatif == alternatifId) {
              namaWisata = item.nama_wisata;
              return false; 
            }
          });

          $('#kuesioner-section').show();
          $('#kuesioner-title').text('Detail Kuesioner: ');

          var kuesionerData = responseData.kuesioner_data[alternatifId];
          var content = '';

          $.each(kuesionerData, function(index, item) {
            content += '<div class="mb-4">';
            content += '<h6 class="font-weight-bold">' + item.kriteria_nama + ' (' + item.kriteria_id + ')</h6>';
            content += '<p>Nilai: <span class="badge badge-info">' + item.nilai + '</span></p>';

            if (item.kuesioner && item.kuesioner.length > 0) {
              content += '<div class="ml-3">';
              $.each(item.kuesioner, function(kIdx, kItem) {
                content += '<div class="mb-3">';
                content += '<p><strong>Pertanyaan:</strong> ' + kItem.pertanyaan + '</p>';
                content += '<p><strong>Opsi Jawaban:</strong> ' + kItem.opsi_jawaban + '</p>';
                content += '<p><strong>Bobot:</strong> ' + kItem.bobot + '</p>';
                content += '</div>';

                if (kIdx < item.kuesioner.length - 1) {
                  content += '<hr class="my-2">';
                }
              });
              content += '</div>';
            } else {
              content += '<p class="text-muted">Tidak ada data kuesioner</p>';
            }

            content += '</div>';

            if (index < kuesionerData.length - 1) {
              content += '<hr class="my-4">';
            }
          });

          $('#kuesioner-content').html(content);
        } else {
          $('#kuesioner-title').text('Detail Kuesioner');
          $('#kuesioner-content').html('<p class="text-center">Data kuesioner tidak tersedia.</p>');
          $('#kuesioner-section').show();
        }
      }
    });
  </script>

  <style>
    div[style*="overflow-y: auto"] {
      scrollbar-width: thin;
      scrollbar-color: #6777ef #f1f1f1;
    }

    div[style*="overflow-y: auto"]::-webkit-scrollbar {
      width: 8px;
    }

    div[style*="overflow-y: auto"]::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }

    div[style*="overflow-y: auto"]::-webkit-scrollbar-thumb {
      background: #6777ef;
      border-radius: 10px;
    }

    div[style*="overflow-y: auto"]::-webkit-scrollbar-thumb:hover {
      background: #555;
    }

    .modal-lg {
      max-width: 900px;
    }

    #kuesioner-content {
      padding: 10px;
    }

    .rekomendasi-row {
      cursor: pointer;
    }

    .table-primary {
      background-color: rgba(103, 119, 239, 0.2) !important;
    }
  </style>
</body>

</html>