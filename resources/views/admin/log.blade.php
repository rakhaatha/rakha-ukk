@extends('layouts.app')

@section('content')
<div class="container">
<button onclick="window.history.back();" class="btn btn-light mt-3">Kembali</button>
    <h2 class="mb-4">Log Aktivitas Pegawai</h2>

    <table class="table table-striped">
    thead>
            <tr>
                <th>User</th>
                <th>Aktivitas</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{ $log->user->name ?? '-' }}</td>
                    <td>{{ $log->aktivitas }}</td>
                    <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $logs->links() }}
</div>
@endsection
