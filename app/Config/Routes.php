<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. Landing Page (Halaman Utama untuk Publik)
$routes->get('/', 'Home::index');

// 2. Autentikasi (Login & Logout)
// $routes->get('/login', 'Auth::index');
$routes->post('/auth/loginProcess', 'Auth::loginProcess');
$routes->post('auth/registerProcess', 'Auth::registerProcess');


// 3. Dashboard (Halaman Internal Admin)
$routes->get('/dashboard', 'Auth::dashboard');
$routes->get('/profil', 'Home::profil');

$routes->get('admin', 'Admin::index');
$routes->get('admin/kegiatan', 'Admin::kegiatan');
$routes->post('admin/simpan_kegiatan', 'Admin::simpan_kegiatan');
$routes->get('admin/verifikasi_user', 'Admin::verifikasi_user');

$routes->get('admin/verifikasi_user', 'Admin::verifikasi_user');
$routes->get('admin/aktivasi_user/(:num)', 'Admin::aktivasi_user/$1');
$routes->post('admin/update_kegiatan/(:num)', 'Admin::update_kegiatan/$1');
$routes->get('admin/hapus_kegiatan/(:num)', 'Admin::hapus_kegiatan/$1');

// Routes khusus Kepala Desa
$routes->get('kades', 'Kades::index');
$routes->get('kades/proses_persetujuan/(:num)/(:any)', 'Kades::proses_persetujuan/$1/$2');
$routes->get('kades/laporan', 'Kades::laporan');

$routes->get('admin/form_cetak', 'Admin::form_cetak');
$routes->post('admin/proses_cetak', 'Admin::proses_cetak'); 
// --- Routes untuk Manajemen Kepala Desa ---
$routes->get('admin/kelola_kades', 'Admin::kelola_kades');
$routes->post('admin/simpan_kades', 'Admin::simpan_kades');

// --- Routes untuk Fitur Cetak Laporan (Akses Admin) ---
$routes->get('admin/form_cetak', 'Admin::form_cetak');      // Halaman pilih kades & tgl
$routes->post('admin/proses_cetak', 'Admin::proses_cetak'); 

$routes->get('admin/print_laporan', 'Admin::print_laporan');// Halaman preview cetak (tab baru)// Untuk memproses formnya nanti
$routes->get('admin/sebaran_kegiatan', 'Admin::sebaran_kegiatan');
// Tambahkan ini di Routes.php
$routes->get('auth/logout', 'Auth::logout');
