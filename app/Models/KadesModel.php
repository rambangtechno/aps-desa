<?php

namespace App\Models;

use CodeIgniter\Model;

class KadesModel extends Model
{
    // Nama tabel di database sesuai gambar database Anda
    protected $table            = 'kades';
    
    // Nama primary key tabel Anda
    protected $primaryKey       = 'id_kades';

    // Izinkan kolom-kolom ini untuk diisi melalui form (Mass Assignment)
    // Pastikan nama kolom sama persis dengan di database
    protected $allowedFields    = [
        'nama_kades', 
        'nip', 
        'jabatan', 
        'foto', 
        'is_active'
    ];

    // Opsional: Aktifkan pencatatan waktu otomatis jika Anda punya kolom created_at
    protected $useTimestamps = false;
}