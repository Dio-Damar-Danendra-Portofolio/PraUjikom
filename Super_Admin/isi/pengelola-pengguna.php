<?php 
    require "../koneksi.php";
    $kueri_pengguna = mysqli_query($koneksi, query: "SELECT users.*, GROUP_CONCAT(roles.name SEPARATOR ', ') AS role_name FROM users 
    JOIN user_role ON user_role.user_id = users.id
    JOIN roles ON user_role.role_id = roles.id GROUP BY users.id;");
    $row_pengguna = mysqli_fetch_all($kueri_pengguna, MYSQLI_ASSOC);

    if (isset($_GET['hapus'])) {
        $id = $_GET['hapus'];
        $hapus = mysqli_query($koneksi, "DELETE FROM user_role WHERE user_id = $id LIMIT 1;");
        header("Location:?halaman=pengelola-pengguna&notif=sukses");
    }
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3>Pengelola Pengguna</h3>
            </div>
            <div class="card-body">
                <div class="mb-3 mt-3" align="right">
                    <a href="?halaman=tambah-sunting-pengguna" class="btn btn-primary">Tambah Pengguna Baru</a>
                    <a href="?halaman=tambah-peran-pengguna" class="btn btn-info">Tambah Peran Pengguna</a>
                </div>
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Nama Pengguna</th>
                            <th>E-mail (Surel) Pengguna</th>
                            <th>Peran Pengguna</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; 
                            foreach ($row_pengguna as $pengguna) { ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $pengguna['name']; ?></td>
                                <td><?php echo $pengguna['email']; ?></td>
                                <td><?php echo $pengguna['role_name']; ?></td>
                                <td><?php echo $pengguna['is_active'] == 1 ? 'Aktif' : 'Inaktif' ; ?></td>
                                <td>
                                    <a href="?halaman=sunting-peran-pengguna&ID_Pengguna=<?php echo $pengguna['id']; ?>" class="btn btn-info btn-sm">Ubah Peran Pengguna</a>
                                    <a href="?halaman=tambah-sunting-pengguna&sunting=<?php echo $pengguna['id']; ?>" class="btn btn-success btn-sm">Edit (Sunting) Data Pengguna</a>
                                    <a href="?halaman=pengelola-pengguna&hapus=<?php echo $pengguna['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin untuk menghapus data ini?');">Hapus Data Pengguna</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

