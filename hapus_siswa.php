<?php
include("koneksi.php");
$db = new Database();

if (isset($_GET['nisn'])) {
    $nisn = $_GET['nisn'];

    if ($db->hapus_siswa($nisn)) {
        echo "<script>alert('Data siswa berhasil dihapus!'); window.location='datasiswa.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.location='datasiswa.php';</script>";
    }
} else {
    echo "<script>alert('Akses tidak valid!'); window.location='datasiswa.php';</script>";
}
?>
