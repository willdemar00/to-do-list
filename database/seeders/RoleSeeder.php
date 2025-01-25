<?php

namespace Database\Seeders;

use App\Models\Acl\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate([
            'name'          => 'admin',
            'display_name'  => 'Administrador'
        ]);
    }
}
