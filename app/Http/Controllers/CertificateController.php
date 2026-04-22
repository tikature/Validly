<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CertificateController extends Controller
{
    /**
     * Tampilkan halaman generator sertifikat.
     * Semua logika generate berjalan di sisi client (JavaScript/Canvas).
     * Controller ini hanya melayani render view.
     */
    public function index()
    {
        return view('certificate.index');
    }
}