<?php
include("koneksi.php");
$db = new Database();

if (isset($_GET['nisn'])) {
    $nisn = $_GET['nisn'];
    $query = "SELECT * FROM siswa WHERE nisn=?";
    $stmt = $db->koneksi->prepare($query);
    $stmt->bind_param("i", $nisn);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if (!$result) {
        echo "<script>alert('Data tidak ditemukan!'); window.location='datasiswa.php';</script>";
        exit();
    }
}

// Ambil data agama untuk dropdown
$agamaQuery = "SELECT * FROM agama";
$agamaResult = $db->koneksi->query($agamaQuery);

// Ambil data jurusan untuk dropdown
$jurusanQuery = "SELECT * FROM jurusan";
$jurusanResult = $db->koneksi->query($jurusanQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $kode_jurusan = $_POST['kode_jurusan'];
    $kelas = $_POST['kelas'];
    $alamat = $_POST['alamat'];
    $id_agama = $_POST['id_agama'];
    $no_hp = $_POST['no_hp'];

    if ($db->edit_siswa($nisn, $nama, $jenis_kelamin, $kode_jurusan, $kelas, $alamat, $id_agama, $no_hp)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='datasiswa.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #28a745;
            --error-color: #dc3545;
            --text-color: #333;
            --light-gray: #f8f9fa;
            --border-color: #e9ecef;
            --shadow: rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-gray);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px var(--shadow);
            width: 100%;
            max-width: 900px;
            overflow: hidden;
        }

        header {
            background: var(--primary-color);
            color: white;
            padding: 16px 24px;
            text-align: center;
        }

        h2 {
            font-size: 1.5rem;
            font-weight: 500;
            margin: 0;
        }

        form {
            padding: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-row {
            display: flex;
            align-items: center;
        }

        label {
            width: 120px;
            padding-right: 15px;
            font-size: 0.9rem;
            color: #555;
            text-align: right;
            font-weight: 500;
        }

        input, select {
            flex: 1;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 0.95rem;
            transition: border 0.2s;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        button, .cancel-btn {
            padding: 12px 32px;
            border: none;
            border-radius: 6px;
            font-size: 0.95rem;
            cursor: pointer;
            transition: opacity 0.2s;
            text-align: center;
            font-weight: 500;
            color: white;
        }

        button {
            background: var(--primary-color);
        }

        .cancel-btn {
            background: var(--error-color);
            text-decoration: none;
        }

        button:hover {
            opacity: 0.9;
            background-color: #218838;
        }

        .cancel-btn:hover {
            opacity: 0.9;
            background-color: #c82333;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                flex-direction: column;
                align-items: flex-start;
            }

            label {
                width: 100%;
                text-align: left;
                margin-bottom: 6px;
            }

            input, select {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h2>Edit Data Siswa</h2>
    </header>
    
    <form method="POST">
        <input type="hidden" name="nisn" value="<?= $result['nisn']; ?>">
        
        <div class="form-grid">
            <div class="form-row">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?= $result['nama']; ?>" required>
            </div>
            
            <div class="form-row">
                <label for="jenis_kelamin">Jenis Kelamin:</label>
                <select id="jenis_kelamin" name="jenis_kelamin">
                    <option value="L" <?= ($result['jenis_kelamin'] == 'L') ? "selected" : ""; ?>>Laki-laki</option>
                    <option value="P" <?= ($result['jenis_kelamin'] == 'P') ? "selected" : ""; ?>>Perempuan</option>
                </select>
            </div>
            
            <div class="form-row">
                <label for="kode_jurusan">Jurusan:</label>
                <select id="kode_jurusan" name="kode_jurusan" required>
                    <?php while ($jurusan = $jurusanResult->fetch_assoc()) { ?>
                        <option value="<?= $jurusan['kode_jurusan']; ?>" <?= ($result['kode_jurusan'] == $jurusan['kode_jurusan']) ? "selected" : ""; ?>>
                            <?= $jurusan['nama_jurusan']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="form-row">
                <label for="kelas">Kelas:</label>
                <select id="kelas" name="kelas" required>
                    <option value="X" <?= ($result['kelas'] == 'X') ? "selected" : ""; ?>>Kelas X</option>
                    <option value="XI" <?= ($result['kelas'] == 'XI') ? "selected" : ""; ?>>Kelas XI</option>
                    <option value="XII" <?= ($result['kelas'] == 'XII') ? "selected" : ""; ?>>Kelas XII</option>
                </select>
            </div>
            
            <div class="form-row">
                <label for="alamat">Alamat:</label>
                <input type="text" id="alamat" name="alamat" value="<?= $result['alamat']; ?>" required>
            </div>
            
            <div class="form-row">
                <label for="id_agama">Agama:</label>
                <select id="id_agama" name="id_agama" required>
                    <?php 
                    // Reset pointer to the beginning of the result set
                    $agamaResult->data_seek(0);
                    while ($agama = $agamaResult->fetch_assoc()) { ?>
                        <option value="<?= $agama['id_agama']; ?>" <?= ($result['id_agama'] == $agama['id_agama']) ? "selected" : ""; ?>>
                            <?= $agama['nama_agama']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="form-row">
                <label for="no_hp">No HP:</label>
                <input type="text" id="no_hp" name="no_hp" value="<?= $result['no_hp']; ?>" required>
            </div>
        </div>
        
        <div class="button-group">
            <button type="submit">Update</button>
            <a href="datasiswa.php" class="cancel-btn">Batal</a>
        </div>
    </form>
</div>

</body>
</html>