@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Dashboard Admin</h2>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card shadow rounded-3">
                <div class="card-body text-center">
                    <h5 class="card-title">👤 Kelola User</h5>
                    <p class="card-text">Atur peran pengguna seperti admin, manager, atau kasir.</p>
                    <a href="{{ route('admin.users') }}" class="btn btn-primary">Kelola User</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow rounded-3">
                <div class="card-body text-center">
                    <h5 class="card-title">📌 Log Aktivitas</h5>
                    <p class="card-text">Lihat semua aktivitas yang dilakukan oleh pegawai.</p>
                    <a href="{{ route('admin.log') }}" class="btn btn-primary">Lihat Log</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
