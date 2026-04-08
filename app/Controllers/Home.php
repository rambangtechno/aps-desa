<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // Mengarahkan ke view landing page
        return view('index_v');
    }
    
public function profil()
{
    // Sementara kita gunakan data array manual sebelum ditarik dari DB
    $data['kades'] = [
        [
            'nama' => 'H. Ahmad Syukri',
            'periode' => '2022 - Sekarang',
            'status' => 'aktif',
            'foto' => 'https://ui-avatars.com/api/?name=Ahmad+Syukri&size=200'
        ],
        [
            'nama' => 'Drs. M. Yusuf',
            'periode' => '2016 - 2022',
            'status' => 'mantan',
            'foto' => 'https://ui-avatars.com/api/?name=M+Yusuf&size=200'
        ],
        [
            'nama' => 'Hj. Siti Aminah',
            'periode' => '2010 - 2016',
            'status' => 'mantan',
            'foto' => 'https://ui-avatars.com/api/?name=Siti+Aminah&size=200'
        ]
    ];

    return view('profil_v', $data);
}
}