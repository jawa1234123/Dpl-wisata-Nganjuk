<?php
namespace App\Repositories;

use App\Interfaces\WisataRepositoryInterface;

class WisataRepository implements WisataRepositoryInterface {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAll() {
        $query = mysqli_query($this->conn, "SELECT * FROM wisata ORDER BY id DESC");
        $result = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        return $result;
    }

    public function getLatest($limit) {
        $limit = (int)$limit;
        $query = mysqli_query($this->conn, "SELECT * FROM wisata ORDER BY id DESC LIMIT $limit");
        $result = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        return $result;
    }

    public function getById($id) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $query = mysqli_query($this->conn, "SELECT * FROM wisata WHERE id='$id'");
        return mysqli_fetch_assoc($query);
    }

    public function count() {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) as t FROM wisata");
        return mysqli_fetch_assoc($query)['t'];
    }

    public function create(array $data) {
        $nama = mysqli_real_escape_string($this->conn, $data['nama']);
        $deskripsi = mysqli_real_escape_string($this->conn, $data['deskripsi']);
        $lokasi = mysqli_real_escape_string($this->conn, $data['lokasi']);
        $kategori = mysqli_real_escape_string($this->conn, $data['kategori']);
        $gambar = mysqli_real_escape_string($this->conn, $data['gambar']);
        $latitude = mysqli_real_escape_string($this->conn, $data['latitude']);
        $longitude = mysqli_real_escape_string($this->conn, $data['longitude']);

        return mysqli_query($this->conn, "INSERT INTO wisata 
            (nama, deskripsi, lokasi, kategori, gambar, latitude, longitude)
            VALUES 
            ('$nama', '$deskripsi', '$lokasi', '$kategori', '$gambar', '$latitude', '$longitude')");
    }

    public function update($id, array $data) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $nama = mysqli_real_escape_string($this->conn, $data['nama']);
        $deskripsi = mysqli_real_escape_string($this->conn, $data['deskripsi']);
        $lokasi = mysqli_real_escape_string($this->conn, $data['lokasi']);
        $kategori = mysqli_real_escape_string($this->conn, $data['kategori']);
        $gambar = mysqli_real_escape_string($this->conn, $data['gambar']);
        $latitude = mysqli_real_escape_string($this->conn, $data['latitude']);
        $longitude = mysqli_real_escape_string($this->conn, $data['longitude']);

        return mysqli_query($this->conn, "UPDATE wisata SET 
            nama='$nama',
            deskripsi='$deskripsi',
            lokasi='$lokasi',
            kategori='$kategori',
            gambar='$gambar',
            latitude='$latitude',
            longitude='$longitude'
            WHERE id='$id'");
    }

    public function delete($id) {
        $id = mysqli_real_escape_string($this->conn, $id);
        return mysqli_query($this->conn, "DELETE FROM wisata WHERE id='$id'");
    }
}
