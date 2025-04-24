<?php 
    require_once "../koneksi.php"; 
    include "inc/judul.php";
    session_start();
    session_regenerate_id();
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php include "inc/head.php"; ?>
<body>
<div class="container-fluid bg-info">
    <?php include "inc/navigasi.php"; ?>
</div>
<section class="section">
    <?php 
        if (isset($_GET['halaman'])) {
            if (file_exists('isi/'. $_GET['halaman'].".php")) {
                include 'isi/' .  $_GET['halaman']. ".php";
            }
            else{
                include "isi/beranda.php";
            }
        }
    ?>
</section>
<?php  include "inc/bawah.php"; ?>
</body>
</html>

