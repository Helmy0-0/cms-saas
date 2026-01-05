<?php

namespace Config;

use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;
use CodeIgniter\HotReloader\HotReloader;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

Events::on('pre_system', static function (): void {
    if (ENVIRONMENT !== 'testing') {
        if (ini_get('zlib.output_compression')) {
            throw FrameworkException::forEnabledZlibOutputCompression();
        }

        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        ob_start(static fn ($buffer) => $buffer);
    }

    /*
     * --------------------------------------------------------------------
     * Debug Toolbar Listeners.
     * --------------------------------------------------------------------
     * If you delete, they will no longer be collected.
     */
    if (CI_DEBUG && ! is_cli()) {
        Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
        service('toolbar')->respond();
        // Hot Reload route - for framework use on the hot reloader.
        if (ENVIRONMENT === 'development') {
            service('routes')->get('__hot-reload', static function (): void {
                (new HotReloader())->run();
            });
        }
    }
});
Events::on('exception', function (\Throwable $exception) {
    $request = service('request');
    $response = service('response');
    
    // Tentukan status code (default 500 kalau tidak ada)
    $statusCode = $exception->getCode() ?: 500;
    if ($statusCode < 100 || $statusCode > 599) $statusCode = 500;

    // 1. Logika untuk API/AJAX
    if ($request->isAJAX() || str_contains($request->getUri()->getPath(), 'api/')) {
        $response->setStatusCode($statusCode)
                 ->setJSON([
                     'status'  => $statusCode,
                     'error'   => true,
                     'message' => $exception->getMessage(),
                 ])->send();
        exit; // Hentikan proses agar tidak muncul layout HTML bawaan CI
    }

    // 2. Logika untuk Web (403 Forbidden)
    if ($statusCode === 403) {
        echo view('errors/html/error_403', [
            'code'    => 403,
            'message' => $exception->getMessage(),
        ]);
        exit;
    }
});
