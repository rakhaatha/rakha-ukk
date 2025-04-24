@extends('layouts.app')

@section('content')
<div class="container">
<button onclick="window.history.back();" class="btn btn-light mt-3">Kembali</button>
    <h2 class="mb-4">Kelola User</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Peran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <select name="role" class="form-select">
                            <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                            <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="waiter" {{ $user->role == 'waiter' ? 'selected' : '' }}>Waiter</option>
                        </select>
                    </td>
                    <td>
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </td>
                </form>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection