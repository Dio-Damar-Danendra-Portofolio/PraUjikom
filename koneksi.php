<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "manajemen_modul";

    $koneksi = mysqli_connect($host, $user, $pass, $db);
    if (!$koneksi) {
        echo "Connection failed. Try again";
    }
?>