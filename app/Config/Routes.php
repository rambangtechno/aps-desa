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
$routes->get('/logout', 'Auth::logout');

// 3. Dashboard (Halaman Internal Admin)
$routes->get('/dashboard', 'Auth::dashboard');
$routes->get('/profil', 'Home::profil');