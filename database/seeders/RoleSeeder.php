<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1= Role::create(['name'=>'SuperAdmin']);
        $role2= Role::create(['name'=>'Admin']);
        $role3= Role::create(['name'=>'User']);

        Permission::create(['name' => 'admin.users.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.store'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'admin.users.show'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'admin.users.update'])->syncRoles([$role1,$role2,$role3]);
        Permission::create(['name' => 'admin.users.destroy'])->syncRoles([$role1,$role2,$role3]);

        Permission::create(['name' => 'admin.products.index'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'admin.products.store'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.products.show'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'admin.products.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.products.destroy'])->syncRoles([$role1]);

    }
}
