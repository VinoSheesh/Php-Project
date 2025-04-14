<?php
include "koneksi.php";
$db = new database();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Jurusan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family: 'Poppins', sans-serif;
            padding: 2rem;
        }
        .header {
            text-align: center;
            width: 100%;
            font-size: 2rem;
        }
        table {
            border-collapse: collapse;
            width: fit-content;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        th, td {
            border: 2px solid #007BFF;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        .tambahdata {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .tambahdata:hover {
            background-color: #0056b3;
        }
        .action-btn {
            margin: 0 5px;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
        }
        .edit-btn { background-color: #28a745; }
        .edit-btn:hover { background-color: #218838; }
        .delete-btn { background-color: #dc3545; }
        .delete-btn:hover { background-color: #c82333; }
    </style>
</head>

<body>

<h2 class="header">Tabel Data Jurusan</h2>
<table>
    <tr>
        <th>Kode Jurusan</th>
        <th>Nama Jurusan</th>
        <th>Aksi</th>
    </tr>
    <?php
    foreach ($db->tampil_data_jurusan() as $x) {
        ?>
        <tr>
            <td><?php echo $x['kode_jurusan']; ?></td>
            <td><?php echo $x['nama_jurusan']; ?></td>
            <td>
                <a href="edit_jurusan.php?kode=<?php echo $x['kode_jurusan']; ?>" class="action-btn edit-btn">Edit</a>
                <a href="hapus_jurusan.php?kode=<?php echo $x['kode_jurusan']; ?>" class="action-btn delete-btn" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>
<a href="tambah_data_jurusan.php" class="tambahdata">Tambah Data</a>

</body>
</html>
