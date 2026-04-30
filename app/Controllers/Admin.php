<?php

namespace App\Controllers;

use App\Models\KegiatanModel;
use App\Models\UserModel;
use App\Models\PendudukModel;
use App\Models\BlastModel;
// Tambahkan ini di bagian paling atas file (setelah namespace)
use App\Models\KadesModel;



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
        
        // Data untuk Peta GIS (Hanya ambil yang koordinatnya lengkap)
        'kegiatan_map'   => $db->table('kegiatan')
                               ->where('latitude !=', null)
                               ->where('longitude !=', null)
                               ->get()->getResultArray(),

        // Data Statistik Dashboard (Realtime)
        'total_kegiatan' => $this->kegiatanModel->countAllResults(),
        
        // Hitung yang statusnya Pending
        'total_pending'  => $this->kegiatanModel->where('status', 'Pending')->countAllResults(),
        
        // Hitung User yang belum aktif (is_active = 0)
        'user_pending'   => $this->userModel->where('is_active', 0)->countAllResults(),
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
public function aktivasi_user($id, $status)
{
    // Misal nama kolomnya 'is_active' atau 'status'
    // Sesuaikan dengan model user kamu
    $this->userModel->update($id, [
        'is_active' => $status 
    ]);

    return redirect()->to(base_url('admin/verifikasi_user'))->with('success', 'Akun berhasil diverifikasi!');
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
public function kades()
{
    // Mengarahkan ke fungsi kelola_kades yang sudah ada
    return $this->kelola_kades();
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

// public function simpan_kades()
// {
//     $db = \Config\Database::connect();
//     $data = [
//         'nama_kades' => $this->request->getPost('nama_kades'),
//         'nip'        => $this->request->getPost('nip'),
//         'jabatan'    => $this->request->getPost('jabatan'),
//         'is_active'  => 1
//     ];
    
//     // Nonaktifkan kades lainnya dulu agar hanya 1 yang aktif
//     $db->table('master_kades')->update(['is_active' => 0]);
    
//     // Simpan kades baru
//     $db->table('master_kades')->insert($data);
//     return redirect()->back()->with('success', 'Data Kepala Desa berhasil diperbarui.');
// }
public function simpan_kades()
{
    // 1. Ambil file foto
    $foto = $this->request->getFile('foto');
    
    // 2. Validasi dan pindahkan foto
    if ($foto && $foto->isValid() && !$foto->hasMoved()) {
        $namaFoto = $foto->getRandomName();
        $foto->move('uploads/kades', $namaFoto);
    } else {
        return redirect()->back()->with('error', 'Gagal mengunggah foto.');
    }

    // 3. Gunakan Query Builder agar konsisten dengan tabel 'master_kades'
    // yang sudah Anda gunakan di fungsi kelola_kades()
    $db = \Config\Database::connect();
    
    $data = [
        'nama_kades' => $this->request->getPost('nama_kades'),
        'nip'        => $this->request->getPost('nip'),
        'jabatan'    => $this->request->getPost('jabatan'),
        'foto'       => $namaFoto,
        'is_active'  => 0 // Default non-aktif
    ];

    if ($db->table('master_kades')->insert($data)) {
        // Redirect ke halaman kelola_kades (sesuaikan dengan rute Anda)
        return redirect()->to(base_url('admin/kelola_kades'))->with('success', 'Data Berhasil Disimpan!');
    } else {
        return redirect()->back()->with('error', 'Gagal menyimpan ke database.');
    }
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

public function profil_desa()
{
    $db = \Config\Database::connect();
    $data = [
        'title' => 'Profil Desa',
        'desa'  => $db->table('profil_desa')->where('id', 1)->get()->getRowArray(),
    ];
    return view('admin/profil_desa_v', $data);
}

public function update_profil()
{
    $db = \Config\Database::connect();
    $id = $this->request->getPost('id');
    $fileLogo = $this->request->getFile('logo');
    $logoLama = $this->request->getPost('logo_lama');

    $data = [
        'nama_desa' => $this->request->getPost('nama_desa'),
        'alamat'    => $this->request->getPost('alamat'),
        'telepon'   => $this->request->getPost('telepon'),
        'email'     => $this->request->getPost('email'),
        'latitude'  => $this->request->getPost('latitude'),
        'longitude' => $this->request->getPost('longitude'),
        'sejarah'   => $this->request->getPost('sejarah'),
        'updated_at'=> date('Y-m-d H:i:s')
    ];

    // Cek jika ada file logo baru yang diupload
    if ($fileLogo->isValid() && !$fileLogo->hasMoved()) {
        $namaLogo = $fileLogo->getRandomName();
        $fileLogo->move('uploads/profil/', $namaLogo);
        
        $data['logo'] = $namaLogo;

        // Hapus logo lama jika ada (biar folder tidak penuh)
        if ($logoLama && file_exists('uploads/profil/' . $logoLama)) {
            unlink('uploads/profil/' . $logoLama);
        }
    }

    $db->table('profil_desa')->where('id', $id)->update($data);
    return redirect()->back()->with('success', 'Profil dan Logo Desa berhasil diperbarui!');
}

public function kelola_user()
{
    // Tangkap keyword pencarian
    $keyword = $this->request->getVar('keyword');
    
    if ($keyword) {
        $users = $this->userModel->like('nama_lengkap', $keyword)
                                 ->orLike('username', $keyword)
                                 ->findAll();
    } else {
        $users = $this->userModel->findAll();
    }

    $data = [
        'title'   => 'Manajemen Pengguna',
        'users'   => $users,
        'keyword' => $keyword
    ];
    return view('admin/kelola_user_v', $data);
}

public function hapus_user($id)
{
    // Proteksi agar admin tidak menghapus akunnya sendiri yang sedang login
    if ($id == session()->get('id')) {
        return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
    }

    $this->userModel->delete($id);
    return redirect()->to('/admin/kelola_user')->with('success', 'User berhasil dihapus.');
}

public function update_user($id)
{
    $data = [
        'nama_lengkap' => $this->request->getVar('nama_lengkap'),
        'username'     => $this->request->getVar('username'),
        'role'         => $this->request->getVar('role'),
    ];

    // Jika password diisi, maka update passwordnya
    $password = $this->request->getVar('password');
    if (!empty($password)) {
        $data['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    $this->userModel->update($id, $data);
    return redirect()->to('/admin/kelola_user')->with('success', 'Data user berhasil diperbarui.');
}

// Di dalam class Admin:
public function penduduk()
{
    $model = new PendudukModel();
    $data = [
        'title'    => 'Data Penduduk',
        'penduduk' => $model->findAll()
    ];
    return view('admin/penduduk_v', $data);
}

public function penduduk_simpan()
{
    $model = new PendudukModel();
    $model->save([
        'nik'           => $this->request->getPost('nik'),
        'nama_penduduk' => $this->request->getPost('nama_penduduk'),
        'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
        'no_wa'         => $this->request->getPost('no_wa'),
        'dusun'         => $this->request->getPost('dusun'),
        'status_aktif'  => 'Ya'
    ]);

    return redirect()->to(base_url('admin/penduduk'))->with('success', 'Data warga berhasil ditambahkan!');
}

public function penduduk_hapus($id)
{
    $model = new PendudukModel();
    $model->delete($id);
    return redirect()->to(base_url('admin/penduduk'))->with('success', 'Data warga telah dihapus!');
}
public function blast()
{
    $db = \Config\Database::connect();
    
    // Ambil daftar dusun yang unik dari tabel penduduk
    $list_dusun = $db->table('penduduk')
                     ->select('dusun')
                     ->groupBy('dusun')
                     ->get()
                     ->getResultArray();

    $data = [
        'title'          => 'WA Blast Notifikasi',
        'kegiatan'       => $db->table('kegiatan')->where('status', 'Disetujui')->get()->getResultArray(),
        'total_penerima' => $db->table('penduduk')->where('status_aktif', 'Ya')->countAllResults(),
        'riwayat'        => $db->table('riwayat_blast')->orderBy('id_blast', 'DESC')->limit(5)->get()->getResultArray(),
        'list_dusun'     => $list_dusun // Kirim data dusun ke view
    ];

    return view('admin/blast_v', $data);
}
// public function proses_blast()
// {
//     $db = \Config\Database::connect();
//     $pesan = $this->request->getPost('pesan');
//     $judul = $this->request->getPost('judul');

//     // 1. Ambil data nomor WA warga yang aktif
//     $warga = $db->table('penduduk')->where('status_aktif', 'Ya')->get()->getResultArray();
    
//     if (empty($warga)) {
//         return $this->response->setJSON(['status' => 'error', 'msg' => 'Tidak ada nomor penduduk aktif di database.']);
//     }

//     // 2. Bersihkan nomor (Pastikan hanya angka)
//     $nomor_list = [];
//     foreach ($warga as $w) {
//         // Hapus karakter non-angka agar Fonnte tidak bingung
//         $clean_number = preg_replace('/[^0-9]/', '', $w['no_wa']);
//         if (!empty($clean_number)) {
//             $nomor_list[] = $clean_number;
//         }
//     }
//     $target = implode(',', $nomor_list);

//     // 3. Setting API Fonnte
//     $token = "ApiJLBggZ7zuQMTokTds"; 
    
//     $curl = curl_init();
//     curl_setopt_array($curl, array(
//       CURLOPT_URL => 'https://api.fonnte.com/send',
//       CURLOPT_RETURNTRANSFER => true,
//       CURLOPT_ENCODING => "",
//       CURLOPT_MAXREDIRS => 10,
//       CURLOPT_TIMEOUT => 0,
//       CURLOPT_FOLLOWLOCATION => true,
//       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//       CURLOPT_CUSTOMREQUEST => 'POST',
//       // Gunakan http_build_query agar pengiriman data lebih stabil di beberapa server
//       CURLOPT_POSTFIELDS => http_build_query(array(
//         'target'      => $target,
//         'message'     => $pesan, 
//         'delay'       => '2', 
//         'countryCode' => '62', 
//       )),
//       CURLOPT_HTTPHEADER => array(
//         "Authorization: $token",
//         "Content-Type: application/x-www-form-urlencoded"
//       ),
//     ));

//     $response = curl_exec($curl);
//     $err = curl_error($curl);
//     curl_close($curl);
    
//     // 4. Analisis Hasil Response
//     if ($err) {
//         return $this->response->setJSON(['status' => 'error', 'msg' => 'Masalah Koneksi Server (cURL): ' . $err]);
//     }

//     $result = json_decode($response, true);

//     // 5. Cek Status Respon Fonnte
//     if (isset($result['status']) && $result['status'] == true) {
//         // BERHASIL: Simpan ke RIWAYAT_BLAST
//         $db->table('riwayat_blast')->insert([
//             'judul_kegiatan'    => $judul,
//             'isi_pesan'         => $pesan,
//             'total_penerima'    => count($nomor_list),
//             'dikirim_oleh'      => session()->get('nama_lengkap') ?? 'Admin',
//             'status_pengiriman' => 'Selesai',
//             'created_at'        => date('Y-m-d H:i:s')
//         ]);

//         return $this->response->setJSON([
//             'status' => 'success',
//             'total'  => count($nomor_list)
//         ]);
//     } else {
//         // GAGAL: Tangkap pesan error spesifik dari Fonnte
//         // Jika token salah, akan muncul "invalid token". Jika WA mati, muncul "device disconnected".
//         $pesan_error = $result['reason'] ?? ($result['detail'] ?? 'API Fonnte menolak permintaan.');
        
//         return $this->response->setJSON([
//             'status' => 'error',
//             'msg'    => 'Fonnte Error: ' . $pesan_error
//         ]);
//     }
// }
public function hitung_target_dusun()
{
    $db = \Config\Database::connect();
    $dusun = $this->request->getPost('dusun');

    $builder = $db->table('penduduk')->where('status_aktif', 'Ya');
    
    if ($dusun != 'Semua') {
        $builder->where('dusun', $dusun);
    }

    $jumlah = $builder->countAllResults();

    return $this->response->setJSON(['jumlah' => $jumlah]);
}
public function proses_blast()
{
    $db = \Config\Database::connect();
    $pesan = $this->request->getPost('pesan');
    $judul = $this->request->getPost('judul');
    $dusun = $this->request->getPost('dusun');
    $delay = $this->request->getPost('delay'); // Tangkap delay dari HTML

    // Filter Penduduk
    $builder = $db->table('penduduk')->where('status_aktif', 'Ya');
    if ($dusun != 'Semua') {
        $builder->where('dusun', $dusun);
    }
    $warga = $builder->get()->getResultArray();

    if (empty($warga)) {
        return $this->response->setJSON(['status' => 'error', 'msg' => 'Tidak ada nomor aktif.']);
    }

    $nomor_list = [];
    foreach ($warga as $w) {
        $nomor_list[] = preg_replace('/[^0-9]/', '', $w['no_wa']);
    }
    $target = implode(',', $nomor_list);

    // API Fonnte
    $token = "ApiJLBggZ7zuQMTokTds"; 
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'target'      => $target,
            'message'     => $pesan, 
            'delay'       => $delay, // Gunakan delay dinamis dari input user
            'countryCode' => '62', 
        ),
        CURLOPT_HTTPHEADER => array("Authorization: $token"),
    ));

    $response = curl_exec($curl);
    $res = json_decode($response, true);
    curl_close($curl);

    if (isset($res['status']) && $res['status'] == true) {
        // Simpan riwayat
        $db->table('riwayat_blast')->insert([
            'judul_kegiatan'    => $judul . " ($dusun)",
            'isi_pesan'         => $pesan,
            'total_penerima'    => count($nomor_list),
            'dikirim_oleh'      => session()->get('nama_lengkap') ?? 'Admin',
            'status_pengiriman' => 'Selesai',
            'created_at'        => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON(['status' => 'success', 'total' => count($nomor_list)]);
    } else {
        return $this->response->setJSON(['status' => 'error', 'msg' => $res['reason'] ?? 'Gagal kirim.']);
    }
}
public function simpan_riwayat_blast()
{
    $blastModel = new \App\Models\BlastModel();

    $data = [
        'judul_kegiatan'    => $this->request->getPost('judul'),
        'isi_pesan'         => $this->request->getPost('pesan'),
        'total_penerima'    => $this->request->getPost('total'),
        'status_pengiriman' => 'Selesai',
        'dikirim_oleh'      => session()->get('nama') // Nama admin yang login
    ];

    $blastModel->save($data);
    
    return $this->response->setJSON(['status' => 'success']);
}
}