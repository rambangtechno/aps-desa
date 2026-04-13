<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
abstract class BaseController extends Controller
{
    // Cari baris ini, tambahkan 'desa'
    protected $helpers = ['form', 'url', 'desa']; 

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();

        // KEMBALIKAN LOGIKA PROTEKSI AWAL KAMU YANG SUDAH JALAN
        $uri = $request->getUri();
        $segment = ($uri->getTotalSegments() > 0) ? $uri->getSegment(1) : '';

        if (in_array($segment, ['admin', 'kades'])) {
            if (!$this->session->get('logged_in')) {
                header("Location: " . base_url('/?action=login'));
                exit();
            }
        }
    }
}