<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    public function run(): void
    {
        // Cek dulu apakah user owner sudah ada biar tidak dobel
        $exist = User::where('username', 'owner')->first();

        if (! $exist) {
            User::create([
                'name' => 'Ibu Nisa',       // Nama tampilan
                'username' => 'owner',      // Username untuk login (readonly nanti)
                'email' => 'nisacake99@gmail.com', // Formalitas saja
                'password' => Hash::make('666666'), // PIN default
            ]);
            $this->command->info('✅ Akun Owner berhasil dibuat! PIN: 666666');
        } else {
            $this->command->warn('⚠️ Akun Owner sudah ada, tidak dibuat ulang.');
        }
    }
}
