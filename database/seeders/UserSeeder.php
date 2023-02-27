<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'admin')->first();
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(15),
            // 'uuid' => Str::uuid()
        ]);

        DB::table('model_has_roles')->insert([
            'model_id' => $user->id,
            'model_type' => User::class,
            'role_id' => $role->id,
            // 'team_id' => $role->team_id
        ]);
    }
}
