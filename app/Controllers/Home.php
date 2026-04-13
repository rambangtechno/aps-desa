<?php

namespace App\Controllers;

// Panggil Model Kegiatan agar bisa ambil data koordinat
use App\Models\KegiatanModel;

class Home extends BaseController
{
    public function index(): string
    {
        $kegiatanModel = new \App\Models\KegiatanModel();

        $data = [
            'title'        => 'Beranda',
            // Tambahkan filter status Disetujui
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