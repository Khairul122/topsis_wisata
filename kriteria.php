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
                                        <h4 class="card-title">Data Kriteria</h4>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKriteria">
                                            <i class="ti-plus"></i> Tambah Data
                                        </button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID Kriteria</th>
                                                    <th>Nama Kriteria</th>
                                                    <th>Bobot</th>
                                                    <th>Jenis</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                include 'koneksi.php';
                                                $query = "SELECT * FROM kriteria";
                                                $result = mysqli_query($koneksi, $query);

                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $jenis_badge = ($row['jenis'] == 'benefit') ? 'badge-success' : 'badge-danger';

                                                        echo "<tr>
                                    <td>{$row['id_kriteria']}</td>
                                    <td>{$row['nama']}</td>
                                    <td class='text-primary'>{$row['bobot']}</td>
                                    <td><label class='badge {$jenis_badge}'>" . ucfirst($row['jenis']) . "</label></td>
                                    <td>
                                      <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditKriteria{$row['id_kriteria']}'>
                                        <i class='ti-pencil'></i>
                                      </button>
                                      <a href='crud/hapus-kriteria.php?id={$row['id_kriteria']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>
                                        <i class='ti-trash'></i>
                                      </a>
                                    </td>
                                  </tr>";

                                                        echo "<div class='modal fade' id='modalEditKriteria{$row['id_kriteria']}' tabindex='-1'>
                                    <div class='modal-dialog'>
                                      <div class='modal-content'>
                                        <div class='modal-header'>
                                          <h5 class='modal-title'>Edit Kriteria</h5>
                                          <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                        </div>
                                        <div class='modal-body'>
                                          <form action='crud/edit-kriteria.php' method='POST'>
                                            <input type='hidden' name='id_kriteria' value='{$row['id_kriteria']}'>
                                            <div class='mb-3'>
                                              <label>Nama Kriteria</label>
                                              <input type='text' name='nama' class='form-control' value='{$row['nama']}' required>
                                            </div>
                                            <div class='mb-3'>
                                              <label>Bobot</label>
                                              <input type='number' step='0.01' name='bobot' class='form-control' value='{$row['bobot']}' required>
                                            </div>
                                            <div class='mb-3'>
                                              <label>Jenis</label>
                                              <select name='jenis' class='form-control' required>
                                                <option value='benefit' " . ($row['jenis'] == 'benefit' ? 'selected' : '') . ">Benefit</option>
                                                <option value='cost' " . ($row['jenis'] == 'cost' ? 'selected' : '') . ">Cost</option>
                                              </select>
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
                                                    echo "<tr><td colspan='5' class='text-center'>Tidak ada data tersedia</td></tr>";
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

    <div class="modal fade" id="modalTambahKriteria" tabindex="-1" aria-labelledby="modalTambahKriteriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahKriteriaLabel">Tambah Kriteria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="crud/tambah-kriteria.php" method="POST">
                        <div class="mb-3">
                            <label>ID Kriteria</label>
                            <input type="text" name="id_kriteria" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Nama Kriteria</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Bobot</label>
                            <input type="number" step="0.01" name="bobot" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Jenis</label>
                            <select name="jenis" class="form-control" required>
                                <option value="benefit">Benefit</option>
                                <option value="cost">Cost</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'template/script.php'; ?>

</body>

</html>