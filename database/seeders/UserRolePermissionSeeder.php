<?php

namespace Database\Seeders;

use App\Models\Core\Permission;
use App\Models\Core\Role;
use App\Models\Core\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        collect([
            ['name' => 'Administrators'],
            ['name' => 'Users'],
        ])->each(fn($role) => Role::create($role));

        collect([
            ['name' => 'view-permission'],
            ['name' => 'create-permission'],
            ['name' => 'update-permission'],
            ['name' => 'delete-permission'],
            ['name' => 'data-permission'],
            ['name' => 'view-role'],
            ['name' => 'create-role'],
            ['name' => 'update-role'],
            ['name' => 'delete-role'],
            ['name' => 'data-role'],
            ['name' => 'view-user'],
            ['name' => 'create-user'],
            ['name' => 'update-user'],
            ['name' => 'delete-user'],
            ['name' => 'data-user'],
            ['name' => 'bulk-user'],
            ['name' => 'view-settings-site'],
            ['name' => 'update-settings-site'],
            ['name' => 'view-province'],
            ['name' => 'create-province'],
            ['name' => 'update-province'],
            ['name' => 'delete-province'],
            ['name' => 'data-province'],
            ['name' => 'view-regency'],
            ['name' => 'create-regency'],
            ['name' => 'update-regency'],
            ['name' => 'delete-regency'],
            ['name' => 'data-regency'],
            ['name' => 'view-district'],
            ['name' => 'create-district'],
            ['name' => 'update-district'],
            ['name' => 'delete-district'],
            ['name' => 'data-district'],
            ['name' => 'view-village'],
            ['name' => 'create-village'],
            ['name' => 'update-village'],
            ['name' => 'delete-village'],
            ['name' => 'data-village'],
        ])->each(fn($permission) => Permission::create($permission)->assignRole('Administrators'));

        User::create([
            'name' => 'Administrator',
            'email' => 'scrum@yatimmandiri.org',
            'email_verified_at' => now(),
            'password' => Hash::make(uniqid()),
        ])->assignRole('Administrators');
    }
}
