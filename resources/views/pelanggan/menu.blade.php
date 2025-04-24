@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Menu Makanan & Minuman</h2>

    <div class="row g-4">
        @foreach ($menu as $item)
        <div class="col-md-4">
            <div class="card shadow-sm rounded-3 h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->nama }}</h5>
                    <p class="card-text">{{ $item->deskripsi }}</p>
                    <p class="fw-bold">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                    <form method="POST" action="{{ route('pelanggan.pesan', $item->id) }}">
                        @csrf
                        <div class="mb-2">
                            <input type="number" name="jumlah" class="form-control" placeholder="Jumlah" min="1" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Pesan</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
