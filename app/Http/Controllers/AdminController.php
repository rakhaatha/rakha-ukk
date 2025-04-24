<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function kelolaUser()
    {
        $users = User::where('role', '!=', 'pembeli')->get(); // misalnya exclude pelanggan
        return view('admin.user', compact('users'));
    }

    public function updatePeran(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,manager,kasir,waiter',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => "Mengubah peran user {$user->name} menjadi {$request->role}"
        ]);

        return redirect()->route('admin.users')->with('success', 'Peran pengguna berhasil diperbarui.');
    }

    public function logAktivitas()
    {
        $logs = LogAktivitas::latest()->paginate(10);
        return view('admin.log', compact('logs'));
    }

    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }
}
