<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = [
            'user', 'role', 'permission',
            'surat-masuk', 'surat-keluar',
            'disposisi'
        ];
        $functions = ['create', 'update', 'read', 'delete'];
        $guards = ['web', 'api'];
        foreach ($guards as $guard) {
            foreach ($resources as $resource) {
                foreach ($functions as $function) {
                    Permission::updateOrCreate(['name' => $function .'-'. $resource, 'guard_name' => $guard]);
                }
            }
        }
    }
}
