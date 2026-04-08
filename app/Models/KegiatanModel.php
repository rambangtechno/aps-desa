<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    // Nama tabel di database
    protected $table            = 'kegiatan';
    
    // Nama Primary Key
    protected $primaryKey       = 'kegiatan_id';
    
    // Auto Increment aktif
    protected $useAutoIncrement = true;
    
    // Tipe data yang dikembalikan (array)
    protected $returnType       = 'array';
    
    // Field yang boleh diisi (WAJIB didaftarkan agar bisa simpan data)
    protected $allowedFields    = [
        'judul_kegiatan', 
        'deskripsi', 
        'tanggal', 
        'lokasi', 
        'anggaran', 
        'status', 
        'foto'
    ];

    // Aktifkan pencatatan waktu otomatis
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    /**
     * Fungsi tambahan untuk mengambil kegiatan berdasarkan status
     * Berguna untuk halaman Kepala Desa nanti
     */
    public function getPendingKegiatan()
    {
        return $this->where('status', 'Pending')->findAll();
    }
}