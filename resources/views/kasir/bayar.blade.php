@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pembayaran</h2>

    <p><strong>Total Harga:</strong> Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>

    <form action="{{ route('kasir.transaksi.store', $order->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="metode_pembayaran">Metode Pembayaran</label>
            <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                <option value="tunai" selected>Tunai</option>
            </select>
        </div>

        <div class="form-group">
            <label for="uang_dibayar">Jumlah Uang Dibayar</label>
            <input type="number" name="uang_dibayar" id="uang_dibayar" class="form-control" required min="1" oninput="hitungKembalian()">
            @error('uang_dibayar')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Kembalian ditampilkan dan juga dikirim secara hidden --}}
        <div class="form-group">
            <label for="kembalian_display">Kembalian</label>
            <input type="text" id="kembalian_display" class="form-control" value="{{ $order->kembalian_display}}">
            <input type="hidden" name="kembalian" id="kembalian" value="{{ $order->kembalian_display}}">
        </div>

        <button type="submit" class="btn btn-success mt-3">Bayar Sekarang</button>
    </form>
</div>

<script>
    function hitungKembalian() {
        const totalHarga = {{ $order->total_harga }};
        const uangDibayar = parseInt(document.getElementById('uang_dibayar').value) || 0;
        const kembalian = uangDibayar - totalHarga;

        const display = document.getElementById('kembalian_display');
        const input = document.getElementById('kembalian');

        if (kembalian >= 0) {
            display.value = 'Rp ' + kembalian.toLocaleString('id-ID');
            input.value = kembalian;
        } else {
            display.value = 'Uang tidak cukup';
            input.value = 0;
        }
    }
</script>
@endsection
