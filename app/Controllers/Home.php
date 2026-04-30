<?php

namespace App\Controllers;

// Panggil Model Kegiatan agar bisa ambil data koordinat
use App\Models\KegiatanModel;

class Home extends BaseController
{
  public function index(): string
{
    $kegiatanModel = new \App\Models\KegiatanModel();
    $db = \Config\Database::connect();

    // Mengambil data dari tabel master_kades yang aktif
    // Ini memastikan data yang muncul sinkron dengan fitur 'Input Kepala Desa'
    $kades = $db->table('master_kades')->where('is_active', 1)->get()->getRowArray();

    $data = [
        'title'        => 'Beranda',
        'kades'        => $kades, 
        'kegiatan_map' => $kegiatanModel->where('status', 'Disetujui')
                                        ->where('latitude !=', null)
                                        ->where('longitude !=', null)
                                        ->findAll(),
    ];

    return view('index_v', $data);
}
    public function profil()
    {
        // Data Kades tetap seperti yang kamu buat
        $data['kades'] = [
            [
                'nama' => 'H. Ahmad Syukri',
                'periode' => '2022 - Sekarang',
                'status' => 'aktif',
                'foto' => 'https://ui-avatars.com/api/?name=Ahmad+Syukri&size=200'
            ],
            // ... data kades lainnya
        ];

        return view('profil_v', $data);
    }
}