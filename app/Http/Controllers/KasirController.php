<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\LogAktivitas;
use Carbon\Carbon;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    // Menampilkan halaman utama Kasir
    public function index()
    {
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Kasir membuka dashboard kasir.'
        ]);

        return view('kasir.index');
    }

    public function create()
{
    // Ambil semua data menu dari database
    $menus = Menu::where('stok', '>', 0)->get(); // Hanya tampilkan menu yang masih ada stok

    // Tampilkan view create.blade.php beserta data menu
    return view('waiter.order.create', compact('menus'));
}

    // Menampilkan pesanan yang menunggu pembayaran
    public function pesananMenunggu()
    {
        $orders = Order::where('status', 'menunggu')
            ->with('orderItems.menu', 'user')
            ->get();

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Kasir melihat daftar pesanan menunggu pembayaran.'
        ]);

        return view('kasir.pesanan_menunggu', compact('orders'));
    }

    // Menampilkan form pembayaran untuk pesanan tertentu
    public function prosesPembayaran($id)
    {
        $order = Order::with('orderItems.menu')->findOrFail($id);

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => "Kasir membuka form pembayaran untuk pesanan #$id."
        ]);

        return view('kasir.bayar', compact('order'));
    }

    // Menyimpan pembayaran dan mengubah status pesanan menjadi selesai
    public function simpanPembayaran(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'metode_pembayaran' => 'required|in:tunai',
        ]);

        // Simpan transaksi
        $order->metode_pembayaran = $request->metode_pembayaran;
        $order->status = 'selesai';
        $order->tanggal = Carbon::now();
        $order->save();

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => "Kasir menyelesaikan pembayaran untuk pesanan #$id."
        ]);

        return redirect()->route('kasir.riwayat')->with('success', 'Pembayaran berhasil diselesaikan.');
    }

    // Menampilkan riwayat transaksi (pesanan yang sudah selesai)
    public function riwayatTransaksi()
    {
        $orders = Order::where('status', 'selesai')->with('orderItems.menu')->latest()->get();

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Kasir membuka riwayat transaksi.'
        ]);

        return view('kasir.riwayat', compact('orders'));
    }

    // Menampilkan semua transaksi (jika perlu)
    public function semuaTransaksi()
    {
        $orders = Order::with('orderItems.menu')->get();

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Kasir melihat semua transaksi.'
        ]);

        return view('kasir.transaksi', compact('orders'));
    }

    // Menampilkan halaman pembayaran berdasarkan order id
    public function bayar($id)
    {
        $order = Order::with('orderItems.menu', 'user')->findOrFail($id);

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => "Kasir membuka halaman bayar untuk pesanan #$id."
        ]);

        return view('kasir.bayar', compact('order'));
    }

    // Proses pembayaran dan update status pesanan menjadi selesai
    public function prosesBayar(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $request->validate([
            'metode_pembayaran' => 'required|in:tunai'
        ]);

        $order->update([
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => 'selesai',
            'kembalian',
        ]);

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => "Kasir memproses pembayaran untuk pesanan #$orderId."
        ]);

        return redirect()->route('kasir.riwayat')->with('success', 'Pembayaran berhasil.');
    }

    // Menyimpan pembayaran dengan uang tunai dan menghitung kembalian
    public function store(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
    
        // Validasi
        $request->validate([
            'metode_pembayaran' => 'required|in:tunai',
            'uang_dibayar' => 'required|numeric|min:' . $order->total_harga,
            'kembalian' => 'required|numeric|min:',
        ]);
    
        // Simpan pembayaran
        $order->metode_pembayaran = $request->metode_pembayaran;
        $order->uang_dibayar = $request->uang_dibayar;
        $order->kembalian = $request->kembalian;
        $order->status = 'selesai';
        $order->tanggal = Carbon::now();
        $order->save();
    
        // Logging aktivitas
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => "Kasir memproses pembayaran untuk pesanan #$orderId dengan uang dibayar Rp " . number_format($request->uang_dibayar, 0, ',', '.') . " dan kembalian Rp " . number_format($request->kembalian, 0, ',', '.') . "."
        ]);
    
        return redirect()->route('kasir.riwayat')->with('success', 'Pembayaran berhasil!');
    }
    
}
