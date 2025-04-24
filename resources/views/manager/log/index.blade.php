@extends('layouts.app')

@section('content')
<div class="container">
<button onclick="window.history.back();" class="btn btn-light mt-3">Kembali</button>
    <h2 class="mb-4">Log Aktivitas Pegawai</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nama Pegawai</th>
                <th>Aktivitas</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse($log as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->aktivitas }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada aktivitas tercatat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
