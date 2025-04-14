<?php
include "koneksi.php";
$db = new database();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Siswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --secondary: #64748b;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --radius: 0.5rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--gray-100);
            color: var(--dark);
            line-height: 1.5;
        }

        .dashboard {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            background-color: var(--dark);
            color: white;
            padding: 1.5rem;
            position: fixed;
            width: 250px;
            height: 100%;
            overflow-y: auto;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo {
            font-size: 1.2rem;
            font-weight: 700;
            color: white;
            display: flex;
            align-items: center;
        }

        .logo::before {
            content: "🏫";
            margin-right: 0.75rem;
            font-size: 1.5rem;
        }

        .nav-menu {
            list-style: none;
            margin-bottom: 2rem;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--gray-400);
            text-decoration: none;
            border-radius: var(--radius);
            transition: all 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-link::before {
            margin-right: 0.75rem;
            font-size: 1.2rem;
        }

        .nav-link.dashboard::before { content: "📊"; }
        .nav-link.students::before { content: "👨‍🎓"; }
        .nav-link.teachers::before { content: "👨‍🏫"; }
        .nav-link.classes::before { content: "🏛️"; }
        .nav-link.settings::before { content: "⚙️"; }

        /* Main Content */
        .main-content {
            grid-column: 2;
            padding: 2rem;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark);
        }

        .breadcrumb {
            display: flex;
            font-size: 0.875rem;
            color: var(--gray-500);
        }

        .breadcrumb span:not(:last-child)::after {
            content: "/";
            margin: 0 0.5rem;
            color: var(--gray-300);
        }

        .card {
            background-color: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            background-color: white;
            border-bottom: 1px solid var(--gray-200);
        }

        .card-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--dark);
        }

        .card-body {
            padding: 1.5rem;
        }

        .search-filter {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .search-box {
            flex: 1;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius);
            font-family: inherit;
            font-size: 0.95rem;
            transition: border-color 0.2s;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }

        .search-box::before {
            content: "🔍";
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
        }

        /* Table */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
        }

        th {
            background-color: var(--gray-100);
            font-weight: 600;
            color: var(--secondary);
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        tr {
            border-bottom: 1px solid var(--gray-200);
        }

        tr:last-child {
            border-bottom: none;
        }

        tr:hover {
            background-color: rgba(59, 130, 246, 0.05);
        }

        .avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 0.75rem;
        }

        .student-info {
            display: flex;
            align-items: center;
        }

        .student-name {
            font-weight: 500;
        }

        .student-id {
            font-size: 0.875rem;
            color: var(--gray-500);
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            text-align: center;
        }

        .badge-primary {
            background-color: rgba(59, 130, 246, 0.1);
            color: var(--primary);
        }

        .badge-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .btn-group {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: var(--radius);
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            font-family: inherit;
            font-size: 0.875rem;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.815rem;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--gray-300);
            color: var(--secondary);
        }

        .btn-outline:hover {
            background-color: var(--gray-100);
        }

        .btn-success {
            background-color: var(--success);
            color: white;
        }

        .btn-success:hover {
            background-color: #0da271;
        }

        .btn-danger {
            background-color: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        .btn-icon {
            width: 2rem;
            height: 2rem;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .pagination {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            border-radius: var(--radius);
            background-color: white;
            border: 1px solid var(--gray-300);
            color: var(--dark);
            text-decoration: none;
            transition: all 0.2s;
        }

        .page-link:hover, .page-link.active {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .page-info {
            color: var(--gray-500);
            font-size: 0.875rem;
            margin-right: 1rem;
        }

        @media (max-width: 1024px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                display: none;
            }
            
            .main-content {
                grid-column: 1;
            }
        }

        @media (max-width: 768px) {
            .search-filter {
                flex-direction: column;
            }
            
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            th, td {
                padding: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">Sistem Akademik</div>
            </div>
            
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="#" class="nav-link dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link students active">Data Siswa</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link teachers">Data Guru</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link classes">Kelas & Jurusan</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link settings">Pengaturan</a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Data Siswa</h1>
                    <div class="breadcrumb">
                        <span>Dashboard</span>
                        <span>Data Siswa</span>
                    </div>
                </div>
                <a href="tambah_data_siswa.php" class="btn btn-primary">+ Tambah Siswa</a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Daftar Siswa Terdaftar</h2>
                    <div class="search-filter">
                        <div class="search-box">
                            <input type="text" class="search-input" placeholder="Cari berdasarkan nama atau NISN...">
                        </div>
                        <button class="btn btn-outline">Filter</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Siswa</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Jurusan</th>
                                    <th>Kelas</th>
                                    <th>Alamat</th>
                                    <th>Agama</th>
                                    <th>No HP</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                foreach ($db->tampil_data_siswa() as $x) {
                                    $jenis_kelamin = ($x['jenis_kelamin'] == 'P') ? 'Perempuan' : 'Laki-laki';
                                    $initial = substr($x['nama'], 0, 1);
                                ?>
                                <tr>
                                    <td>
                                        <div class="student-info">
                                            <div class="avatar"><?php echo $initial; ?></div>
                                            <div>
                                                <div class="student-name"><?php echo $x['nama']; ?></div>
                                                <div class="student-id"><?php echo $x['nisn']; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo $jenis_kelamin; ?></td>
                                    <td><span class="badge badge-primary"><?php echo $x['nama_jurusan']; ?></span></td>
                                    <td><?php echo $x['kelas']; ?></td>
                                    <td><?php echo $x['alamat']; ?></td>
                                    <td><?php echo $x['nama_agama']; ?></td>
                                    <td><?php echo $x['no_hp']; ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="edit_siswa.php?nisn=<?= $x['nisn']; ?>" class="btn btn-sm btn-success">Edit</a>
                                            <a href="hapus_siswa.php?nisn=<?= $x['nisn']; ?>" class="btn btn-sm btn-danger">Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="pagination">
                        <span class="page-info">Menampilkan 1-10 dari 24 data</span>
                        <a href="#" class="page-link active">1</a>
                        <a href="#" class="page-link">2</a>
                        <a href="#" class="page-link">3</a>
                        <a href="#" class="page-link">›</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 