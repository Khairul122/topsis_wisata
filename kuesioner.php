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
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="card-title">Data Kuesioner</h4>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKuesioner">
                                            <i class="ti-plus"></i> Tambah Data
                                        </button>
                                    </div>

                                    <?php
                                    include 'koneksi.php';

                                    $limit = 10;
                                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                    $offset = ($page - 1) * $limit;

                                    $total_query = "SELECT COUNT(*) AS total FROM kuesioner";
                                    $total_result = mysqli_query($koneksi, $total_query);
                                    $total_row = mysqli_fetch_assoc($total_result);
                                    $total_pages = ceil($total_row['total'] / $limit);

                                    $query = "SELECT * FROM kuesioner LIMIT $limit OFFSET $offset";
                                    $result = mysqli_query($koneksi, $query);

                                    $no = $offset + 1;
                                    ?>

                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>ID Kriteria</th>
                                                    <th>Pertanyaan</th>
                                                    <th>Opsi Jawaban</th>
                                                    <th>Bobot</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$row['id_kriteria']}</td>
                                    <td>{$row['pertanyaan']}</td>
                                    <td>{$row['opsi_jawaban_pertanyaan']}</td>
                                    <td class='text-primary'>{$row['bobot_opsi_jawaban_pertanyaan']}</td>
                                    <td>
                                      <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditKuesioner{$row['id_kuesioner']}'>
                                        <i class='ti-pencil'></i>
                                      </button>
                                      <a href='crud/hapus-kuesioner.php?id={$row['id_kuesioner']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>
                                        <i class='ti-trash'></i>
                                      </a>
                                    </td>
                                  </tr>";

                                                        echo "<div class='modal fade' id='modalEditKuesioner{$row['id_kuesioner']}' tabindex='-1'>
                                    <div class='modal-dialog'>
                                      <div class='modal-content'>
                                        <div class='modal-header'>
                                          <h5 class='modal-title'>Edit Kuesioner</h5>
                                          <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                        </div>
                                        <div class='modal-body'>
                                          <form action='crud/edit-kuesioner.php' method='POST'>
                                            <input type='hidden' name='id_kuesioner' value='{$row['id_kuesioner']}'>
                                            <div class='mb-3'>
                                              <label>ID Kriteria</label>
                                              <input type='text' name='id_kriteria' class='form-control' value='{$row['id_kriteria']}' required>
                                            </div>
                                            <div class='mb-3'>
                                              <label>Pertanyaan</label>
                                              <textarea name='pertanyaan' class='form-control' required>{$row['pertanyaan']}</textarea>
                                            </div>
                                            <div class='mb-3'>
                                              <label>Opsi Jawaban</label>
                                              <input type='text' name='opsi_jawaban_pertanyaan' class='form-control' value='{$row['opsi_jawaban_pertanyaan']}' required>
                                            </div>
                                            <div class='mb-3'>
                                              <label>Bobot</label>
                                              <input type='number' step='0.01' name='bobot_opsi_jawaban_pertanyaan' class='form-control' value='{$row['bobot_opsi_jawaban_pertanyaan']}' required>
                                            </div>
                                            <button type='submit' class='btn btn-success'>Simpan</button>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Batal</button>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>";

                                                        $no++;
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='6' class='text-center'>Tidak ada data tersedia</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <nav>
                                        <ul class="pagination justify-content-center">
                                            <?php if ($page > 1) { ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="?page=<?php echo ($page - 1); ?>">Sebelumnya</a>
                                                </li>
                                            <?php } ?>

                                            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                                </li>
                                            <?php } ?>

                                            <?php if ($page < $total_pages) { ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="?page=<?php echo ($page + 1); ?>">Selanjutnya</a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalTambahKuesioner" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data Kuesioner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="crud/tambah-kuesioner.php" method="POST">
                            <div class="mb-3">
                                <label>ID Kriteria</label>
                                <select name="id_kriteria" class="form-control" required>
                                    <option value="">-- Pilih Kriteria --</option>
                                    <?php
                                    include 'koneksi.php';
                                    $query_kriteria = "SELECT id_kriteria, nama FROM kriteria";
                                    $result_kriteria = mysqli_query($koneksi, $query_kriteria);
                                    while ($row = mysqli_fetch_assoc($result_kriteria)) {
                                        echo "<option value='{$row['id_kriteria']}'>{$row['nama']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Pertanyaan</label>
                                <textarea name="pertanyaan" class="form-control" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Opsi Jawaban</label>
                                <textarea name="opsi_jawaban_pertanyaan" class="form-control" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Bobot</label>
                                <input type="number" step="0.01" name="bobot_opsi_jawaban_pertanyaan" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'template/script.php'; ?>
</body>

</html>