<nav class="navbar navbar-expand-lg navbar-dark bg-primary px-4 py-3">
    <a class="navbar-brand" href="#">Cafe Bisa Ngopi</a>
    <div class="d-flex align-items-center ms-auto">
        @auth
        <span class="text-white me-4 fs-5">
            Halo, {{ auth()->user()->name }}
            <span class="text-light fs-6">({{ auth()->user()->role->name ?? 'Tidak ada role' }})</span>
        </span>
        <form action="{{ route('logout') }}" method="POST" class="ms-2">
            @csrf
            <button type="submit" class="btn btn-outline-light">Logout</button>
        </form>
        @endauth
    </div>
</nav>
