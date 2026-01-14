<?php
include "koneksi.php";

$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';

$sql = "SELECT * FROM gallery 
        WHERE deskripsi LIKE ? OR tanggal LIKE ? OR username LIKE ?
        ORDER BY tanggal DESC";

$stmt = $conn->prepare($sql);
$search = "%" . $keyword . "%";
$stmt->bind_param("sss", $search, $search, $search);
$stmt->execute();

$hasil = $stmt->get_result();

$no = 1;
while ($row = $hasil->fetch_assoc()) {
?>
    <tr>
        <td><?= $no++ ?></td>
        <td>
            <strong><?= htmlspecialchars($row["deskripsi"]) ?></strong>
            <br>pada : <?= $row["tanggal"] ?>
            <br>oleh : <?= htmlspecialchars($row["username"]) ?>
        </td>
        <!-- KOLOM GAMBAR - BESAR -->
        <td style="text-align: center; vertical-align: middle;">
            <?php
            if ($row["gambar"] != '') {
                if (file_exists('img/' . $row["gambar"])) { 
                    echo '<img src="img/' . $row["gambar"] . '" 
                          class="img-fluid" 
                          style="width: 1000px; height: 400px; object-fit: cover;"
                          alt="Gambar Gallery">'; 
                } else {
                    echo '<span class="text-danger">Gambar tidak ditemukan</span>';
                }
            } else {
                echo '<span class="text-muted">Tidak ada gambar</span>';
            }
            ?>
        </td>
        <!-- KOLOM AKSI - VERTIKAL DI POJOK -->
        <!-- KOLOM AKSI - VERTIKAL -->
        <td>
            <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                <a href="#" title="edit" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>"><i class="bi bi-pencil"></i></a>
               <a href="#" title="delete" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>"><i class="bi bi-x-circle"></i></a>    
            </div>

            <!-- Modal Edit -->
            <div class="modal fade" id="modalEdit<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Gallery</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                
                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <input type="text" class="form-control" name="deskripsi" 
                                           value="<?= htmlspecialchars($row["deskripsi"]) ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Gambar Saat Ini</label>
                                    <?php if ($row["gambar"] != '' && file_exists('img/' . $row["gambar"])): ?>
                                        <div class="text-center">
                                            <img src="img/<?= $row["gambar"] ?>" 
                                                 style="max-width: 300px; max-height: 300px; object-fit: cover;"
                                                 alt="Gambar Gallery">
                                        </div>
                                    <?php endif; ?>
                                    <input type="hidden" name="gambar_lama" value="<?= $row["gambar"] ?>">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Ganti Gambar (Opsional)</label>
                                    <input type="file" class="form-control" name="gambar">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Hapus -->
            <div class="modal fade" id="modalHapus<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="post" action="">
                            <div class="modal-body">
                                <p>Yakin menghapus gallery ini?</p>
                                <?php if ($row["gambar"] != '' && file_exists('img/' . $row["gambar"])): ?>
                                    <div class="text-center mb-3">
                                        <img src="img/<?= $row["gambar"] ?>" 
                                             class="img-fluid rounded" 
                                             style="max-width: 300px; max-height: 300px; object-fit: cover;"
                                             alt="Gambar yang akan dihapus">
                                    </div>
                                <?php endif; ?>
                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                <input type="hidden" name="gambar" value="<?= $row["gambar"] ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </td>
    </tr>
<?php
}
$stmt->close();
$conn->close();
?>