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
              <?php
              $notif = isset($_SESSION['status']) ? $_SESSION['status'] : null;
              unset($_SESSION['status']);
              if ($notif): ?>
                <div class="alert alert-dismissible fade show 
    <?php echo ($notif == 'success-add' || $notif == 'success-edit' || $notif == 'success-delete') ? 'alert-success' : 'alert-danger'; ?>"
                  role="alert">
                  <?php
                  switch ($notif) {
                    case 'success-add':
                      echo "Data berhasil ditambahkan!";
                      break;
                    case 'success-edit':
                      echo "Data berhasil diperbarui!";
                      break;
                    case 'success-delete':
                      echo "Data berhasil dihapus!";
                      break;
                    case 'error-add':
                      echo "Gagal menambahkan data!";
                      break;
                    case 'error-edit':
                      echo "Gagal memperbarui data!";
                      break;
                    case 'error-delete':
                      echo "Gagal menghapus data!";
                      break;
                  }
                  ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>

                <script>
                  setTimeout(function() {
                    let alertBox = document.querySelector('.alert');
                    if (alertBox) {
                      alertBox.classList.add('fade');
                      setTimeout(function() {
                        alertBox.remove();
                      }, 500);
                    }
                  }, 3000);
                </script>
              <?php endif; ?>
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
                                  data-id="<?= $data['id_riwayat'] ?>"
                                  data-user="<?= $data['nama_user'] ?>"
                                  data-date="<?= date('Y-m-d', strtotime($data['tanggal'])) ?>">
                                  <i class="mdi mdi-eye"></i> Detail
                                </button>
                                <a href="crud/hapus-rekomendasi.php?id=<?= $data['id_riwayat'] ?>"
                                  class="btn btn-danger btn-sm hapus-btn"
                                  onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                  <i class="mdi mdi-delete"></i> Hapus
                                </a>
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
                      <div>
                        <button type="button" class="btn btn-info btn-sm me-2" id="lihat-kuesioner-btn">
                          Lihat Kuesioner
                        </button>
                        <button type="button" class="btn btn-primary btn-sm" id="lihat-perhitungan-btn">
                          Lihat Perhitungan
                        </button>
                      </div>
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

                <div class="row mt-4" id="perhitungan-section" style="display: none;">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 id="perhitungan-title">Detail Perhitungan TOPSIS</h5>
                        <button type="button" class="btn btn-sm btn-secondary" id="tutup-perhitungan-btn">Tutup</button>
                      </div>
                      <div class="card-body">
                        <div style="max-height: 500px; overflow-y: auto;">
                          <div id="perhitungan-content">
                            <div class="text-center">
                              <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                              </div>
                              <p class="mt-2">Memuat data perhitungan...</p>
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
      var responseData = null;
      var selectedAlternatifId = null;
      var currentUser = null;
      var currentDate = null;

      $('.detail-btn').on('click', function() {
        var id = $(this).data('id');
        currentUser = $(this).data('user');
        currentDate = $(this).data('date');

        $('#kuesioner-section').hide();
        $('#perhitungan-section').hide();
        $('#kuesioner-content').html('');
        $('#perhitungan-content').html('<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Memuat data perhitungan...</p></div>');

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
          $('#perhitungan-section').hide();
          showKuesioner(selectedAlternatifId);
        } else {
          alert('Pilih destinasi wisata terlebih dahulu');
        }
      });

      $('#tutup-kuesioner-btn').on('click', function() {
        $('#kuesioner-section').hide();
      });

      $('#lihat-perhitungan-btn').on('click', function() {
        $('#kuesioner-section').hide();
        $('#perhitungan-section').show();

        if (currentUser) {
          loadTopsisCalculation(currentUser, currentDate);
        } else {
          $('#perhitungan-content').html('<p class="text-center text-danger">Tidak dapat memuat data perhitungan: Nama user tidak tersedia.</p>');
        }
      });

      $('#tutup-perhitungan-btn').on('click', function() {
        $('#perhitungan-section').hide();
      });

      function loadTopsisCalculation(username, date) {
        $('#perhitungan-content').html('<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Memuat data perhitungan...</p></div>');

        var requestData = {
          user: username
        };

        if (date) {
          requestData.date = date;
        }

        $.ajax({
          url: 'get_topsis_calculation.php',
          type: 'GET',
          data: requestData,
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              displayTopsisCalculation(response.data);
            } else {
              $('#perhitungan-content').html('<p class="text-center text-danger">Error: ' + response.message + '</p>');
            }
          },
          error: function(xhr, status, error) {
            var errorMsg = xhr.responseText || 'Tidak dapat memuat data perhitungan';

            if (errorMsg.length > 300) {
              errorMsg = errorMsg.substring(0, 300) + '...';
            }

            $('#perhitungan-content').html('<div class="text-center text-danger">' +
              '<p>Error: Tidak dapat memuat data perhitungan</p>' +
              '<p>Detail: ' + error + '</p>' +
              '<div class="alert alert-danger mt-2"><small>' + errorMsg + '</small></div>' +
              '</div>');

            console.error("AJAX error:", error);
            console.error("Response:", xhr.responseText);
          }
        });
      }

      function displayTopsisCalculation(data) {
        var content = '';

        if (!data) {
          $('#perhitungan-content').html('<p class="text-center text-danger">Data perhitungan tidak tersedia</p>');
          return;
        }

        content += '<div class="mb-4">';
        content += '<h6>Waktu Perhitungan: ' + (data.timestamp || 'Tidak tersedia') + '</h6>';
        content += '</div>';

        content += '<div class="mb-4">';
        content += '<h6 class="font-weight-bold mb-3">Alternatif Wisata</h6>';
        content += '<div class="table-responsive">';
        content += '<table class="table table-sm table-bordered">';
        content += '<thead><tr><th>ID</th><th>Nama Wisata</th></tr></thead>';
        content += '<tbody>';

        if (data.alternatif && data.alternatif.length > 0) {
          $.each(data.alternatif, function(index, item) {
            content += '<tr>';
            content += '<td>' + item.id + '</td>';
            content += '<td>' + item.nama + '</td>';
            content += '</tr>';
          });
        } else {
          content += '<tr><td colspan="2" class="text-center">Tidak ada data alternatif</td></tr>';
        }

        content += '</tbody></table></div></div>';

        content += '<div class="mb-4">';
        content += '<h6 class="font-weight-bold mb-3">Kriteria</h6>';
        content += '<div class="table-responsive">';
        content += '<table class="table table-sm table-bordered">';
        content += '<thead><tr><th>ID</th><th>Nama Kriteria</th><th>Bobot</th><th>Jenis</th></tr></thead>';
        content += '<tbody>';

        if (data.kriteria && data.kriteria.length > 0) {
          $.each(data.kriteria, function(index, item) {
            content += '<tr>';
            content += '<td>' + item.id + '</td>';
            content += '<td>' + item.nama + '</td>';
            content += '<td>' + item.bobot + '</td>';
            content += '<td><span class="badge badge-' + (item.jenis === 'benefit' ? 'success' : 'danger') + '">' + item.jenis + '</span></td>';
            content += '</tr>';
          });
        } else {
          content += '<tr><td colspan="4" class="text-center">Tidak ada data kriteria</td></tr>';
        }

        content += '</tbody></table></div></div>';

        content += '<div class="mb-4">';
        content += '<h6 class="font-weight-bold mb-3">Nilai Kriteria dari Jawaban User</h6>';
        content += '<div class="table-responsive">';
        content += '<table class="table table-sm table-bordered">';
        content += '<thead><tr><th>ID</th><th>Nama Kriteria</th><th>Nilai</th></tr></thead>';
        content += '<tbody>';

        if (data.nilai_kriteria && data.nilai_kriteria.length > 0) {
          $.each(data.nilai_kriteria, function(index, item) {
            content += '<tr>';
            content += '<td>' + item.id + '</td>';
            content += '<td>' + item.nama + '</td>';
            content += '<td>' + item.nilai + '</td>';
            content += '</tr>';
          });
        } else {
          content += '<tr><td colspan="3" class="text-center">Tidak ada data nilai kriteria</td></tr>';
        }

        content += '</tbody></table></div></div>';

        content += '<div class="mb-4">';
        content += '<h6 class="font-weight-bold mb-3">Matrix Keputusan Awal</h6>';
        content += '<div class="table-responsive">';
        content += '<table class="table table-sm table-bordered">';
        content += '<thead><tr><th>ID Alternatif</th>';

        if (data.kriteria && data.kriteria.length > 0) {
          $.each(data.kriteria, function(index, item) {
            content += '<th>' + item.id + '</th>';
          });
        }

        content += '</tr></thead><tbody>';

        if (data.matrix_keputusan && data.matrix_keputusan.length > 0) {
          $.each(data.matrix_keputusan, function(index, item) {
            content += '<tr>';
            content += '<td>' + item.id_alternatif + '</td>';

            $.each(item.nilai, function(kriteria_id, nilai) {
              content += '<td>' + nilai.toFixed(4) + '</td>';
            });

            content += '</tr>';
          });
        } else {
          content += '<tr><td colspan="' + (data.kriteria ? data.kriteria.length + 1 : 2) + '" class="text-center">Tidak ada data matrix keputusan</td></tr>';
        }

        content += '</tbody></table></div></div>';

        content += '<div class="mb-4">';
        content += '<h6 class="font-weight-bold mb-3">Matrix Ternormalisasi</h6>';
        content += '<div class="table-responsive">';
        content += '<table class="table table-sm table-bordered">';
        content += '<thead><tr><th>ID Alternatif</th>';

        if (data.kriteria && data.kriteria.length > 0) {
          $.each(data.kriteria, function(index, item) {
            content += '<th>' + item.id + '</th>';
          });
        }

        content += '</tr></thead><tbody>';

        if (data.matrix_ternormalisasi && data.matrix_ternormalisasi.length > 0) {
          $.each(data.matrix_ternormalisasi, function(index, item) {
            content += '<tr>';
            content += '<td>' + item.id_alternatif + '</td>';

            $.each(item.nilai, function(kriteria_id, nilai) {
              content += '<td>' + nilai.toFixed(4) + '</td>';
            });

            content += '</tr>';
          });
        } else {
          content += '<tr><td colspan="' + (data.kriteria ? data.kriteria.length + 1 : 2) + '" class="text-center">Tidak ada data matrix ternormalisasi</td></tr>';
        }

        content += '</tbody></table></div></div>';

        content += '<div class="mb-4">';
        content += '<h6 class="font-weight-bold mb-3">Matrix Ternormalisasi Berbobot</h6>';
        content += '<div class="table-responsive">';
        content += '<table class="table table-sm table-bordered">';
        content += '<thead><tr><th>ID Alternatif</th>';

        if (data.kriteria && data.kriteria.length > 0) {
          $.each(data.kriteria, function(index, item) {
            content += '<th>' + item.id + '</th>';
          });
        }

        content += '</tr></thead><tbody>';

        if (data.matrix_ternormalisasi_berbobot && data.matrix_ternormalisasi_berbobot.length > 0) {
          $.each(data.matrix_ternormalisasi_berbobot, function(index, item) {
            content += '<tr>';
            content += '<td>' + item.id_alternatif + '</td>';

            $.each(item.nilai, function(kriteria_id, nilai) {
              content += '<td>' + nilai.toFixed(4) + '</td>';
            });

            content += '</tr>';
          });
        } else {
          content += '<tr><td colspan="' + (data.kriteria ? data.kriteria.length + 1 : 2) + '" class="text-center">Tidak ada data matrix ternormalisasi berbobot</td></tr>';
        }

        content += '</tbody></table></div></div>';

        content += '<div class="mb-4">';
        content += '<h6 class="font-weight-bold mb-3">Solusi Ideal</h6>';
        content += '<div class="table-responsive">';
        content += '<table class="table table-sm table-bordered">';
        content += '<thead><tr><th>Tipe</th>';

        if (data.kriteria && data.kriteria.length > 0) {
          $.each(data.kriteria, function(index, item) {
            content += '<th>' + item.id + '</th>';
          });
        }

        content += '</tr></thead><tbody>';

        if (data.solusi_ideal) {
          if (data.solusi_ideal.positif) {
            content += '<tr>';
            content += '<td>Positif</td>';

            $.each(data.solusi_ideal.positif, function(kriteria_id, nilai) {
              content += '<td>' + nilai.toFixed(4) + '</td>';
            });

            content += '</tr>';
          }

          if (data.solusi_ideal.negatif) {
            content += '<tr>';
            content += '<td>Negatif</td>';

            $.each(data.solusi_ideal.negatif, function(kriteria_id, nilai) {
              content += '<td>' + nilai.toFixed(4) + '</td>';
            });

            content += '</tr>';
          }
        } else {
          content += '<tr><td colspan="' + (data.kriteria ? data.kriteria.length + 1 : 2) + '" class="text-center">Tidak ada data solusi ideal</td></tr>';
        }

        content += '</tbody></table></div></div>';

        content += '<div class="mb-4">';
        content += '<h6 class="font-weight-bold mb-3">Jarak ke Solusi Ideal</h6>';
        content += '<div class="table-responsive">';
        content += '<table class="table table-sm table-bordered">';
        content += '<thead><tr><th>ID Alternatif</th><th>Jarak ke Positif</th><th>Jarak ke Negatif</th></tr></thead>';
        content += '<tbody>';

        if (data.jarak_solusi_ideal && data.jarak_solusi_ideal.length > 0) {
          $.each(data.jarak_solusi_ideal, function(index, item) {
            content += '<tr>';
            content += '<td>' + item.id_alternatif + '</td>';
            content += '<td>' + item.jarak_positif.toFixed(4) + '</td>';
            content += '<td>' + item.jarak_negatif.toFixed(4) + '</td>';
            content += '</tr>';
          });
        } else {
          content += '<tr><td colspan="3" class="text-center">Tidak ada data jarak solusi ideal</td></tr>';
        }

        content += '</tbody></table></div></div>';

        content += '<div class="mb-4">';
        content += '<h6 class="font-weight-bold mb-3">Nilai Preferensi</h6>';
        content += '<div class="table-responsive">';
        content += '<table class="table table-sm table-bordered">';
        content += '<thead><tr><th>ID Alternatif</th><th>Nama Wisata</th><th>Nilai Preferensi</th></tr></thead>';
        content += '<tbody>';

        if (data.nilai_preferensi && data.nilai_preferensi.length > 0) {
          $.each(data.nilai_preferensi, function(index, item) {
            content += '<tr>';
            content += '<td>' + item.id_alternatif + '</td>';
            content += '<td>' + item.nama_wisata + '</td>';
            content += '<td>' + item.nilai.toFixed(6) + '</td>';
            content += '</tr>';
          });
        } else {
          content += '<tr><td colspan="3" class="text-center">Tidak ada data nilai preferensi</td></tr>';
        }

        content += '</tbody></table></div></div>';

        content += '<div class="mb-4">';
        content += '<h6 class="font-weight-bold mb-3">Hasil Rekomendasi Akhir</h6>';
        content += '<div class="table-responsive">';
        content += '<table class="table table-sm table-bordered">';
        content += '<thead><tr><th>Peringkat</th><th>ID Alternatif</th><th>Nama Wisata</th><th>Nilai</th></tr></thead>';
        content += '<tbody>';

        if (data.hasil_rekomendasi && data.hasil_rekomendasi.length > 0) {
          $.each(data.hasil_rekomendasi, function(index, item) {
            content += '<tr>';
            content += '<td>' + item.peringkat + '</td>';
            content += '<td>' + item.id_alternatif + '</td>';
            content += '<td>' + item.nama_wisata + '</td>';
            content += '<td>' + item.nilai.toFixed(6) + '</td>';
            content += '</tr>';
          });
        } else {
          content += '<tr><td colspan="4" class="text-center">Tidak ada data hasil rekomendasi</td></tr>';
        }

        content += '</tbody></table></div></div>';

        $('#perhitungan-content').html(content);
      }

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
          $('#kuesioner-title').text('Detail Kuesioner');

          var kuesionerData = responseData.kuesioner_data[alternatifId];
          var content = '';

          $.each(kuesionerData, function(index, item) {
            content += '<div class="mb-4">';
            content += '<h6 class="font-weight-bold">' + item.kriteria_nama + ' (' + item.kriteria_id + ')</h6>';
            content += '<p>Nilai: <span class="badge badge-info">' + item.nilai + '</span>';
            content += ' <span class="badge badge-' + (item.kriteria_jenis === 'benefit' ? 'success' : 'danger') + '">' +
              item.kriteria_jenis + '</span></p>';

            if (item.pertanyaan_grouped && item.pertanyaan_grouped.length > 0) {
              content += '<div class="ml-3">';

              $.each(item.pertanyaan_grouped, function(gIdx, group) {
                content += '<div class="mb-4">';
                content += '<p class="mb-2"><strong>' + (gIdx + 1) + '. ' + group.pertanyaan + '</strong></p>';

                $.each(group.opsi, function(oIdx, opsi) {
                  var isSelected = opsi.selected;
                  var radioId = 'radio_' + item.kriteria_id + '_' + gIdx + '_' + oIdx;

                  content += '<div class="form-check mb-2">';
                  content += '<input class="form-check-input" type="radio" name="kuesioner_' +
                    item.kriteria_id + '_' + gIdx + '" id="' + radioId + '" ' +
                    (isSelected ? 'checked' : '') + ' disabled>';
                  content += '<label class="form-check-label" for="' + radioId + '">';
                  content += opsi.opsi_jawaban + ' (Bobot: ' + opsi.bobot + ')';
                  content += '</label>';
                  content += '</div>';
                });

                content += '</div>';

                if (gIdx < item.pertanyaan_grouped.length - 1) {
                  content += '<hr class="my-3">';
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

    #kuesioner-content,
    #perhitungan-content {
      padding: 10px;
    }

    .rekomendasi-row {
      cursor: pointer;
    }

    .table-primary {
      background-color: rgba(103, 119, 239, 0.2) !important;
    }

    .form-check {
      position: relative;
      display: block;
      padding-left: 1.25rem;
      margin-bottom: 0.5rem;
    }

    .form-check-input {
      display: inline-block !important;
      visibility: visible !important;
      opacity: 1 !important;
      position: absolute !important;
      margin-top: 0.3rem;
      margin-left: -1.25rem;
      width: 16px;
      height: 16px;
    }

    .form-check-label {
      margin-bottom: 0;
      margin-left: 0.5rem;
      display: inline-block;
    }

    .kuesioner-radio-container {
      margin-left: 1.5rem;
      margin-bottom: 0.75rem;
    }

    .badge-success {
      background-color: #28a745;
      color: white;
    }

    .badge-danger {
      background-color: #dc3545;
      color: white;
    }

    .badge-info {
      background-color: #17a2b8;
      color: white;
    }
  </style>
</body>

</html>