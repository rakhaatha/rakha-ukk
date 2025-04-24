@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <h1 class="my-4">Selamat datang, Waiter!</h1>
        <p>Silakan pilih tindakan:</p>

        <a href="{{ route('waiter.orders.index') }}" class="btn btn-primary mb-3">Lihat Pesanan</a>

        <a href="{{ route('waiter.orders.create') }}" class="btn btn-secondary mb-3">Buat Pesanan Baru</a>
    </div>
@endsection

@push('styles')
    <style>
        body {
            font-family: sans-serif;
            background-color: #f9f9f9;
            padding: 50px;
            margin: 0;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            margin: 20px;
            border-radius: 10px;
            font-size: 16px;
            text-decoration: none;
        }
        .btn-primary {
            background-color: #3490dc;
            color: white;
        }
        .btn-primary:hover {
            background-color: #2779bd;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        h1 {
            font-size: 2.5rem;
            color: #333;
        }
        p {
            font-size: 1.2rem;
            color: #666;
        }
    </style>
@endpush
