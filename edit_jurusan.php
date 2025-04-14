<?php
include "koneksi.php";
$db = new Database();

$id_jurusan = $_GET['id'] ?? '';
$query = "SELECT * FROM jurusan WHERE id_jurusan = ?";
$stmt = $db->koneksi->prepare($query);
$stmt->bind_param("i", $id_jurusan);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_jurusan = $_POST['nama_jurusan'];

    $query = "UPDATE jurusan SET nama_jurusan = ? WHERE id_jurusan = ?";
    $stmt = $db->koneksi->prepare($query);
    $stmt->bind_param("si", $nama_jurusan, $id_jurusan);

    if ($stmt->execute()) {
        echo "<script>alert('Data jurusan berhasil diperbarui!'); window.location='data_jurusan.php';</script>";
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
    <title>Edit Data Jurusan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f4f4f4;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }

        h2 {
            margin-bottom: 15px;
            font-weight: 600;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            width: 100%;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #007BFF;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        button, .back-btn {
            flex: 1;
            padding: 10px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            transition: 0.3s;
            text-align: center;
            border: none;
        }

        button {
            background-color: #28a745;
            color: white;
        }

        button:hover {
            background-color: #218838;
        }

        .back-btn {
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            margin-left: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .back-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Edit Data Jurusan</h2>
        <form method="POST">
            <input type="text" name="nama_jurusan" value="<?= htmlspecialchars($data['nama_jurusan'] ?? '') ?>" required>
            <div class="button-group">
                <button type="submit">Simpan</button>
                <a href="data_jurusan.php" class="back-btn">Batal</a>
            </div>
        </form>
    </div>

</body>

</html>
