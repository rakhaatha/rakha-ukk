@extends('layouts.app')

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="container">
<a href="{{ route('manager.index') }}" class="btn btn-light mt-3">Kembali</a>
    <h2 class="mb-4">Kelola Menu</h2>

    <form action="{{ route('manager.menu.tambah') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" name="nama" class="form-control" placeholder="Nama Menu" required>
            </div>
            <div class="col-md-3">
                <input type="number" name="harga" class="form-control" placeholder="Harga" required>
            </div>
            <div class="col-md-3">
                <select name="kategori" class="form-select" required>
                    <option value="makanan">Makanan</option>
                    <option value="minuman">Minuman</option>
                </select>
            </div>
            <div class="col-md-2">
            <input type="number" name="stok" class="form-control" placeholder="Stok" required min="0">
            </div>

            <div class="col-md-3 mt-3">
                <input type="file" name="foto" class="form-control" placeholder="foto" required>
            </div>
            <div class="col-md-2 mt-3">
                <button class="btn btn-success w-100">Tambah</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>foto</th>
                <th style="width: 180px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menus as $menu)
            <tr>
                <form action="{{ route('manager.menu.update', $menu->id) }}" method="POST">
                    @csrf
                    <td>
                        <input type="text" name="nama" value="{{ $menu->nama }}" class="form-control" required>
                    </td>
                    <td>
                        <input type="number" name="harga" value="{{ $menu->harga }}" class="form-control" required>
                    </td>
                    <td>
                        <select name="kategori" class="form-select" required>
                            <option value="makanan" {{ $menu->kategori == 'makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="minuman" {{ $menu->kategori == 'minuman' ? 'selected' : '' }}>Minuman</option>
                        </select>
                    </td>
                    <td>
                    <input type="number" name="stok" value="{{ $menu->stok }}" class="form-control" required min="0">
                    </td>

                    <td>
                    <img src="{{ asset('fotomakanan/' . $menu->foto) }}" alt="foto"
                                    style="width : 30px">
                                </td>
                    <td class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>

                </form>
                <form action="{{ route('manager.menu.delete', $menu->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection