<?php 
    require_once "../koneksi.php";
    $kueri_jurusan = mysqli_query($koneksi, "SELECT * FROM majors 
    JOIN majors_detail ON majors_detail.majors_id = majors.id;");
    $row_jurusan = mysqli_fetch_all($kueri_jurusan, MYSQLI_ASSOC);

    $kueri_instruktur = mysqli_query($koneksi, "SELECT users.*, users.name AS username, roles.name AS user_role FROM users 
    JOIN user_role ON user_role.user_id = users.id
    JOIN roles ON user_role.role_id = roles.id WHERE roles.name = 'Instruktur';");
    $row_instruktur = mysqli_fetch_all($kueri_instruktur, MYSQLI_ASSOC);

    if (isset($_POST['tambah'])) {
        $name = $_POST['name'];
        $is_active = $_POST['is_active'];
        $insert = mysqli_query($koneksi, "INSERT INTO majors (name, is_active) VALUES ('$name', $is_active);");

        if ($insert) {
            header("Location: ?halaman=pengelola-jurusan&tambah=berhasil");
        }
        else{
            header("Location: ?halaman=tambah-sunting-jurusan&tambah=berhasil");

        }
    }

    if (isset($_GET['sunting']) && $_GET['sunting']){
        $id = $_GET['sunting'];
        $query_edit = mysqli_query($koneksi, "SELECT * FROM majors WHERE id = '$id'");
        $row_edit = mysqli_fetch_assoc($query_edit);

        if (isset($_POST['simpan'])){
            if (isset($_GET['sunting'])){
                $id = $_GET['sunting'];
                $name = $_POST['name'];
                $is_active = $_POST['is_active'];
        
                $update = mysqli_query($koneksi, "UPDATE majors SET name = '$name', is_active = '$is_active'
                 WHERE id = '$id'");
        if ($update) {
            header("Location: ?halaman=pengelola-jurusan&update=berhasil");
        }
            }
        }
    }
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3><?php echo isset($_GET['sunting']) ? 'Sunting ' : 'Tambah '; ?>Jurusan</h3>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Jurusan: <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="name" id="name" required value="<?php echo isset($_GET['sunting']) ? $row_edit['name'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="is_active">Status: <span class="text-danger">*</span></label>
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="0" <?php echo isset($_GET['sunting']) && $row_edit['is_active'] == 0 ? 'checked' : '' ?>> Inaktif
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" <?php echo isset($_GET['sunting']) && $row_edit['is_active'] == 1 ? 'checked' : '' ?>> Aktif
                    </div>
                    <div class="mb-3">
                    <?php if (isset($_GET['sunting'])) { ?>
                            <button type="submit" class="btn btn-success" name="simpan" id="simpan">Simpan</button>
                        <?php } else { ?>
                            <button type="submit" class="btn btn-success" name="tambah" id="tambah">Tambah</button>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <a href="?halaman=pengelola-level" class="btn btn-danger" name="kembali" id="kembali">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>