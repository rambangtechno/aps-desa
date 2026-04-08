<?php

namespace App\Controllers;

use App\Models\KegiatanModel;
use App\Models\PersetujuanModel;

class Kades extends BaseController
{
    protected $kegiatanModel;

    public function __construct()
    {
        $this->kegiatanModel = new KegiatanModel();

        // PROTEKSI: Hanya Kepala Desa yang boleh masuk ke Controller ini
        if (session()->get('role') !== 'kepala_desa') {
            // Gunakan redirect standar CI4
            header('Location: ' . base_url('admin'));
            exit();
        }
    }

    public function index()
    {
        $data = [
            'title'    => 'Panel Persetujuan Kepala Desa',
            'kegiatan' => $this->kegiatanModel->where('status', 'Pending')->findAll()
        ];

        // Perhatikan path filenya: kades/persetujuan_v
        return view('kades/persetujuan_v', $data);
    }
    // 2. Fungsi Proses Persetujuan (ACC atau Tolak)
    // Di dalam class Kades
    public function proses_persetujuan($id, $status)
{
    $persetujuanModel = new \App\Models\PersetujuanModel();
    
    // 1. Ambil data kegiatan
    $kegiatan = $this->kegiatanModel->find($id);

    if (!$kegiatan) {
        return redirect()->back()->with('error', 'Data kegiatan tidak ditemukan.');
    }

    // 2. AMBIL SESSION ID (Harus 'id' sesuai dengan Auth kamu)
    $id_kades = session()->get('id'); 

    if (!$id_kades) {
        return redirect()->to('/')->with('error', 'Sesi Anda habis, silakan login kembali.');
    }

    // 3. Siapkan data arsip
    $dataArsip = [
        'kegiatan_id'         => $id,
        'kepala_desa_id'      => $id_kades,
        'status'              => $status,
        'lokasi'              => $kegiatan['lokasi'],
        'anggaran'            => $kegiatan['anggaran'],
        'tanggal_persetujuan' => date('Y-m-d')
    ];

    // 4. Proses Simpan
    $db = \Config\Database::connect();
    $db->transStart();

    $persetujuanModel->insert($dataArsip);
    $this->kegiatanModel->update($id, ['status' => $status]);

    $db->transComplete();

    if ($db->transStatus() === FALSE) {
        return redirect()->back()->with('error', 'Gagal memproses persetujuan.');
    }

    return redirect()->to('/kades')->with('success', 'Kegiatan berhasil diproses.');
}

    // public function laporan()
    // {
    //     $persetujuanModel = new \App\Models\PersetujuanModel();

    //     // Mengambil data arsip dan menggabungkannya dengan judul kegiatan dari tabel kegiatan
    //     $data = [
    //         'title' => 'Laporan Persetujuan Kegiatan',
    //         'arsip' => $persetujuanModel->select('persetujuan_kegiatan.*, kegiatan.judul_kegiatan')
    //                                     ->join('kegiatan', 'kegiatan.kegiatan_id = persetujuan_kegiatan.kegiatan_id')
    //                                     ->findAll()
    //     ];

    //     return view('kades/laporan_v', $data);
    // }
}