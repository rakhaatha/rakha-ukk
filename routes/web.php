<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\WaiterController;
use App\Http\Controllers\WaiterOrderController;
use App\Http\Controllers\CartController;

/*
|---------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🔐 Autentikasi Manual
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ⚠️ Cegah akses logout pakai GET
Route::any('/logout', function () {
    return redirect()->route('login');
})->name('logout.invalid')->middleware('auth');

// 🏠 Landing Page
Route::get('/', function () {
    return view('welcome');
});

// 📊 Dashboard (akses umum setelah login)
Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

//kasir
Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/pesanan_menunggu', [KasirController::class, 'pesananMenunggu'])->name('pesanan.menunggu');
    Route::get('/bayar/{id}', [KasirController::class, 'prosesPembayaran'])->name('bayar');
    Route::post('/bayar/{id}', [KasirController::class, 'simpanPembayaran'])->name('transaksi.store');
    Route::get('/riwayat', [KasirController::class, 'riwayatTransaksi'])->name('riwayat');
    Route::get('/index', [KasirController::class, 'index'])->name('index');
    Route::get('/kasir/transaksi/{order}/bayar', [KasirController::class, 'bayar'])->name('kasir.transaksi.bayar');
    Route::post('/kasir/transaksi/{order}/bayar', [KasirController::class, 'prosesBayar'])->name('kasir.transaksi.store');
});

// 👔 Manager
Route::middleware(['auth', 'role:manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [ManagerController::class, 'index'])->name('index');

    // Menu
    Route::get('/menu', [ManagerController::class, 'menu'])->name('menu');
    Route::post('/menu/tambah', [ManagerController::class, 'tambahMenu'])->name('menu.tambah');
    Route::post('/menu/update/{id}', [ManagerController::class, 'updateMenu'])->name('menu.update');
    Route::delete('/menu/delete/{id}', [ManagerController::class, 'hapusMenu'])->name('menu.delete');
    Route::get('/transaksi', [ManagerController::class, 'transaksi'])->name('transaksi');
    Route::get('/laporan', [ManagerController::class, 'laporan'])->name('laporan');
    Route::get('/log', [ManagerController::class, 'logAktivitas'])->name('log');
});

// 🛠️ Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('index');

    // Kelola user
    Route::get('/users', [AdminController::class, 'kelolaUser'])->name('users');
    Route::post('/users/{id}/update', [AdminController::class, 'updatePeran'])->name('users.update');

    // Log aktivitas
    Route::get('/log', [AdminController::class, 'logAktivitas'])->name('log');
});

// 🍽️ Waiter
Route::middleware(['auth', 'role:waiter'])->prefix('waiter')->name('waiter.')->group(function () {
    Route::get('/dashboard', [WaiterController::class, 'index'])->name('dashboard');
    Route::get('/orders', [WaiterOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [WaiterOrderController::class, 'create'])->name('orders.create');
    Route::get('/menu-search', [WaiterOrderController::class, 'search'])->name('waiter.menu.search');
    Route::post('/orders', [WaiterOrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/multiple', [WaiterOrderController::class, 'storeMultiple'])->name('waiter.orders.storeMultiple');
    Route::get('/orders/create-multiple', [WaiterOrderController::class, 'createMultiple'])->name('orders.createMultiple');
    Route::post('/orders/store-multiple', [WaiterOrderController::class, 'storeMultiple'])->name('orders.storeMultiple');
});