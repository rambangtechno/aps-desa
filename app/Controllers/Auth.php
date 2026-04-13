<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        return redirect()->to('/');
    }

    public function dashboard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/')->with('error', 'Silakan login terlebih dahulu.');
        }
        return view('dashboard_v');
    }

    public function loginProcess()
{
    $session = session();
    $model = new UserModel();

    $username = $this->request->getVar('username');
    $password = $this->request->getVar('password');

    if (empty($username) || empty($password)) {
        return redirect()->back()->with('error', 'Username dan Password wajib diisi!');
    }

    $user = $model->where('username', $username)->first();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            
            // 1. Cek Status Aktivasi
            if ($user['is_active'] == 0) {
                return redirect()->back()->with('error', 'Akun Anda belum diverifikasi oleh Admin Desa.');
            }

            // 2. Simpan Data ke Session
            $session->set([
                'id'         => $user['id'],
                'username'   => $user['username'],
                'nama'       => $user['nama_lengkap'],
                'role'       => $user['role'],
                'logged_in'  => true,
            ]);

            // 3. LOGIKA REDIRECT BERDASARKAN ROLE kepala_desa
            if ($user['role'] == 'admin') {
                return redirect()->to(base_url('admin'))->with('success', 'Selamat Datang Admin!');
            } elseif ($user['role'] == 'kepala_desa') { // Pastikan sama dengan di database
                return redirect()->to(base_url('kades'))->with('success', 'Selamat Datang Bapak Kepala Desa!');
            } else {
                return redirect()->to(base_url('/'))->with('error', 'Role tidak dikenali.');
            }
            
        } else {
            return redirect()->back()->with('error', 'Password salah.');
        }
    } else {
        return redirect()->back()->with('error', 'Username tidak terdaftar.');
    }
}
    public function registerProcess()
    {
        $model = new UserModel();

        $data = [
            'username'     => $this->request->getVar('username'),
            'password'     => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'role'         => $this->request->getVar('role'),
            'is_active'    => 0, 
            'created_at'   => date('Y-m-d H:i:s')
        ];

        // Validasi username ganda
        if ($model->where('username', $data['username'])->first()) {
            return redirect()->back()->with('error', 'Username sudah digunakan!');
        }

        // PROSES INSERT (Hanya satu kali saja)
        if ($model->insert($data)) {
            // Kita pakai success_register agar SweetAlert di view bisa membedakan alert biasa dan alert verifikasi
            return redirect()->to('/')->with('success_register', 'Pendaftaran Berhasil! Mohon tunggu verifikasi dari Admin Desa sebelum dapat login.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

   public function logout()
    {
        $session = session();
        $session->destroy();

        // Balikkan ke landing page dengan pesan sukses
        return redirect()->to('/')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}