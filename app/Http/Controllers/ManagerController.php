<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\LogAktivitas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Contracts\Service\Attribute\Required;

class ManagerController extends Controller
{
    public function index()
    {
        return view('manager.index');
    }

    public function menu()
    {
        $menus = Menu::all();
        return view('manager.menu.index', compact('menus'));
    }

    public function tambahMenu(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'kategori' => 'required|in:makanan,minuman',
        ]);

        $menu=Menu::create($request->all());
        if ($request->hasfile('foto')) {
            $request->file('foto')->move('fotomakanan/', $request->file('foto')->getClientOriginalName());
            $menu->foto = $request->file('foto')->getClientOriginalName();
            $menu->save();
        }

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Manager menambahkan menu baru: ' . $request->nama
        ]);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan.');
    }

    public function updateMenu(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'kategori' => 'required|in:makanan,minuman'
        ]);

        $menu->update($request->all());

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Manager mengedit menu: ' . $menu->nama
        ]);

        return redirect()->back()->with('success', 'Menu berhasil diupdate.');
    }

    public function transaksi(Request $request)
    {
        $query = Transaksi::query();

        if ($request->filled('pegawai')) {
            $query->where('user_id', $request->pegawai);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', Carbon::parse($request->bulan)->month);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $transaksi = $query->with('users')->latest()->get();
        $pegawai = User::all();

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Manager melihat data transaksi.'
        ]);

        return view('manager.transaksi.index', compact('transaksis', 'pegawai'));
    }

public function laporan(Request $request)
    {
        $harian = Transaksi::whereDate('tanggal', Carbon::today())->sum('total_harga');
        $bulanan = Transaksi::whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->sum('total_harga');

        $transaksis = Transaksi::orderBy('created_at', 'desc')->get();

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Manager membuka laporan pendapatan dan transaksi.'
        ]);

        return view('manager.laporan.index', compact('transaksis', 'harian', 'bulanan'));
    }

    public function logAktivitas()
    {
        $log = LogAktivitas::with('user')->latest()->get();
        return view('manager.log.index', compact('log'));
    }

    public function hapusMenu($id)
    {
        $menu = Menu::findOrFail($id);
        $namaMenu = $menu->nama;
        $menu->delete();

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => "Manager menghapus menu: $namaMenu"
        ]);

        return redirect()->back()->with('success', 'Menu berhasil dihapus.');
    }
}
