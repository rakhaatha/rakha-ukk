<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pesanan</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f9f9f9;
            padding: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 20px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        th {
            background-color: #38b2ac;
            color: white;
        }
        tr:hover {
            background-color: #f1f5f9;
        }
        .menu {
            font-weight: 600;
        }
        .btn {
            margin-bottom: 20px;
        }
        img {
            border-radius: 8px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <button onclick="window.history.back();" class="btn btn-light">⬅ Kembali</button>
    <h2>📋 Daftar Pesanan</h2>

    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th>Harga</th>
                <th>Total Harga</th>
                <th>Foto</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                @foreach ($order->orderItems as $item)
                    <tr>
                        <td class="menu">{{ $item->menu->nama }} ({{ $item->jumlah }}x)</td>
                        <td>Rp {{ number_format($item->menu->harga, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->menu->harga * $item->jumlah, 0, ',', '.') }}</td>
                        <td>
                            @if($item->menu->foto)
                                <img src="{{ asset('storage/' . $item->menu->foto) }}" alt="{{ $item->menu->nama }}" width="60" height="60">
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td>{{ ucfirst($order->status) }}</td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="5">Belum ada pesanan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
