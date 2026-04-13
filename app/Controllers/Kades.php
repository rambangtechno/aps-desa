<?php

namespace App\Controllers;

use App\Models\KegiatanModel;
use App\Models\PersetujuanModel;

class Kades extends BaseController
{
    protected $kegiatanModel;
    protected $db;

    public function __construct()
    {
        $this->kegiatanModel = new KegiatanModel();
        $this->db = \Config\Database::connect(); // Inisialisasi database agar tidak error

        // PROTEKSI: Hanya Kepala Desa yang boleh masuk
        if (session()->get('role') !== 'kepala_desa') {
            header('Location: ' . base_url('admin'));
            exit();
        }
    }

    // public function index()
    // {
    //     $total_anggaran = $this->kegiatanModel->selectSum('anggaran')->get()->getRow()->anggaran ?? 0;

    //     $data = [
    //         'title'          => 'Dashboard Kepala Desa',
    //         'total_kegiatan' => $this->kegiatanModel->countAllResults(),
    //         'total_pending'  => $this->kegiatanModel->where('status', 'Pending')->countAllResults(),
    //         'total_anggaran' => $total_anggaran,
    //         'kegiatan_map'   => $this->kegiatanModel->where('latitude !=', null)->findAll(),
    //     ];

    //     return view('kades/dashboard_v', $data);
    // }
   public function index()
{
    $db = \Config\Database::connect();
    
    // 1. Ambil data peta (Variabel ini sering lupa dikirim sehingga Map error)
    $kegiatan_map = $db->table('kegiatan')
                       ->where('latitude !=', null)
                       ->where('longitude !=', null)
                       ->get()->getResultArray();

    // 2. Hitung Total Anggaran Disetujui
    $query_anggaran = $db->table('kegiatan')
                         ->selectSum('anggaran')
                         ->where('status', 'Disetujui')
                         ->get()
                         ->getRowArray();

    $data = [
        'title'          => 'Dashboard Kepala Desa',
        'total_kegiatan' => $db->table('kegiatan')->countAllResults(),
        'total_pending'  => $db->table('kegiatan')->where('status', 'Pending')->countAllResults(),
        'total_anggaran' => $query_anggaran['anggaran'] ?? 0, // Pastikan namanya sama dengan di view
        'kegiatan_map'   => $kegiatan_map, // Jangan lupa kirim ini untuk Leaflet Map
    ];

    return view('kades/dashboard_v', $data);
}
    public function persetujuan()
    {
        $data = [
            'title'    => 'Daftar Persetujuan Kegiatan',
            'kegiatan' => $this->kegiatanModel->where('status', 'Pending')->findAll(),
        ];
        return view('kades/persetujuan_v', $data);
    }

    public function proses_persetujuan($id, $status)
    {
        $persetujuanModel = new PersetujuanModel();
        $id_kades = session()->get('id'); 

        $kegiatan = $this->kegiatanModel->find($id);
        if (!$kegiatan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $this->db->transStart();

        // Simpan ke arsip
        $persetujuanModel->insert([
            'kegiatan_id'         => $id,
            'kepala_desa_id'      => $id_kades,
            'status'              => $status,
            'lokasi'              => $kegiatan['lokasi'],
            'anggaran'            => $kegiatan['anggaran'],
            'tanggal_persetujuan' => date('Y-m-d H:i:s')
        ]);
        
        // Update status utama
        $this->kegiatanModel->update($id, ['status' => $status]);

        $this->db->transComplete();

        if ($this->db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Gagal memproses data.');
        }

        return redirect()->to(base_url('kades/riwayat'))->with('success', 'Kegiatan Berhasil Disetujui!');
    }

   public function riwayat()
{
    $db      = \Config\Database::connect();
    $builder = $db->table('kegiatan');
    
    $tgl_mulai   = $this->request->getGet('tgl_mulai');
    $tgl_selesai = $this->request->getGet('tgl_selesai');

    // Filter status (Pastikan tulisan 'Disetujui' sama dengan di database)
    $builder->where('status', 'Disetujui');

    // Cek apakah kolom updated_at ada, jika tidak pakai created_at atau kolom lain
    $fields = $db->getFieldNames('kegiatan');
    $kolom_tgl = in_array('updated_at', $fields) ? 'updated_at' : (in_array('tanggal', $fields) ? 'tanggal' : 'kegiatan_id');

    if (!empty($tgl_mulai) && !empty($tgl_selesai)) {
        $builder->where("$kolom_tgl >=", $tgl_mulai . ' 00:00:00');
        $builder->where("$kolom_tgl <=", $tgl_selesai . ' 23:59:59');
    }

    $data = [
        'title'       => 'Riwayat Persetujuan',
        'arsip'       => $builder->orderBy($kolom_tgl, 'DESC')->get()->getResultArray(),
        'tgl_mulai'   => $tgl_mulai,
        'tgl_selesai' => $tgl_selesai,
        'kolom_tgl'   => $kolom_tgl // Kita kirim nama kolomnya ke view
    ];

    return view('kades/riwayat_v', $data);
}
}