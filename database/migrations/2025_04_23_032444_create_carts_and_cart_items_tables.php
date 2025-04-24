<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsAndCartItemsTables extends Migration
{
    public function up()
    {
        // Membuat tabel carts
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User yang memiliki keranjang
            $table->timestamps();
        });

        // Membuat tabel cart_items
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->onDelete('cascade'); // Menghubungkan dengan cart
            $table->foreignId('menu_id')->constrained()->onDelete('cascade'); // Menu yang dipilih
            $table->integer('jumlah'); // Jumlah item
            $table->decimal('subtotal', 8, 2); // Subtotal untuk item
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
    }
}