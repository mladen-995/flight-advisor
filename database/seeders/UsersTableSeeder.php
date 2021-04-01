<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'mladen',
            'password' => Hash::make('password'),
            'first_name' => 'Mladen',
            'last_name' => 'Simijonović',
            'role_id' => Role::find(Role::ADMIN)->id
        ]);

        User::create([
            'username' => 'korisnik',
            'password' => Hash::make('password'),
            'first_name' => 'Nikola',
            'last_name' => 'Petrović',
            'role_id' => Role::find(Role::USER)->id
        ]);
    }
}
