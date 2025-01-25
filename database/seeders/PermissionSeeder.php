<?php

namespace Database\Seeders;

use App\Models\Acl\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::firstOrCreate([
            'name'          => 'admin_access',
            'display_name'  => 'Acesso de Administrador'
        ]);
    }
}
