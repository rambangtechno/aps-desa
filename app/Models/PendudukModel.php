<?php

namespace App\Models;

use CodeIgniter\Model;

class PendudukModel extends Model
{
    protected $table            = 'penduduk';
    protected $primaryKey       = 'id_penduduk';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'nik', 'nama_penduduk', 'jenis_kelamin', 
        'no_wa', 'alamat', 'dusun', 'rt', 'rw', 'status_aktif'
    ];

    // Dates
    protected $useTimestamps = true;
}