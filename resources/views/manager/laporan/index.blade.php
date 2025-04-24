@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <h1 class="text-center mb-4">Laporan Transaksi dan Pendapatan</h1>

    <!-- Card for Pendapatan -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5>Pendapatan Hari Ini</h5>
                </div>
                <div class="card-body text-center">
                    <h3 class="display-4">Rp {{ number_format($harian, 0, ',', '.') }}</h3>
                    <p class="lead">Total pendapatan untuk hari ini.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5>Pendapatan Bulan Ini</h5>
                </div>
                <div class="card-body text-center">
                    <h3 class="display-4">Rp {{ number_format($bulanan, 0, ',', '.') }}</h3>
                    <p class="lead">Total pendapatan untuk bulan ini.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table for Transactions -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-dark text-white">
            <h5>Daftar Transaksi</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Nama Pelanggan</th>
                        <th>Total Pembayaran</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksis as $transaksi)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $transaksi->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ $transaksi->nama_pelanggan }}</td>
                        <td>Rp {{ number_format($transaksi->total_pembayaran, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge 
                                @if($transaksi->status == 'Lunas') badge-success 
                                @elseif($transaksi->status == 'Pending') badge-warning 
                                @else badge-danger 
                                @endif">
                                {{ $transaksi->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

<style>
    /* Gaya untuk pendapatan card */
    .card {
        border-radius: 15px;
    }

    .card-header {
        border-radius: 15px 15px 0 0;
    }

    .card-body h3 {
        font-weight: bold;
        color: #4CAF50;
    }

    /* Tabel styling */
    .table th,
    .table td {
        text-align: center;
        vertical-align: middle;
    }

    .table td {
        font-weight: 500;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .badge {
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }
</style>