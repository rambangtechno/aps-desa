<?php

namespace App\Models;

use CodeIgniter\Model;

class PersetujuanModel extends Model
{
    protected $table            = 'persetujuan_kegiatan';
    protected $primaryKey       = 'persetujuan_id';
    protected $allowedFields    = [
        'kegiatan_id', 
        'kepala_desa_id', 
        'status', 
        'lokasi', 
        'anggaran', 
        'tanggal_persetujuan'
    ];
}