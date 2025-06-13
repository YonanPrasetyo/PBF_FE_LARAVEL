<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class DosenController extends Controller
{
     public function index(){
        $response = Http::get(config('services.api.api_base_url').'/dosen');

        return view ('dosen.index', [
            'dosen' => $response->json()
        ]);
    }
    public function create(){
        return view ('dosen.create');
    }
    public function store(Request $request){
        $response = Http::post(config('services.api.api_base_url').'/dosen', [
            'nama'=>$request->nama,
            'nidn'=>$request->nidn,
            'email'=>$request->email,
            'prodi'=>$request->prodi,
        ]);
        return redirect('/dosen');
    }

    public function edit(string $nidn){
        $response = Http::get(config('services.api.api_base_url').'/dosen/'.$nidn);
        return view ('dosen.edit', [
            'dosen' => $response->json()
        ]);
    }
    public function update(Request $request){
        $response = Http::put(config('services.api.api_base_url').'/dosen/'.$request->nidn, [
            'nama'=>$request->nama,
            'nidn'=>$request->nidn,
            'email'=>$request->email,
            'prodi'=>$request->prodi,
        ]);
        return redirect('/dosen');
    }
    public function destroy(string $nidn){
        $response = Http::delete(config('services.api.api_base_url').'/dosen/'.$nidn);
        return redirect('/dosen');
    }

    public function exportPdf()
    {
        // Ambil data dari API
        $response = Http::get(config('services.api.api_base_url').'/dosen');
        $dosen = $response->json();

        // Load view dan generate PDF
        $pdf = Pdf::loadView('dosen.pdf', compact('dosen'));

        // Download PDF
        return $pdf->download('data-dosen.pdf');
    }

    public function previewPdf()
    {
        $response = Http::get(config('services.api.api_base_url').'/dosen');
        $dosen = $response->json();

        $pdf = Pdf::loadView('dosen.pdf', compact('dosen'));

        // Stream PDF ke browser
        return $pdf->stream('data-dosen.pdf');
    }
}
