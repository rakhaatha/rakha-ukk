@extends('layouts.app')

@section('content')
<div class="container">
<button onclick="window.history.back();" class="btn btn-light mt-3">Kembali</button>
    <h2 class="mb-4">Riwayat Transaksi</h2>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <select name="pegawai" class="form-select">
                <option value="">Semua Pegawai</option>
                @foreach($pegawai as $p)
                    <option value="{{ $p->id }}" {{ request('pegawai') == $p->id ? 'selected' : '' }}>
                        {{ $p->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
        </div>
        <div class="col-md-2">
            <input type="month" name="bulan" class="form-control" value="{{ request('bulan') }}">
        </div>
        <div class="col-md-2">
            <input type="number" name="tahun" class="form-control" placeholder="Tahun" value="{{ request('tahun') }}">
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Pegawai</th>
                    <th>Total Harga</th>
                    <th>Metode Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $i => $trx)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}</td>
                        <td>{{ $trx->user->name ?? '-' }}</td>
                        <td>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($trx->metode_pembayaran ?? '-') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada transaksi ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
