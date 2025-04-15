<?php
include "koneksi.php";
$db = new Database();
$id_agama = $_GET['id'];

$query = "DELETE FROM agama WHERE id_agama='$id_agama'";
if (mysqli_query($db->koneksi, $query)) {
    echo "<script>alert('Data berhasil dihapus!'); window.location='dataagama.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data!');</script>";
}
