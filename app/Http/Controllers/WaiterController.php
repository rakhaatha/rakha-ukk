<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class WaiterController extends Controller
{
    public function index()
    {
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Waiter membuka dashboard.'
        ]);

        return view('waiter.index');
    }

    public function create()
    {
        $menus = Menu::all();

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Waiter membuka halaman buat pesanan.'
        ]);

        return view('waiter.order.create', compact('menus'));
    }
}
