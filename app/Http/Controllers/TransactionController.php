<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
class TransactionController extends Controller
{
    public function create($orderId)
    {
        $order = Order::with('orderItems.menu')->findOrFail($orderId);
        
        return view('kasir.transaksi', compact('order'));
    }

    public function store(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->metode_pembayaran = $request->input('metode_pembayaran', 'tunai');
        $order->status = 'selesai';
        $order->save();

        return redirect()->route('kasir.index')->with('success', 'Transaksi berhasil!');
    }
}
