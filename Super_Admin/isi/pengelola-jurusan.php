<?php 
    require_once "../koneksi.php";
    $kueri_jurusan = mysqli_query($koneksi, "SELECT * FROM majors 
    JOIN major_details ON major_details.major_id = majors.id
    JOIN instructors ON major_details.instructors_id = instructors.id
    JOIN users ON instructors.user_id = users.id
    JOIN user_role ON user_role.user_id = users.id
    JOIN roles ON user_role.role_id = roles.id
    WHERE user_role.role_id IN (SELECT * FROM roles WHERE name = 'Instruktur');");
    $row_jurusan = mysqli_fetch_all($kueri_jurusan, MYSQLI_ASSOC);

    if (isset($_GET['hapus'])) {
        $id = $_GET['hapus'];
        $hapus = mysqli_query($koneksi, "DELETE FROM majors WHERE id = '$id';");
        header("Location:?halaman=pengelola-jurusan&notif=sukses");
    }
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3>Pengelola Jurusan</h3>
            </div>
            <div class="card-body">
                <div class="mb-3 mt-3" align="right">
                    <a href="?halaman=tambah-sunting-jurusan" class="btn btn-primary">Tambah Jurusan Baru</a>
                </div>
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Nama Jurusan</th>
                            <th>Nama Instruktur</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; foreach ($row_jurusan as $jurusan) { ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $jurusan['name']; ?></td>
                                <td><?php echo $jurusan['username'] ? ''; ?></td>
                                <td><?php echo isset($jurusan['is_active']) && $jurusan['is_active'] == 1 ? 'Aktif' : 'Inaktif'; ?></td>
                                <td>
                                    <a href="?halaman=tambah-instruktur"></a>
                                    <a href="?halaman=tambah-sunting-jurusan&sunting=<?php echo $jurusan['id']; ?>" class="btn btn-info btn-sm">Edit (Sunting) Data Jurusan</a>
                                    <a href="?halaman=pengelola-jurusan&hapus=<?php echo $jurusan['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin untuk menghapus data ini?');">Hapus Data Jurusan</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

