<?php

namespace App\Controllers;

use App\Models\KegiatanModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    protected $kegiatanModel;
    protected $userModel;

    public function __construct()
    {
        // Panggil model agar bisa digunakan di semua fungsi
        $this->kegiatanModel = new KegiatanModel();
        $this->userModel = new UserModel();

        // PROTEKSI: Cek apakah user sudah login
        if (!session()->get('logged_in')) {
            // Jika belum login, tendang ke halaman login utama
            return redirect()->to('/')->with('error', 'Sesi berakhir, silakan login kembali.')->send();
        }
    }

    // 1. Menampilkan Halaman Dashboard Utama Admin
public function index()
{
    $db = \Config\Database::connect();
    
    $data = [
        'title'          => 'Dashboard Admin',
        // Data untuk Peta GIS
        'kegiatan_map'   => $db->table('kegiatan')
                               ->where('latitude !=', null)
                               ->get()->getResultArray(),
        // Data Statistik Dashboard
        'total_kegiatan' => $this->kegiatanModel->countAll(),
        'total_pending'  => $this->kegiatanModel->where('status', 'Pending')->countAll(),
        'user_pending'   => $this->userModel->where('is_active', 0)->countAll(),
    ];

    return view('admin/dashboard_v', $data);
}

    // 2. Menampilkan Daftar Kegiatan Desa
    public function kegiatan()
    {
        $data = [
            'title'    => 'Manajemen Kegiatan Desa',
            'kegiatan' => $this->kegiatanModel->findAll()
        ];

        return view('admin/kegiatan_v', $data);
    }

    public function simpan_kegiatan()
    {
        // 1. Ambil SEMUA file foto (Multiple)
        $files = $this->request->getFileMultiple('foto');
        $namaFiles = [];

        // 2. Looping setiap file yang diunggah
        if ($files) {
            foreach ($files as $file) {
                // Cek apakah file valid dan belum dipindah
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName(); // Beri nama acak unik
                    $file->move('uploads/kegiatan/', $newName); // Pindahkan ke folder public
                    $namaFiles[] = $newName; // Simpan namanya ke array
                }
            }
        }

        // 3. Siapkan data untuk Database
        $data_simpan = [
            'judul_kegiatan' => $this->request->getPost('judul_kegiatan'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'tanggal'        => $this->request->getPost('tanggal'),
            'lokasi'         => $this->request->getPost('lokasi'),
            'latitude'       => $this->request->getPost('latitude'),
            'longitude'      => $this->request->getPost('longitude'),
            'anggaran'       => $this->request->getPost('anggaran'),
            'status'         => 'Pending',
            // PENTING: Ubah array nama file menjadi string JSON agar bisa masuk ke 1 kolom DB
            'foto'           => json_encode($namaFiles), 
            'created_at'     => date('Y-m-d H:i:s')
        ];

        // 4. Eksekusi Simpan
        if ($this->kegiatanModel->save($data_simpan)) {
            return redirect()->to('/admin/kegiatan')->with('success', 'Berhasil menyimpan ' . count($namaFiles) . ' foto kegiatan!');
        } else {
            return redirect()->back()->with('error', 'Gagal menyimpan data ke database.');
        }
    }

    // FUNGSI UPDATE KEGIATAN (Di dalam class Admin)
    public function update_kegiatan($id)
    {
        // 1. Validasi Akses (Opsional, tapi penting untuk keamanan TA)
        if (!session()->get('logged_in')) {
            return redirect()->to('/')->with('error', 'Sesi berakhir, silakan login kembali.');
        }

        // 2. Persiapkan Data yang Akan Diupdate (Non-Foto)
        $data_update = [
            'judul_kegiatan' => $this->request->getPost('judul_kegiatan'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'tanggal'        => $this->request->getPost('tanggal'),
            'lokasi'         => $this->request->getPost('lokasi'),
        ];

        // 3. Ambil File Foto Baru (Multiple)
        // Gunakan getFileMultiple('foto') karena inputnya name="foto[]"
        $files = $this->request->getFileMultiple('foto');
        $namaFilesBaru = [];

        // 4. Looping untuk Setiap File yang Diunggah
        if ($files) {
            foreach ($files as $file) {
                // Cek apakah file valid dan belum dipindah
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName(); // Beri nama acak unik
                    $file->move('uploads/kegiatan/', $newName); // Pindahkan ke folder public/uploads/kegiatan
                    $namaFilesBaru[] = $newName; // Masukkan namanya ke array foto baru
                }
            }
        }

        // 5. Cek Apakah Ada Foto yang Diupload
        if (!empty($namaFilesBaru)) {
            // Jika ada foto baru, kita ambil data kegiatan lama untuk menghapus foto lamanya
            $kegiatanLama = $this->kegiatanModel->find($id);
            
            // Cek apakah ada foto lama (dalam format JSON)
            if ($kegiatanLama['foto']) {
                $fotoLamaArray = json_decode($kegiatanLama['foto'], true);
                if (is_array($fotoLamaArray)) {
                    // Hapus semua file foto lama secara fisik dari folder uploads
                    foreach ($fotoLamaArray as $fl) {
                        if (file_exists('uploads/kegiatan/' . $fl)) {
                            unlink('uploads/kegiatan/' . $fl);
                        }
                    }
                }
            }

            // Simpan daftar nama foto baru ke dalam format JSON
            $data_update['foto'] = json_encode($namaFilesBaru);
        }

        // 6. Eksekusi Update ke Database
        if ($this->kegiatanModel->update($id, $data_update)) {
            return redirect()->to('/admin/kegiatan')->with('success', 'Data kegiatan berhasil diperbarui!');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate data.');
        }
    }
    // FUNGSI HAPUS
    public function hapus_kegiatan($id)
    {
        // Ambil data untuk hapus file fisik fotonya juga
        $kegiatan = $this->kegiatanModel->find($id);
        if ($kegiatan['foto'] && file_exists('uploads/kegiatan/' . $kegiatan['foto'])) {
            unlink('uploads/kegiatan/' . $kegiatan['foto']);
        }

        $this->kegiatanModel->delete($id);
        return redirect()->back()->with('success', 'Kegiatan telah dihapus.');
    }
    // 4. Fitur Verifikasi User (Khusus Role Admin)
    public function verifikasi_user()
    {
        // Cek apakah yang login beneran admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Hanya Admin Utama yang bisa memverifikasi akun.');
        }

        $data = [
            'title'        => 'Verifikasi Akun Pengguna',
            'pending_user' => $this->userModel->where('is_active', 0)->findAll()
        ];

        return view('admin/verifikasi_v', $data);
    }

    // Tambahkan ini di dalam class Admin
    public function aktivasi_user($id)
    {
        // Hanya admin yang bisa eksekusi ini
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/admin')->with('error', 'Akses ditolak.');
        }

        // Update status is_active menjadi 1
        if ($this->userModel->update($id, ['is_active' => 1])) {
            return redirect()->to('/admin/verifikasi_user')->with('success', 'Akun berhasil diverifikasi! Sekarang user tersebut sudah bisa login.');
        } else {
            return redirect()->back()->with('error', 'Gagal memproses verifikasi.');
        }
    }

 public function form_cetak()
{
    $db = \Config\Database::connect();
    $data = [
        'title' => 'Form Cetak Laporan Resmi',
        'kades' => $db->table('master_kades')->where('is_active', 1)->get()->getResultArray()
    ];
    return view('admin/form_cetak_v', $data);
}

public function proses_cetak()
{
    $id_kades = $this->request->getPost('id_kades');
    $tgl_surat = $this->request->getPost('tanggal_surat');

    $db = \Config\Database::connect();
    $kades = $db->table('master_kades')->where('id_kades', $id_kades)->get()->getRowArray();
    
    $persetujuanModel = new \App\Models\PersetujuanModel();
    $data = [
        'kades'     => $kades,
        'tgl_surat' => $tgl_surat,
        'arsip'     => $persetujuanModel->select('persetujuan_kegiatan.*, kegiatan.judul_kegiatan')
                                        ->join('kegiatan', 'kegiatan.kegiatan_id = persetujuan_kegiatan.kegiatan_id')
                                        ->findAll()
    ];
    return view('admin/cetak_laporan_resmi', $data);
}

public function kelola_kades()
{
    $db = \Config\Database::connect();
    $data = [
        'title' => 'Kelola Kepala Desa',
        'kades' => $db->table('master_kades')->get()->getResultArray()
    ];
    return view('admin/kelola_kades_v', $data);
}

public function simpan_kades()
{
    $db = \Config\Database::connect();
    $data = [
        'nama_kades' => $this->request->getPost('nama_kades'),
        'nip'        => $this->request->getPost('nip'),
        'jabatan'    => $this->request->getPost('jabatan'),
        'is_active'  => 1
    ];
    
    // Nonaktifkan kades lainnya dulu agar hanya 1 yang aktif
    $db->table('master_kades')->update(['is_active' => 0]);
    
    // Simpan kades baru
    $db->table('master_kades')->insert($data);
    return redirect()->back()->with('success', 'Data Kepala Desa berhasil diperbarui.');
}

public function print_laporan()
{
    $db = \Config\Database::connect();
    $persetujuanModel = new \App\Models\PersetujuanModel();

    // Mengambil data arsip persetujuan digabung dengan judul kegiatan
    $arsip = $persetujuanModel->select('persetujuan_kegiatan.*, kegiatan.judul_kegiatan')
                              ->join('kegiatan', 'kegiatan.kegiatan_id = persetujuan_kegiatan.kegiatan_id')
                              ->findAll();

    $data = [
        'title' => 'Cetak Laporan Resmi Desa',
        'arsip' => $arsip,
        'db'    => $db // WAJIB ADA agar view tidak error "Whoops"
    ];

    return view('admin/cetak_laporan_resmi', $data);
}

public function sebaran_kegiatan()
{
    $db = \Config\Database::connect();
    // Ambil kegiatan yang sudah disetujui dan memiliki koordinat
    $data['kegiatan'] = $db->table('kegiatan')
                           ->where('latitude !=', null)
                           ->get()->getResultArray();
    
    $data['title'] = "Sebaran Lokasi Kegiatan";
    return view('admin/sebaran_v', $data);
}
}