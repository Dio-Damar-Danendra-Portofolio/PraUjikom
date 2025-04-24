<?php 
    require_once "../koneksi.php";
    $kueri_user = mysqli_query($koneksi, "SELECT * FROM users;");
    $row_user = mysqli_fetch_all($kueri_user, MYSQLI_ASSOC);

    $kueri_role = mysqli_query($koneksi, "SELECT * FROM roles;");
    $row_role = mysqli_fetch_all($kueri_role, MYSQLI_ASSOC);

    if (isset($_POST['tambah'])) {
        $user_id = $_POST['user_id'];
        $role_id = $_POST['role_id'];
        $insert = mysqli_query($koneksi, "INSERT INTO user_role (user_id, role_id) VALUES ('$user_id', '$role_id')");

        if ($insert) {
            header("Location: ?halaman=pengelola-pengguna&tambah=berhasil");
        }
    }

    if (isset($_GET['ID_Pengguna']) && $_GET['ID_Pengguna']){
        $id = $_GET['ID_Pengguna'];
        $query_peran = mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$id'");
        $row_peran = mysqli_fetch_assoc($query_peran);

        if (isset($_POST['simpan'])){
            if (isset($_GET['ID_Pengguna'])){
                $id = $_GET['ID_Pengguna'];
                $user_id = (int) $_POST['user_id'];
                $role_id = (int) $_POST['role_id'];
                $update = mysqli_query($koneksi, "UPDATE user_role SET user_id = '$user_id', role_id = '$role_id'
                WHERE id = '$id'");
                if ($update) {
                    header("Location: ?halaman=pengelola-pengguna&tambah=berhasil");
                }
            }
        }
    }
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3>Tambah Peran Pengguna</h3>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Nama Pengguna: <span class="text-danger">*</span></label>
                        <select class="form-select" name="user_id" id="user_id">
                        <option value="">Pilih Pengguna</option>
                        <?php foreach ($row_user as $user) { ?>
                        <option value="<?php echo $user['id']; ?>" <?php echo isset($_GET['ID_Pengguna']) ? 'selected' : ''; ?>><?php echo $user['name']; ?></option>
                        <?php } ?>  
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="role_id" class="form-label">Peran Pengguna: <span class="text-danger">*</span></label>
                        <select class="form-select" name="role_id" id="role_id">
                            <option value="">Pilih Peran</option>
                            <?php $i = 0; 
                            foreach ($row_role as $role) { ?>
                                <option value="<?php echo $role['id']; ?>"><?php echo $role['name']; ?></option>
                            <?php } ?> 
                        </select>
                    </div>
                    <div class="mb-3">
                            <button type="submit" class="btn btn-success" name="tambah" id="tambah">Tambah</button>
                    </div>
                        <a href="?halaman=pengelola-pengguna" class="btn btn-danger" name="kembali" id="kembali">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>