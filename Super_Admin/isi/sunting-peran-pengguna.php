<?php 
    require_once "../koneksi.php";
    $kueri_user = mysqli_query($koneksi, "SELECT * FROM users;");
    $row_user = mysqli_fetch_all($kueri_user, MYSQLI_ASSOC);

    $kueri_role = mysqli_query($koneksi, "SELECT * FROM roles;");
    $row_role = mysqli_fetch_all($kueri_role, MYSQLI_ASSOC);

    if (isset($_GET['ID_Pengguna']) && $_GET['ID_Pengguna']){
        $id = $_GET['ID_Pengguna'];
        $query_peran = mysqli_query($koneksi, "SELECT * FROM user_role WHERE user_id = '$id'");
        $row_peran = mysqli_fetch_assoc($query_peran);

        if (isset($_POST['simpan'])){
            if (isset($_GET['ID_Pengguna'])){
                $id = $_GET['ID_Pengguna'];
                $user_id = (int) $_POST['user_id'];
                $role_id = (int) $_POST['role_id'];
                $update = mysqli_query($koneksi, "UPDATE user_role SET role_id = '$role_id' WHERE user_id = '$user_id'");
                if ($update) {
                    header("Location: ?halaman=pengelola-pengguna&sunting=berhasil");
                }
            }
        }
    }
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3>Sunting Peran Pengguna</h3>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Nama Pengguna: <span class="text-danger">*</span></label>
                        <select class="form-select" name="user_id" id="user_id">
                        <option value="">Pilih Pengguna</option>
                        <?php foreach ($row_user as $user) { ?>
                            <option value="<?php echo $user['id']; ?>" <?php echo (isset($row_peran['user_id']) 
                            && $user['id'] == $row_peran['user_id']) ? 'selected' : ''; ?>>
                            <?php echo $user['name']; ?>
                            </option>
                        <?php } ?>  
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="role_id" class="form-label">Peran Pengguna: <span class="text-danger">*</span></label>
                        <select class="form-select" name="role_id" id="role_id">
                            <option value="">Pilih Peran</option>
                            <?php $i = 0; 
                            foreach ($row_role as $role) { ?>
                                <option value="<?php echo $role['id']; ?>" 
                                    <?php echo (isset($row_peran['role_id']) && $role['id'] == $row_peran['role_id']) ? 'selected' : ''; ?>>
                                    <?php echo $role['name']; ?>
                                </option>
                            <?php } ?> 
                        </select>
                    </div>
                    <div class="mb-3">
                            <button type="submit" class="btn btn-success" name="simpan" id="simpan">simpan</button>
                    </div>
                        <a href="?halaman=pengelola-pengguna" class="btn btn-danger" name="kembali" id="kembali">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>