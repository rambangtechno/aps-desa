<?php

namespace App\Models;

use CodeIgniter\Model;

class PersetujuanModel extends Model
{
    // PASTIKAN NAMA TABEL SAMA PERSIS DENGAN DI PHPMYADMIN
    protected $table            = 'persetujuan_kegiatan'; 
    protected $primaryKey       = 'persetujuan_id'; // Cek apakah ID-nya benar ini?
    protected $allowedFields    = ['kegiatan_id', 'kepala_desa_id', 'status', 'lokasi', 'anggaran', 'tanggal_persetujuan'];
}