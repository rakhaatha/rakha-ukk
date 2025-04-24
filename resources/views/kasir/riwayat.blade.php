@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('kasir.index') }}" class="btn btn-light mt-3">Kembali</a>
    <h1>Riwayat Transaksi</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Metode Pembayaran</th>
                <th>Rincian</th>
                <th>Kembalian</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->tanggal }}</td>
                <td>Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                <td>{{ ucfirst($order->metode_pembayaran) }}</td>
                <td>
                    <ul>
                        @foreach($order->orderItems as $item)
                        <li>{{ $item->menu->nama }} x{{ $item->jumlah }}</li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    @if($order->kembalian)
                        Rp{{ number_format($order->kembalian, 0, ',', '.') }}
                    @else
                        - 
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
