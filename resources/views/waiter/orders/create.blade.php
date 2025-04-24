@extends('layouts.app')

@section('content')
<div class="container">
    <button onclick="window.history.back();" class="btn btn-light mt-3">⬅ Kembali</button>
    <h2 class="my-4">📝 Buat Pesanan</h2>

    <form action="{{ route('waiter.orders.store') }}" method="POST" id="orderForm">
        @csrf

        <div class="mb-3">
            <input type="text" id="menuSearch" class="form-control" placeholder="🔍 Ketik nama menu...">
            <ul class="list-group mt-1" id="menuList"></ul>
        </div>

        <h4 class="my-3">📋 Daftar Pesanan</h4>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Menu</th>
                    <th width="120">Jumlah</th>
                    <th width="150">Harga</th>
                    <th width="80">Aksi</th>
                </tr>
            </thead>
            <tbody id="orderItems"></tbody>
        </table>

        <input type="hidden" name="metode_pembayaran" value="tunai">

        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary">✅ Konfirmasi Pesanan</button>
        </div>
    </form>
</div>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        const menus = @json($menus); // Semua data menu dimuat langsung
        const menuSearch = document.getElementById("menuSearch");
        const menuList = document.getElementById("menuList");
        const orderItems = document.getElementById("orderItems");
        const selectedMenus = [];

        menuSearch.addEventListener("input", function() {
            const keyword = this.value.toLowerCase();
            menuList.innerHTML = "";

            if (keyword.length > 1) {
                const filteredMenus = menus.filter(menu => menu.nama.toLowerCase().includes(keyword));
                filteredMenus.forEach(menu => {
                    const item = document.createElement("li");
                    item.classList.add("list-group-item", "list-group-item-action");
                    item.style.cursor = "pointer";
                    item.textContent = `${menu.nama} - Rp${parseInt(menu.harga).toLocaleString('id-ID')}`;
                    item.addEventListener("click", function() {
                        addMenuToOrder(menu);
                    });
                    menuList.appendChild(item);
                });
            }
        });

        function addMenuToOrder(menu) {
            if (selectedMenus.find(m => m.id === menu.id)) return;

            selectedMenus.push({
                id: menu.id,
                nama: menu.nama,
                harga: menu.harga,
                jumlah: 1
            });

            const row = document.createElement("tr");
            row.innerHTML = `
    <td>${menu.nama}<input type="hidden" name="menu_id[]" value="${menu.id}"></td>
    <td><input type="number" name="jumlah[]" value="1" min="1" class="form-control jumlah-input"></td>
    <td>Rp${parseInt(menu.harga).toLocaleString('id-ID')}</td>
    <td><button type="button" class="btn btn-danger btn-sm remove-item">✖</button></td>
`;


            row.querySelector(".remove-item").addEventListener("click", function() {
                row.remove();
                const index = selectedMenus.findIndex(m => m.id === menu.id);
                if (index !== -1) selectedMenus.splice(index, 1);
            });

            row.querySelector(".jumlah-input").addEventListener("input", function() {
                const menuItem = selectedMenus.find(m => m.id === menu.id);
                menuItem.jumlah = parseInt(this.value);
            });

            orderItems.appendChild(row);
            menuSearch.value = "";
            menuList.innerHTML = "";
        }

        document.getElementById("orderForm").addEventListener("submit", function(e) {
            if (selectedMenus.length === 0) {
                e.preventDefault();
                alert("Tambahkan minimal satu menu sebelum menyimpan pesanan.");
            }
        });
    });
</script>
@endsection