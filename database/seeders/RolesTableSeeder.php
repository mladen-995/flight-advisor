<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id' => Role::ADMIN,
            'name' => 'admin'
        ]);

        Role::create([
            'id' => Role::USER,
            'name' => 'user'
        ]);
    }
}
