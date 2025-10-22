<?php
// memasukkan koneksi database
include_once("config.php");

// menampilkan data yang akan dihapus berdasarkan id
$nim = $_GET['id'];

// Menghapus data berdasarkan id yang dipilih
$result = mysqli_query($mysqli, "DELETE FROM mahasiswa WHERE ID=$nim");

// Setelah data terhapus akan menampilkan halaman utama
header("Location:index.php");
?>