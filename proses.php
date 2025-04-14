<?php
include "koneksi.php";
$db = new database();

if (isset($_GET['aksi']) && $_GET['aksi'] == "hapus" && isset($_GET['nis'])) {
    $nis = $_GET['nis'];

    if ($db->hapus_siswa($nis)) {
        echo "<script>alert('Data siswa berhasil dihapus!'); window.location='data_siswa.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.location='data_siswa.php';</script>";
    }
} else {
    echo "<script>alert('Akses tidak valid!'); window.location='data_siswa.php';</script>";
}
?>
