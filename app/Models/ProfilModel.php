<?php namespace App\Models;
use CodeIgniter\Model;

class ProfilModel extends Model {
    protected $table = 'profil_desa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_desa', 'alamat', 'email', 'telepon', 'sejarah', 'logo'];
}