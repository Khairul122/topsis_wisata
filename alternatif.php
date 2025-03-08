<?php include('template/header.php'); ?>

<body class="with-welcome-text">
    <div class="container-scroller">
        <?php include 'template/navbar.php' ?>
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
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="card-title">Data Alternatif</h4>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahAlternatif">
                                            <i class="ti-plus"></i> Tambah Data
                                        </button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nama Wisata</th>
                                                    <th>Koordinat</th>
                                                    <th>Deskripsi</th>
                                                    <th>Foto</th>
                                                    <th>URL</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                include 'koneksi.php';

                                                $query = "SELECT * FROM alternatif";
                                                $result = mysqli_query($koneksi, $query);

                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<tr>
                <td>{$row['id_alternatif']}</td>
                <td>{$row['nama_wisata']}</td>
                <td>{$row['koordinat']}</td>
                <td>{$row['deskripsi']}</td>
                <td>
                  " . (!empty($row['foto']) ?
                                                            "<a href='#' data-bs-toggle='modal' data-bs-target='#imageModal' onclick='showImage(\"foto_wisata/{$row['foto']}\")'>
                    <img src='foto_wisata/{$row['foto']}' width='50' class='img-thumbnail'>
                  </a>"
                                                            : "Tidak ada foto") . "
                </td>
                <td><a href='{$row['url']}' target='_blank' class='btn btn-info btn-sm'><i class='ti-location-pin'></i> Lihat Lokasi</a></td>
                <td>
                  <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditAlternatif{$row['id_alternatif']}'>
                    <i class='ti-pencil'></i>
                  </button>
                  <a href='crud/hapus-alternatif.php?id={$row['id_alternatif']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>
                    <i class='ti-trash'></i>
                  </a>
                </td>
              </tr>";

                                                        echo "<div class='modal fade' id='modalEditAlternatif{$row['id_alternatif']}' tabindex='-1'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <h5 class='modal-title'>Edit Data Wisata</h5>
                      <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                    </div>
                    <div class='modal-body'>
                      <form action='crud/edit-alternatif.php' method='POST' enctype='multipart/form-data'>
                        <input type='hidden' name='id_alternatif' value='{$row['id_alternatif']}'>
                        <div class='mb-3'>
                          <label>Nama Wisata</label>
                          <input type='text' name='nama_wisata' class='form-control' value='{$row['nama_wisata']}' required>
                        </div>
                        <div class='mb-3'>
                          <label>Koordinat</label>
                          <input type='text' name='koordinat' class='form-control' value='{$row['koordinat']}' required>
                        </div>
                        <div class='mb-3'>
                          <label>Deskripsi</label>
                          <textarea name='deskripsi' class='form-control' required>{$row['deskripsi']}</textarea>
                        </div>
                        <div class='mb-3'>
                          <label>Ganti Foto (Opsional)</label>
                          <input type='file' name='foto' class='form-control'>
                          <small class='text-muted'>Abaikan jika tidak ingin mengganti foto.</small>
                        </div>
                        <div class='mb-3'>
                          <label>URL Google Maps</label>
                          <input type='text' name='url' class='form-control' value='{$row['url']}' required>
                        </div>
                        <button type='submit' class='btn btn-success'>Simpan</button>
                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Batal</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data tersedia</td></tr>";
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
        </div>
    </div>

    <!-- Modal Tambah Alternatif -->
    <div class="modal fade" id="modalTambahAlternatif" tabindex="-1" aria-labelledby="modalTambahAlternatifLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahAlternatifLabel">Tambah Alternatif Wisata</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="crud/tambah-alternatif.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>Nama Wisata</label>
                            <input type="text" name="nama_wisata" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Koordinat (Latitude, Longitude)</label>
                            <input type="text" name="koordinat" class="form-control" required placeholder="Contoh: 3.198728, 98.380386">
                        </div>
                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Foto</label>
                            <input type="file" name="foto" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>URL Google Maps</label>
                            <input type="text" name="url" class="form-control" required placeholder="https://maps.app.goo.gl/...">
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid rounded" style="max-height: 400px;">
                </div>
            </div>
        </div>
    </div>

    <?php include 'template/script.php'; ?>
    <script>
        function showImage(imageSrc) {
            document.getElementById("modalImage").src = imageSrc;
        }
    </script>
</body>

</html>