<?php
$dbserver = "localhost"; 
$username = "root";     
$password = "";         
$dbname = "temumobil"; 

// Membuat koneksi
$conn = mysqli_connect($dbserver, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>