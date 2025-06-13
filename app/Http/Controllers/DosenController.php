<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
}
