<?php 
    require_once "../koneksi.php";
    $kueri_level = mysqli_query($koneksi, "SELECT * FROM roles");
    $row_level = mysqli_fetch_all($kueri_level, MYSQLI_ASSOC);

    if (isset($_GET['hapus'])) {
        $id = $_GET['hapus'];
        $hapus = mysqli_query($koneksi, "DELETE FROM roles WHERE id = '$id';");
        header("Location:?halaman=pengelola-level&notif=sukses");
    }
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3>Pengelola Level</h3>
            </div>
            <div class="card-body">
                <div class="mb-3 mt-3" align="right">
                    <a href="?halaman=tambah-sunting-level" class="btn btn-primary">Tambah Level Baru</a>
                </div>
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Nama Level</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; foreach ($row_level as $level) { ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $level['name']; ?></td>
                                <td><?php echo isset($level['is_active']) && $level['is_active'] == 1 ? 'Aktif' : 'Inaktif'; ?></td>
                                <td>
                                    <a href="?halaman=tambah-sunting-level&sunting=<?php echo $level['id']; ?>" class="btn btn-info btn-sm">Edit (Sunting) Data Level (Peran)</a>
                                    <a href="?halaman=pengelola-level&hapus=<?php echo $level['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin untuk menghapus data ini?');">Hapus Data Level (Peran)</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

