<?php
class database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "sekolah";

    private $port = "3307";

    public $koneksi;

    public function __construct() {
        $this->koneksi = new mysqli("localhost", "root", "", "sekolah", 3307);  

        if ($this->koneksi->connect_error) {
            die("Koneksi gagal: " . $this->koneksi->connect_error);
        }
    }

    public function tampil_data_siswa() {
        $hasil = [];
        $query = "SELECT siswa.*, jurusan.nama_jurusan, agama.nama_agama 
                  FROM siswa
                  LEFT JOIN jurusan ON siswa.kode_jurusan = jurusan.kode_jurusan
                  LEFT JOIN agama ON siswa.id_agama = agama.id_agama";
        $data = $this->koneksi->query($query);
        while ($row = $data->fetch_assoc()) {
            $hasil[] = $row;
        }
        return $hasil;
    }

    public function tampil_data_agama() {
        $hasil = [];
        $query = "SELECT * FROM agama";
        $data = $this->koneksi->query($query);
        while ($row = $data->fetch_assoc()) {
            $hasil[] = $row;
        }
        return $hasil;
    }

    public function tampil_data_jurusan() {
        $hasil = [];
        $query = "SELECT * FROM jurusan";
        $data = $this->koneksi->query($query);
        while ($row = $data->fetch_assoc()) {
            $hasil[] = $row;
        }
        return $hasil;
    }

    public function tambah_siswa($nisn, $nama, $jenis_kelamin, $kode_jurusan, $kelas, $alamat, $id_agama, $no_hp) {
        $query = "INSERT INTO siswa (nisn, nama, jenis_kelamin, kode_jurusan, kelas, alamat, id_agama, no_hp) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param("ississis", $nisn, $nama, $jenis_kelamin, $kode_jurusan, $kelas, $alamat, $id_agama, $no_hp);
        return $stmt->execute();
    }

    public function edit_siswa($nisn, $nama, $jenis_kelamin, $kode_jurusan, $kelas, $alamat, $id_agama, $no_hp) {
        $query = "UPDATE siswa SET nama=?, jenis_kelamin=?, kode_jurusan=?, kelas=?, alamat=?, id_agama=?, no_hp=? 
                  WHERE nisn=?";
        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param("ssissisi", $nama, $jenis_kelamin, $kode_jurusan, $kelas, $alamat, $id_agama, $no_hp, $nisn);
        return $stmt->execute();
    }

    public function hapus_siswa($nisn) {
        $query = "DELETE FROM siswa WHERE nisn=?";
        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param("i", $nisn);
        return $stmt->execute();
    }
}
?>
