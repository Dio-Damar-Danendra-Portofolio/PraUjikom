<?php 
$kueri_siswa = mysqli_query($koneksi, "SELECT students.*, users.name, majors.name AS major_name, students.photo AS profile_photo
FROM students JOIN users ON students.user_id = users.id
JOIN majors ON students.majors_id = majors.id;
");

$row_siswa = mysqli_fetch_all($kueri_siswa, MYSQLI_ASSOC);


    if (isset($_GET['hapus'])) {
        $id = $_GET['hapus'];
        $hapus = mysqli_query($koneksi, "DELETE FROM students WHERE id = '$id';");
        header("Location:?halaman=pengelola-siswa&notif=sukses");
    }
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3>Pengelola Siswa</h3>
            </div>
            <div class="card-body">
                <div class="mb-3 mt-3" align="right">
                    <a href="?halaman=tambah-sunting-siswa" class="btn btn-primary">Tambah Siswa Baru</a>
                </div>
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Nama Siswa</th>
                            <th>Jenis Kelamin</th>
                            <th>Jurusan</th>
                            <th>Tempat dan Tanggal Lahir</th>
                            <th>Foto Profil</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; foreach ($row_siswa as $siswa) { ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $siswa['name']; ?></td>
                                <td><?php echo $siswa['gender'] == 1 ? 'Laki-laki' : 'Perempuan'; ?></td>
                                <td><?php echo $siswa['major_name']; ?></td>
                                <td><?php echo $siswa['place_of_birth']; ?>, <?php echo date("d/m/Y", strtotime($siswa['date_of_birth'])); ?></td>
                                <td>
                                    <img src="uploads/<?php echo $siswa['profile_photo']; ?>" width="100" alt="Foto Pengguna Tidak Tersedia">
                                </td>
                                <td><?php echo $siswa['is_active'] == 1 ? 'Aktif' : 'Tidak Aktif'; ?></td>                                
                                <td>
                                    <a href="?halaman=tambah-sunting-siswa&sunting=<?php echo $siswa['id']; ?>" class="btn btn-info btn-sm">Edit (Sunting) Data Siswa</a>
                                    <a href="?halaman=pengelola-siswa&hapus=<?php echo $siswa['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin untuk menghapus data ini?');">Hapus Data Siswa</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

