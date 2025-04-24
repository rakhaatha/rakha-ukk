@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Dashboard Manager</h2>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card shadow rounded-3">
                <div class="card-body text-center">
                    <h5 class="card-title">📋 Kelola Menu</h5>
                    <p class="card-text">Tambah, edit, atau hapus daftar makanan & minuman.</p>
                    <a href="{{ route('manager.menu') }}" class="btn btn-primary">Lihat Menu</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow rounded-3">
                <div class="card-body text-center">
                    <h5 class="card-title">💵 Laporan Transaksi</h5>
                    <p class="card-text">Lihat data transaksi berdasarkan tanggal atau pegawai.</p>
                    <a href="{{ route('manager.transaksi') }}" class="btn btn-primary">Lihat Transaksi</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow rounded-3">
                <div class="card-body text-center">
                    <h5 class="card-title">📌 Log Aktivitas</h5>
                    <p class="card-text">Lihat semua aktivitas yang dilakukan oleh pegawai.</p>
                    <a href="{{ route('manager.log') }}" class="btn btn-primary">Lihat Log</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow rounded-3">
                <div class="card-body text-center">
                    <h5 class="card-title">📈 Laporan Pendapatan</h5>
                    <p class="card-text">Lihat ringkasan pendapatan harian dan bulanan.</p>
                    <a href="{{ route('manager.laporan') }}" class="btn btn-primary">Lihat Laporan</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
