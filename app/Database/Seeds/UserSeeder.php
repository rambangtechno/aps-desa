<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username'     => 'admin',
            'password'     => password_hash('desa123', PASSWORD_DEFAULT),
            'nama_lengkap' => 'Administrator Desa',
            'role'         => 'admin',
            'created_at'   => date('Y-m-d H:i:s'),
        ];

        // Memasukkan data ke tabel users
        $this->db->table('users')->insert($data);
    }
}
