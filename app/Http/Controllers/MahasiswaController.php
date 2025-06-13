<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MahasiswaController extends Controller
{
    public function index(){
        $response = Http::get(config('services.api.api_base_url').'/mahasiswa');

        return view ('mahasiswa.index', [
            'mahasiswa' => $response->json()
        ]);
    }
}
