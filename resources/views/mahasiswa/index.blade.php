@extends('layout.app')
@section('title', 'Dashboard')
@section('content')

  <div class="container mt-4">
    <h2>Data Dosen</h2>
    <a href="/dosen/create" class="btn btn-primary mb-3">Tambah Dosen</a>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Nama</th>
          <th>NIDN</th>
          <th>Email</th>
          <th>Prodi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        {{-- @dd($dosen); --}}

        @foreach($dosen as $d)
        <tr>
            {{-- @dd($d); --}}
          <td>{{ $d['nama'] }}</td>
          <td>{{ $d['nidn'] }}</td>
          <td>{{ $d['prodi'] }}</td>
          <td>{{ $d['email'] }}</td>
          <td>
            <a href="/dosen/edit/{{ $d['nidn'] }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="/dosen/delete/{{ $d['nidn'] }}" method="POST" style="display:inline;">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
