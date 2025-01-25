<?php

namespace Database\Seeders;

use App\Models\Acl\Permission;
use App\Models\Acl\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'super@admin.com'],
            [
                'name'      => 'Admin',
                'password'  => Hash::make('Test@123')
            ]
        );

        $adminRole = Role::find(1);
        $fullAccessPermissions = Permission::all();

        if ($adminRole && $fullAccessPermissions) {
            $user->roles()->syncWithoutDetaching([$adminRole->id], ['role_user']);
            foreach ($fullAccessPermissions as $permissions) {
                $adminRole->permissions()->syncWithoutDetaching([$permissions->id]);
            }
        }
    }
}
