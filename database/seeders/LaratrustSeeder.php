<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $config = config('laratrust_seeder.roles_structure');
        $mapPermission = collect(config('laratrust_seeder.permissions_map'));

        foreach ($config as $key => $permissionType) {

            // Create a new role
            $role = Role::firstOrCreate([
                'name' => $key,
                'display_name' => ucwords(str_replace('_', ' ', $key)),
                'description' => ucwords(str_replace('_', ' ', $key)),
            ]);
            $permissions = [];

            // Reading role permission permissionType
            foreach ($permissionType['permissions'] as $module => $value) {

                foreach (explode(',', $value) as $p => $perm) {

                    $permissionValue = $mapPermission->get($perm);
                    $namespaces = explode('_', $module);
                    $permissions[] = Permission::firstOrCreate([
                        'name' => str_replace('_', '-', $module) . '-' . $permissionValue,
                        'display_name' => $permissionValue,
                        'description' => ucfirst($permissionValue) . ' ' . ucfirst(str_replace(['-', '_'], ' ', $module)),
                    ])->id;

                }
            }

            // Attach all permissions to the role
            $role->permissions()->sync($permissions);

            if (Config::get('laratrust_seeder.create_users')) {
                // Create default user for each role
                $user = User::create([
                    'name' => ucwords(str_replace('_', ' ', $key)),
                    'email' => $key . '@app.com',
                    'password' => bcrypt('password')
                ]);
                $user->addRole($role);
            }
        }
    }
}
