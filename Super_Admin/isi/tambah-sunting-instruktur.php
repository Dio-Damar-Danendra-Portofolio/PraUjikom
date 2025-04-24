<?php 
    require_once "../koneksi.php";
    $kueri_user = mysqli_query($koneksi, "SELECT users.*, users.name AS username, roles.name AS user_role FROM users 
    JOIN user_role ON user_role.user_id = users.id
    JOIN roles ON user_role.role_id = roles.id WHERE roles.name = 'Instruktur';");
    $row_user = mysqli_fetch_all($kueri_user, MYSQLI_ASSOC);

    $kueri_jurusan= mysqli_query($koneksi, "SELECT * FROM majors");
    $row_jurusan = mysqli_fetch_all($kueri_jurusan, MYSQLI_ASSOC);

    if (isset($_POST['tambah'])) {
        $user_id = (int) $_POST['user_id'];
        $majors_id = (int) $_POST['majors_id'];
        $gender = $_POST['gender'];
        $title = $_POST['title'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $photo = $_FILES['photo']['name'];
        $photo_size = $_FILES['photo']['size'];
        $is_active = (int) $_POST['is_active'];
            
            $ekstensi = array('png', 'jpg', 'jpeg');
            $ext = pathinfo($photo, PATHINFO_EXTENSION);

            if (!in_array($ext, $ekstensi)) {
                echo "Mohon maaf ektensi tidak terdaftar";
            } else {
                move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/'. $photo);

                $insert = mysqli_query($koneksi, "INSERT INTO instructors (user_id, majors_id, title, gender, address, phone, photo, is_active) VALUES ('$user_id', '$majors_id', '$title', '$gender', '$address', '$phone', '$photo', '$is_active');");

                if ($insert) {
                    header("Location: ?halaman=pengelola-instruktur&tambah=berhasil");
                } else {
                    header("Location: ?halaman=tambah-sunting-instruktur&tambah=gagal");
                }
                
            }
    }

    if (isset($_GET['sunting']) && $_GET['sunting']){
        $id = $_GET['sunting'];
        $query_edit = mysqli_query($koneksi, "SELECT * FROM instructors WHERE id = '$id'");
        $row_edit = mysqli_fetch_assoc($query_edit);

        if (isset($_POST['simpan'])){
            if (isset($_GET['sunting'])){
                $id = $_GET['sunting'];
                $user_id = (int) $_POST['user_id'];
                $majors_id = (int) $_POST['majors_id'];
                $gender = $_POST['gender'];
                $title = $_POST['title'];
                $address = $_POST['address'];
                $phone = $_POST['phone'];
                $photo = $_FILES['photo']['name'];
                $photo_size = $_FILES['photo']['size'];
                $is_active = (int) $_POST['is_active'];

                $ekstensi = array('png', 'jpg', 'jpeg');
                $ext = pathinfo($photo, PATHINFO_EXTENSION);

                if (!in_array($ext, $ekstensi)) {
                    echo "Mohon maaf ektensi tidak terdaftar";
                } else {
                    unlink("uploads/" . $row_edit['photo']);
                    move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/" . $photo);
                    $update = mysqli_query($koneksi, "UPDATE instructors SET 
                    user_id = '$user_id', 
                    majors_id = '$majors_id', 
                    title = '$title', 
                    gender = '$gender', 
                    address = '$address', 
                    phone = '$phone', 
                    photo = '$photo', 
                    is_active = '$is_active' 
                    WHERE id = '$id';");

                    if ($update) {
                        header("Location: ?halaman=pengelola-instruktur&update=berhasil");
                    } else {
                        header("Location: ?halaman=tambah-sunting-instruktur&update=gagal");
                    }           
                }
            }
        }
    }
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3><?php echo isset($_GET['sunting']) ? 'Sunting ' : 'Tambah '; ?>Instruktur</h3>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Nama Lengkap Instruktur: <span class="text-danger">*</span></label>
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="">Pilih Instruktur</option>
                            <?php foreach ($row_user as $instruktur) { ?>
                            <option value="<?php echo $instruktur['id']; ?>" <?php echo (isset($_GET['sunting']) && $instruktur['id'] == $row_edit['user_id']) ? 'selected' : ''; ?>><?php echo $instruktur['username']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Gelar Instruktur: <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="title" id="title" required value="<?php echo isset($_GET['sunting']) ? $row_edit['title'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Jenis Kelamin Instruktur: <span class="text-danger">*</span></label>
                        <input class="form-check-input" type="checkbox" name="gender" id="gender" value="0" <?php echo isset($_GET['sunting']) && $row_edit['gender'] == 0 ? 'checked' : '' ?>> Perempuan
                        <input class="form-check-input" type="checkbox" name="gender" id="gender" value="1" <?php echo isset($_GET['sunting']) && $row_edit['gender'] == 1 ? 'checked' : '' ?>> Laki-laki
                    </div>
                    <div class="mb-3">
                        <label for="majors_id" class="form-label">Jurusan Instruktur: <span class="text-danger">*</span></label>
                        <select name="majors_id" id="majors_id" class="form-select">
                            <option value="">Pilih Jurusan</option>
                            <?php foreach ($row_jurusan as $jurusan) { ?>
                                <option value="<?php echo $jurusan['id']; ?>" <?php echo isset($_GET['sunting']) && $jurusan['id'] == $row_edit['majors_id'] ? 'selected' : '' ;?>><?php echo $jurusan['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="is_active">Foto: <span class="text-danger">*</span></label>
                        <input class="form-control form-control-sm" type="file" name="photo" id="photo" value="<?php echo isset($_GET['sunting']) ? $row_edit['photo'] : '' ?>">
                        <?php if (isset($_GET['sunting'])) { ?>
                            <img src="uploads/<?php echo isset($_GET['sunting']) ? $row_edit['photo'] : '' ?>" width="100" alt="Foto Profil Tidak tersedia">
                        <?php } ?>
                    </div>
                    <div class="mc-3">
                        <label class="form-label" for="is_active">Status: <span class="text-danger">*</span></label>
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="0" <?php echo isset($_GET['sunting']) && $row_edit['is_active'] == 0 ? 'checked' : ''; ?>> Inaktif
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" <?php echo isset($_GET['sunting']) && $row_edit['is_active'] == 1 ? 'checked' : ''; ?>> Aktif
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="phone">Nomor Telepon: <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" id="phone" class="form-control" required value="<?php echo isset($_GET['sunting']) ? $row_edit['phone'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                    <label for="address" class="form-label">Alamat: </label>
                    <textarea class="form-control" name="address" id="address" cols="30" rows="10" required value="<?php echo isset($_GET['sunting']) ? $row_edit['address'] : ''; ?>"></textarea>
                    </div>
                    <div class="mb-3">
                    <?php if (isset($_GET['sunting'])) { ?>
                            <button type="submit" class="btn btn-success" name="simpan" id="simpan">Simpan</button>
                        <?php } else { ?>
                            <button type="submit" class="btn btn-success" name="tambah" id="tambah">Tambah</button>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <a href="?halaman=pengelola-" class="btn btn-danger" name="kembali" id="kembali">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>