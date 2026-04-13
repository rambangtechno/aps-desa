<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    /**
     * Mengatur alias untuk kelas Filter agar penulisan lebih singkat.
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
        // Filter buatan sendiri untuk proteksi Login
        'auth'          => \App\Filters\Auth::class,
    ];
    public array $filters = [
        // PROTEKSI URL: Semua yang ada di kades/ dan admin/ wajib lewat filter auth
        'auth' => ['before' => ['kades/*', 'admin/*']],
    ];

    /**
     * Filter yang selalu dijalankan di setiap request (Global).
     */
    public array $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * Filter berdasarkan metode HTTP (GET, POST, dll).
     */
    public array $methods = [];

    /**
     * Filter yang berjalan pada pola URI tertentu (Admin & Kades).
     */
    
}