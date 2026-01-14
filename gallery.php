<div class="container">
    <div class="row mb-2">
        <div class="col-md-6">
            <!-- Button tambah data -->
            <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-lg"></i> Tambah Gallery
            </button>
        </div>
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" id="search" class="form-control" placeholder="Ketikan minimal 3 karakter untuk pencarian">
                <span class="input-group-text">
                    <i class="bi bi-search"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Deskripsi</th>
                        <th style="width: 500px;">Gambar</th> <!-- Lebar besar untuk gambar -->
                        <th style="width: 80px;">Aksi</th>    <!-- Lebar kecil untuk aksi -->
                    </tr>
                </thead>
                <tbody id="result">
                    <!-- Data akan dimuat via AJAX -->
                </tbody>
            </table>
        </div>
        <!-- Modal tambah data (tetap sama) -->
        <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
            <!-- ... modal tetap sama ... -->
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalTambahLabel">Tambah Gallery</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <input type="text" class="form-control" name="deskripsi" placeholder="Tuliskan Deskripsi Gallery" required>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                <input type="file" class="form-control" name="gambar" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function loadData(keyword = '') {
        $.ajax({
            url: "gallery_search.php",
            type: "POST",
            data: {
                keyword: keyword
            },
            success: function(data) {
                $("#result").html(data);
            }
        });
    }

    // load awal
    loadData();
    
    // event pencarian
    $("#search").on("keyup", function() {
        let keyword = $(this).val();
        
        if (keyword.length >= 3 || keyword.length === 0) {
            loadData(keyword);
        }
    });
</script>

<?php
include "upload_foto.php";

// Jika tombol simpan diklik (tambah/edit)
if (isset($_POST['simpan'])) {
    $deskripsi = $_POST['deskripsi'];
    $tanggal = date("Y-m-d H:i:s"); // Tanggal realtime untuk edit
    $username = $_SESSION['username'];
    $gambar = '';
    $nama_gambar = $_FILES['gambar']['name'];

    // Jika ada file baru yang dikirim  
    if (!empty($nama_gambar) && $_FILES['gambar']['error'] == 0) {
        $cek_upload = upload_foto($_FILES["gambar"]);

        if ($cek_upload['status']) {
            $gambar = $cek_upload['message'];
        } else {
            echo "<script>
                alert('" . $cek_upload['message'] . "');
                document.location='admin.php?page=gallery';
            </script>";
            die;
        }
    }

    // Cek apakah edit atau tambah
    if (isset($_POST['id'])) {
        // EDIT DATA
        $id = $_POST['id'];
        
        // Logika gambar saat edit
        if (empty($nama_gambar) || $_FILES['gambar']['error'] != 0) {
            // Tidak ada gambar baru, pakai gambar lama
            $gambar = $_POST['gambar_lama'];
        } else {
            // Ada gambar baru, hapus gambar lama jika ada
            if (!empty($_POST['gambar_lama'])) {
                unlink("img/" . $_POST['gambar_lama']);
            }
        }

        // UPDATE dengan tanggal realtime
        $stmt = $conn->prepare("UPDATE gallery 
                                SET deskripsi = ?, gambar = ?, tanggal = ?, username = ?
                                WHERE id = ?");
        $stmt->bind_param("ssssi", $deskripsi, $gambar, $tanggal, $username, $id);
        $simpan = $stmt->execute();
        
    } else {
        // TAMBAH DATA BARU
        // Cek apakah ada gambar untuk data baru
        if (empty($nama_gambar) || $_FILES['gambar']['error'] != 0) {
            echo "<script>
                alert('Gambar harus diupload untuk data baru');
                document.location='admin.php?page=gallery';
            </script>";
            die;
        }
        
        $stmt = $conn->prepare("INSERT INTO gallery (deskripsi, gambar, tanggal, username)
                                VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $deskripsi, $gambar, $tanggal, $username);
        $simpan = $stmt->execute();
    }

    if ($simpan) {
        echo "<script>
            alert('Data gallery berhasil disimpan');
            document.location='admin.php?page=gallery';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menyimpan data gallery: " . addslashes($conn->error) . "');
            document.location='admin.php?page=gallery';
        </script>";
    }

    $stmt->close();
    $conn->close();
}

// Jika tombol hapus diklik
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    // Hapus file gambar jika ada
    if (!empty($gambar) && file_exists("img/" . $gambar)) {
        unlink("img/" . $gambar);
    }

    $stmt = $conn->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    if ($hapus) {
        echo "<script>
            alert('Data gallery berhasil dihapus');
            document.location='admin.php?page=gallery';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menghapus data gallery');
            document.location='admin.php?page=gallery';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>