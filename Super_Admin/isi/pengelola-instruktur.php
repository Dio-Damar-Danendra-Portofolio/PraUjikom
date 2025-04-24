<?php 
    require_once "../koneksi.php";
    $kueri_instruktur = mysqli_query($koneksi, "SELECT instructors.*, majors.name AS major_name, 
    users.name AS instructor_name
    FROM instructors LEFT JOIN users ON users.id = instructors.user_id 
    LEFT JOIN majors ON instructors.majors_id = majors.id;");
    $row_instruktur = mysqli_fetch_all($kueri_instruktur, MYSQLI_ASSOC);

    if (isset($_GET['hapus'])) {
        $id = $_GET['hapus'];
        $hapus = mysqli_query($koneksi, "DELETE FROM instructors WHERE id = '$id';");
        header("Location:?halaman=pengelola-instruktur&notif=sukses");
    }
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3>Pengelola Instruktur</h3>
            </div>
            <div class="card-body">
                <div class="mb-3 mt-3" align="right">
                    <a href="?halaman=tambah-sunting-instruktur" class="btn btn-primary">Tambah Instruktur Baru</a>
                </div>
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Nama Instruktur</th>
                            <th>Alamat</th>
                            <th>Jenis Kelamin</th>
                            <th>Nomor Telepon</th>
                            <th>Jurusan</th>
                            <th>Foto Profil</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; foreach ($row_instruktur as $instruktur) { ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $instruktur['instructor_name']; ?></td>
                                <td><?php echo $instruktur['address']; ?></td>
                                <td><?php echo $instruktur['gender'] == 1 ? 'Laki-laki' : 'Perempuan'; ?></td>
                                <td><?php echo $instruktur['phone']; ?></td>
                                <td><?php echo $instruktur['major_name']; ?></td>
                                <td><img src="uploads/<?php echo $instruktur['photo']; ?>" width="100" alt="Foto Pengguna Tidak Tersedia"></td>
                                <td><?php echo $instruktur['is_active'] == 1 ? 'Aktif' : 'Tidak Aktif'; ?></td>                                
                                <td>
                                    <a href="?halaman=tambah-sunting-instruktur&sunting=<?php echo $instruktur['id']; ?>" class="btn btn-info btn-sm">Edit (Sunting) Data Instruktur</a>
                                    <a href="?halaman=pengelola-instruktur&hapus=<?php echo $instruktur['id']; ?>" class="btn btn-danger tn-sm" onclick="return confirm('Apakah Anda yakin untuk menghapus data ini?');">Hapus Data Instruktur</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

