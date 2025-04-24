<?php 
require_once "../koneksi.php";

// Ambil data user dan jurusan
$kueri_user = mysqli_query($koneksi, "SELECT users.*, users.name AS username, roles.name AS user_role 
    FROM users 
    JOIN user_role ON user_role.user_id = users.id
    JOIN roles ON user_role.role_id = roles.id 
    WHERE roles.name = 'Siswa'");
$row_user = mysqli_fetch_all($kueri_user, MYSQLI_ASSOC);

$kueri_jurusan= mysqli_query($koneksi, "SELECT * FROM majors");
$row_jurusan = mysqli_fetch_all($kueri_jurusan, MYSQLI_ASSOC);

// Tambah siswa
if (isset($_POST['tambah'])) {
    $user_id = (int) $_POST['user_id'];
    $majors_id = (int) $_POST['majors_id'];
    $gender = isset($_POST['gender']) ? (int) $_POST['gender'] : 0;
    $date_of_birth = $_POST['date_of_birth'];
    $place_of_birth = $_POST['place_of_birth'];
    $photo = $_FILES['photo']['name'];
    $photo_size = $_FILES['photo']['size'];
    $is_active = isset($_POST['is_active']) ? (int) $_POST['is_active'] : 0;

    $ekstensi = array('png', 'jpg', 'jpeg');
    $ext = pathinfo($photo, PATHINFO_EXTENSION);

    if (!in_array($ext, $ekstensi)) {
        echo "Mohon maaf ektensi tidak terdaftar";
    } else {
        move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/' . $photo);
        $insert_query = "INSERT INTO students (user_id, majors_id, gender, date_of_birth, place_of_birth, photo, is_active) 
              VALUES ('$user_id', '$majors_id', '$gender', '$date_of_birth', '$place_of_birth', '$file_name', '$is_active')";
        $insert = mysqli_query($koneksi, $insert_query);
        
        if (!$insert) {
            header("Location: ?halaman=tambah-sunting-siswa&tambah=gagal");
        } else {
            header("Location: ?halaman=pengelola-siswa&tambah=berhasil");
        }
    }
}

// Sunting siswa
if (isset($_GET['sunting']) && $_GET['sunting']) {
    $id = $_GET['sunting'];
    $query_edit = mysqli_query($koneksi, "SELECT * FROM students WHERE id = '$id'");
    $row_edit = mysqli_fetch_assoc($query_edit);

    if (isset($_POST['simpan'])) {
        $id = $_GET['sunting'];
        $user_id = (int) $_POST['user_id'];
        $majors_id = (int) $_POST['majors_id'];
        $gender = isset($_POST['gender']) ? (int) $_POST['gender'] : 0;
        $date_of_birth = $_POST['date_of_birth'];
        $place_of_birth = $_POST['place_of_birth'];
        $photo = $_FILES['photo']['name'];
        $photo_size = $_FILES['photo']['size'];
        $is_active = isset($_POST['is_active']) ? (int) $_POST['is_active'] : 0;

        $ekstensi = array('png', 'jpg', 'jpeg');
        $ext = pathinfo($photo, PATHINFO_EXTENSION);

        if (!in_array($ext, $ekstensi)) {
            echo "Mohon maaf ektensi tidak terdaftar";
        } else {
            unlink("uploads/" . $row_edit['photo']);
            move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/" . $photo);
            $query = "UPDATE students SET 
            user_id = '$user_id', 
            majors_id = '$majors_id', 
            gender = '$gender', 
            date_of_birth = '$date_of_birth', 
            place_of_birth = '$place_of_birth', 
            is_active = '$is_active',
            photo = '$photo'
            WHERE id = '$id'";
            $update = mysqli_query($koneksi, $query);
            header("Location: ?halaman=pengelola-siswa&update=berhasil");
        }
    }
}
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3><?php echo isset($_GET['sunting']) ? 'Sunting ' : 'Tambah '; ?>Siswa</h3>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Nama Lengkap Siswa: <span class="text-danger">*</span></label>
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="">Pilih Siswa</option>
                            <?php foreach ($row_user as $siswa) { ?>
                            <option value="<?php echo $siswa['id']; ?>" 
                                <?php echo (isset($_GET['sunting']) && $siswa['id'] == $row_edit['user_id']) ? 'selected' : ''; ?>>
                                <?php echo $siswa['username']; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">Tanggal Lahir Siswa: <span class="text-danger">*</span></label>
                        <input class="form-control" type="date" name="date_of_birth" id="date_of_birth" required value="<?php echo isset($_GET['sunting']) ? $row_edit['date_of_birth'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="place_of_birth" class="form-label">Tempat Lahir Siswa: <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="place_of_birth" id="place_of_birth" required value="<?php echo isset($_GET['sunting']) ? $row_edit['place_of_birth'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="majors_id" class="form-label">Jurusan Siswa: <span class="text-danger">*</span></label>
                        <select name="majors_id" id="majors_id" class="form-select">
                            <option value="">Pilih Jurusan</option>
                            <?php foreach ($row_jurusan as $jurusan) { ?>
                                <option value="<?php echo $jurusan['id']; ?>" 
                                    <?php echo (isset($_GET['sunting']) && $jurusan['id'] == $row_edit['majors_id']) ? 'selected' : ''; ?>>
                                    <?php echo $jurusan['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php if (isset($_GET['sunting'])) { ?>
                            <div class="mb-3">
                                <img src="uploads/<?php echo isset($_GET['sunting']) ? $row_edit['photo'] : '' ?>" width="100" alt="Foto Profil Tidak tersedia">
                            </div>
                    <?php } ?>
                    <div class="mb-3">
                        <label class="form-label" for="photo">Foto: </label>
                        <input class="form-control form-control-sm" type="file" name="photo" id="photo">
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Jenis Kelamin Siswa: <span class="text-danger">*</span></label>
                        <input class="form-check-input" type="checkbox" name="gender" id="gender" value="0" <?php echo isset($_GET['sunting']) && $row_edit['gender'] == 0 ? 'checked' : '' ?>> Perempuan
                        <input class="form-check-input" type="checkbox" name="gender" id="gender" value="1" <?php echo isset($_GET['sunting']) && $row_edit['gender'] == 1 ? 'checked' : '' ?>> Laki-laki
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
                        <a href="?halaman=pengelola-siswa" class="btn btn-danger" name="kembali" id="kembali">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>