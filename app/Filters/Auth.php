<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Jika session 'logged_in' tidak ada atau false
        if (!session()->get('logged_in')) {
            // Redirect paksa ke halaman index (http://localhost:8080)
            return redirect()->to(base_url('/'))->with('error', 'Sesi berakhir, silakan login kembali.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Kosongkan
    }
}