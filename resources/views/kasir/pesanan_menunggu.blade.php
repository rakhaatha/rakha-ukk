@extends('layouts.app')

@section('content')
<div class="container">
<a href="{{ route('kasir.index') }}" class="btn btn-light mt-3">Kembali</a>
    <h2 class="mt-4">Pesanan Menunggu Pembayaran</h2>

    <table class="table table-bordered table-striped mt-3">
        <thead class="thead-dark">
            <tr>
                <th>Nama Waiter</th>
                <th>Menu</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->user->name ?? '-' }}</td>
                    <td>
                        <ul class="mb-0">
                            @foreach ($order->orderItems as $item)
                                <li>{{ $item->menu->nama }} ({{ $item->jumlah }}x)</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('kasir.bayar', $order->id) }}" class="btn btn-primary btn-sm">Bayar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada pesanan menunggu.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
