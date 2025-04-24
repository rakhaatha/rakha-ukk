<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name'  =>  'Kasir',
            'email' =>  'kasir@gmail.com',
            'password'  => Hash::make('kasir'),
            'role'  => 'kasir'
        ]);
        User::create([
            'name'  =>  'manager',
            'email' =>  'manager@gmail.com',
            'password'  => Hash::make('manager'),
            'role'  => 'manager'
        ]);
        User::create([
            'name'  =>  'admin',
            'email' =>  'admin@gmail.com',
            'password'  => Hash::make('admin'),
            'role'  => 'admin'
        ]);
        User::create([
            'name'  =>  'waiter',
            'email' =>  'waiter@gmail.com',
            'password'  => Hash::make('waiter'),
            'role'  => 'waiter'
        ]);
    }
}
