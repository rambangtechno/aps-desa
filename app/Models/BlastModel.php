<?php

namespace App\Models;

use CodeIgniter\Model;

class BlastModel extends Model
{
    protected $table            = 'riwayat_blast';
    protected $primaryKey       = 'id_blast';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'judul_kegiatan', 'isi_pesan', 'total_penerima', 
        'status_pengiriman', 'dikirim_oleh'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // Kita hanya butuh created_at saja
}