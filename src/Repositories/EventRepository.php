<?php
namespace App\Repositories;

use App\Interfaces\EventRepositoryInterface;

class EventRepository implements EventRepositoryInterface {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAll() {
        $query = mysqli_query($this->conn, "SELECT * FROM event ORDER BY id DESC");
        $result = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        return $result;
    }

    public function getLatest($limit) {
        $limit = (int)$limit;
        $query = mysqli_query($this->conn, "SELECT * FROM event ORDER BY id DESC LIMIT $limit");
        $result = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
        return $result;
    }

    public function getById($id) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $query = mysqli_query($this->conn, "SELECT * FROM event WHERE id='$id'");
        return mysqli_fetch_assoc($query);
    }

    public function count() {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) as t FROM event");
        return mysqli_fetch_assoc($query)['t'];
    }

    public function create(array $data) {
        $judul = mysqli_real_escape_string($this->conn, $data['judul']);
        $deskripsi = mysqli_real_escape_string($this->conn, $data['deskripsi']);
        $tanggal = mysqli_real_escape_string($this->conn, $data['tanggal']);
        $lokasi = mysqli_real_escape_string($this->conn, $data['lokasi']);
        $gambar = mysqli_real_escape_string($this->conn, $data['gambar']);

        return mysqli_query($this->conn, "INSERT INTO event 
            (judul, deskripsi, tanggal, lokasi, gambar) 
            VALUES ('$judul', '$deskripsi', '$tanggal', '$lokasi', '$gambar')");
    }

    public function update($id, array $data) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $judul = mysqli_real_escape_string($this->conn, $data['judul']);
        $deskripsi = mysqli_real_escape_string($this->conn, $data['deskripsi']);
        $tanggal = mysqli_real_escape_string($this->conn, $data['tanggal']);
        $lokasi = mysqli_real_escape_string($this->conn, $data['lokasi']);
        $gambar = mysqli_real_escape_string($this->conn, $data['gambar']);

        return mysqli_query($this->conn, "UPDATE event SET 
            judul='$judul',
            deskripsi='$deskripsi',
            tanggal='$tanggal',
            lokasi='$lokasi',
            gambar='$gambar'
            WHERE id='$id'");
    }

    public function delete($id) {
        $id = mysqli_real_escape_string($this->conn, $id);
        return mysqli_query($this->conn, "DELETE FROM event WHERE id='$id'");
    }
}
