<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);
        $permissionDashboard = Permission::create(['name' => 'view dashboard']);
        $roleAdmin->givePermissionTo($permissionDashboard);

        // Utilisateur "admin"
        $admin = User::factory()->create([
            'name'     => 'Admin',
            'email'    => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole($roleAdmin);

        // Utilisateur "user" (lambda)
        $user = User::factory()->create([
            'name'     => 'User',
            'email'    => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        // Produits de l'admin
        Product::factory()->count(3)->create([
            'user_id' => $admin->id,
        ]);

        // Produits de l'utilisateur simple
        Product::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);
    }
}
