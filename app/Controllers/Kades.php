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
    // Hitung Total Anggaran khusus untuk Dashboard Kades
    $total_anggaran = $this->kegiatanModel->selectSum('anggaran')->get()->getRow()->anggaran ?? 0;

    $data = [
        'title'          => 'Dashboard Kepala Desa',
        'total_kegiatan' => $this->kegiatanModel->countAllResults(),
        'total_pending'  => $this->kegiatanModel->where('status', 'Pending')->countAllResults(),
        'total_anggaran' => $total_anggaran, // Data pengganti Verifikasi User
        'kegiatan_map'   => $this->kegiatanModel->where('latitude !=', null)->findAll(),
    ];

    return view('kades/dashboard_v', $data);
}
    
    // 2. Fungsi Proses Persetujuan (ACC atau Tolak)
    // Di dalam class Kades
   public function proses_persetujuan($id, $status)
    {
        $persetujuanModel = new \App\Models\PersetujuanModel();
        $id_kades = session()->get('id'); 

        // 1. Ambil data kegiatan asli
        $kegiatan = $this->kegiatanModel->find($id);

        if (!$kegiatan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // 2. Siapkan data untuk tabel 'persetujuan_kegiatan' (Arsip)
        $dataArsip = [
            'kegiatan_id'         => $id,
            'kepala_desa_id'      => $id_kades,
            'status'              => $status, // Isinya "Disetujui"
            'lokasi'              => $kegiatan['lokasi'],
            'anggaran'            => $kegiatan['anggaran'],
            'tanggal_persetujuan' => date('Y-m-d H:i:s') // Pastikan kolom ini ada di database
        ];

        // 3. Proses Update & Insert (Gunakan Transaksi agar Aman)
        $db = \Config\Database::connect();
        $db->transStart();

        // Simpan ke tabel arsip
        $persetujuanModel->insert($dataArsip);
        
        // Update status di tabel kegiatan utama
        $this->kegiatanModel->update($id, ['status' => $status]);

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Gagal memproses data.');
        }

        return redirect()->to(base_url('kades/riwayat'))->with('success', 'Kegiatan Berhasil Disetujui!');
    }

    public function laporan()
        {
            $data = [
                'title'    => 'Persetujuan Laporan Kegiatan',
                // Ambil kegiatan yang perlu di-ACC oleh Kades
                'laporan'  => $this->kegiatanModel->orderBy('kegiatan_id', 'DESC')->findAll(),
            ];
            return view('kades/laporan_v', $data);
        }
  
        public function riwayat()
{
    $db = \Config\Database::connect();
    
    // Ambil data dengan Join agar nama kegiatan muncul
    $arsip = $db->table('persetujuan_kegiatan')
                ->select('persetujuan_kegiatan.*, kegiatan.judul_kegiatan')
                ->join('kegiatan', 'kegiatan.kegiatan_id = persetujuan_kegiatan.kegiatan_id')
                ->where('persetujuan_kegiatan.status', 'Disetujui') // Filter status
                ->get()
                ->getResultArray();

    $data = [
        'title' => 'Riwayat Persetujuan',
        'arsip' => $arsip, // Variabel ini harus dipakai di foreach View
    ];

    return view('kades/riwayat_v', $data);
}

public function persetujuan()
{
    $data = [
        'title'    => 'Daftar Persetujuan Kegiatan',
        // Ambil hanya yang statusnya 'Pending' untuk di-ACC
        'kegiatan' => $this->kegiatanModel->where('status', 'Pending')->findAll(),
    ];

    return view('kades/persetujuan_v', $data);
}
}