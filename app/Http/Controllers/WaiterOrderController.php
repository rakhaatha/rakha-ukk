<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WaiterOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderItems.menu')->latest()->get();
        return view('waiter.orders.index', compact('orders'));
    }

    public function create()
    {
        $menus = Menu::all();
        return view('waiter.orders.create', compact('menus'));
    }

    public function search(Request $request)
    {
        $keyword = $request->get('q', '');
        $menus = Menu::where('nama', 'like', '%' . $keyword . '%')->get();
        return response()->json($menus);
    }

    public function store(Request $request)
{
    $request->validate([
        'menu_id' => 'required|array',
        'menu_id.*' => 'exists:menus,id',
        'jumlah' => 'required|array',
        'jumlah.*' => 'integer|min:1',
        'metode_pembayaran' => 'required|string'
    ]);

    DB::beginTransaction();
    try {
        $total_harga = 0;
        $items = [];

        foreach ($request->menu_id as $index => $menu_id) {
            $menu = Menu::findOrFail($menu_id);
            $jumlah = (int) $request->jumlah[$index];

            // Validasi stok cukup
            if ($menu->stok < $jumlah) {
                DB::rollBack();
                return back()->with('error', "Stok untuk menu {$menu->nama} tidak cukup.");
            }

            $subtotal = $menu->harga * $jumlah;

            // Simpan item ke array sementara
            $items[] = [
                'menu_id' => $menu->id,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
            ];

            $total_harga += $subtotal;

            // Kurangi stok
            $menu->stok -= $jumlah;
            $menu->save();
        }

        // Buat pesanan
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_harga' => $total_harga,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        // Simpan ke tabel order_items
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['menu_id'],
                'jumlah' => $item['jumlah'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        DB::commit();
        return redirect()->route('waiter.orders.index')->with('success', 'Pesanan berhasil disimpan.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal menyimpan pesanan: ' . $e->getMessage());
    }
}

    public function createMultiple()
    {
        $menus = Menu::all();
        return view('waiter.orders.create_multiple', compact('menus'));
    }

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'orders' => 'required|array|min:1',
            'orders.*.items' => 'required|array|min:1',
            'orders.*.items.*.menu_id' => 'required|exists:menus,id',
            'orders.*.items.*.jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->orders as $orderData) {
                $total = 0;

                // Cek stok sebelum buat pesanan
                foreach ($orderData['items'] as $item) {
                    $menu = Menu::findOrFail($item['menu_id']);
                    if ($menu->stok < $item['jumlah']) {
                        DB::rollBack();
                        return back()->with('error', "Stok untuk menu {$menu->nama} tidak cukup.");
                    }
                }

                // Buat order
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'total_harga' => 0, // akan diupdate setelah perhitungan
                    'metode_pembayaran' => $request->metode_pembayaran ?? 'tunai',
                ]);

                $total = 0;

                foreach ($orderData['items'] as $item) {
                    $menu = Menu::findOrFail($item['menu_id']);
                    $subtotal = $menu->harga * $item['jumlah'];

                    OrderItem::create([
                        'order_id' => $order->id,
                        'menu_id' => $menu->id,
                        'jumlah' => $item['jumlah'],
                        'subtotal' => $subtotal,
                    ]);

                    $total += $subtotal;

                    // Kurangi stok
                    $menu->stok -= $item['jumlah'];
                    $menu->save();
                }

                // Update total_harga setelah selesai hitung semua
                $order->update(['total_harga' => $total]);
            }

            DB::commit();
            return redirect()->route('waiter.orders.index')->with('success', 'Semua pesanan berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan pesanan: ' . $e->getMessage());
        }
    }
}
