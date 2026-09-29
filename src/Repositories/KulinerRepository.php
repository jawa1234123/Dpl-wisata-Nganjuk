<?php
namespace App\Repositories;

use App\Interfaces\KulinerRepositoryInterface;

class KulinerRepository implements KulinerRepositoryInterface {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAll() {
        $query = mysqli_query($this->conn, "SELECT * FROM kuliner ORDER BY id DESC");
        $result = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        return $result;
    }

    public function getLatest($limit) {
        $limit = (int)$limit;
        $query = mysqli_query($this->conn, "SELECT * FROM kuliner ORDER BY id DESC LIMIT $limit");
        $result = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        return $result;
    }

    public function getById($id) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $query = mysqli_query($this->conn, "SELECT * FROM kuliner WHERE id='$id'");
        return mysqli_fetch_assoc($query);
    }

    public function count() {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) as t FROM kuliner");
        return mysqli_fetch_assoc($query)['t'];
    }

    public function create(array $data) {
        $nama = mysqli_real_escape_string($this->conn, $data['nama_kuliner']);
        $lokasi = mysqli_real_escape_string($this->conn, $data['lokasi']);
        $deskripsi = mysqli_real_escape_string($this->conn, $data['deskripsi']);
        $jam_buka = mysqli_real_escape_string($this->conn, $data['jam_buka']);
        $gambar = mysqli_real_escape_string($this->conn, $data['gambar']);

        return mysqli_query($this->conn, "INSERT INTO kuliner 
            (nama_kuliner, lokasi, deskripsi, jam_buka, gambar) 
            VALUES ('$nama', '$lokasi', '$deskripsi', '$jam_buka', '$gambar')");
    }

    public function update($id, array $data) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $nama = mysqli_real_escape_string($this->conn, $data['nama_kuliner']);
        $lokasi = mysqli_real_escape_string($this->conn, $data['lokasi']);
        $deskripsi = mysqli_real_escape_string($this->conn, $data['deskripsi']);
        $jam_buka = mysqli_real_escape_string($this->conn, $data['jam_buka']);
        $gambar = mysqli_real_escape_string($this->conn, $data['gambar']);

        return mysqli_query($this->conn, "UPDATE kuliner SET 
            nama_kuliner='$nama',
            lokasi='$lokasi',
            deskripsi='$deskripsi',
            jam_buka='$jam_buka',
            gambar='$gambar'
            WHERE id='$id'");
    }

    public function delete($id) {
        $id = mysqli_real_escape_string($this->conn, $id);
        return mysqli_query($this->conn, "DELETE FROM kuliner WHERE id='$id'");
    }
}
