<?php

function get_profil_desa()
{
    try {
        $db = \Config\Database::connect();
        $builder = $db->table('profil_desa');
        $profil = $builder->where('id', 1)->get()->getRowArray();

        if ($profil) {
            return $profil;
        }
    } catch (\Exception $e) {
        // Jika error, biarkan lanjut ke return default di bawah
    }

    // Data Default jika database error atau tabel kosong
    return [
        'nama_desa' => 'Desa Segarau Parit',
        'logo'      => ''
    ];
}