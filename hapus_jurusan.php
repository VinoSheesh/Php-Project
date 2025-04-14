<?php
include "koneksi.php";
$db = new Database();
$kode_jurusan = $_GET['kode'];

$query = "DELETE FROM jurusan WHERE kode_jurusan='$kode_jurusan'";
if (mysqli_query($db->koneksi, $query)) {
    echo "<script>alert('Data berhasil dihapus!'); window.location='data_jurusan.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data!');</script>";
}
