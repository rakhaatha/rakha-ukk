@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-3">Dashboard Kasir</h2>
    <p>Selamat datang, Kasir!</p>

    <div class="row mt-4">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Transaksi Baru</h5>
                    <p class="card-text">Proses pembayaran pesanan pelanggan.</p>
                    <a href="{{ route('kasir.pesanan.menunggu') }}" class="btn btn-primary">Mulai Transaksi</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Riwayat Transaksi</h5>
                    <p class="card-text">Lihat transaksi yang telah diselesaikan.</p>
                    <a href="{{ route('kasir.riwayat') }}" class="btn btn-success">Lihat Riwayat</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
