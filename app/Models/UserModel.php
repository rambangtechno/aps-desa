<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    
    // Pastikan semua field ini ada di tabel database
    protected $allowedFields = ['username', 'password', 'nama_lengkap', 'role', 'is_active', 'created_at'];

    // Dates Settings
    protected $useTimestamps = false; // Ubah jadi false karena kamu isi manual di Controller
    // Atau jika ingin otomatis, pastikan kolom updated_at ada di database. 
    // Untuk sekarang, kita buat false dulu agar tidak error.

    protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at'; // Komentari jika kolomnya tidak ada di DB
}