<?php
namespace App\Interfaces;

interface KulinerRepositoryInterface {
    public function getAll();
    public function getLatest($limit);
    public function getById($id);
    public function count();
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
