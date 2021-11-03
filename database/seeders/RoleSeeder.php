<?php

namespace Database\Seeders;

use App\Http\Services\UserService;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'admin',
            'supervisor',
            'guest',
        ];

        foreach ($roles as $name) {
            $role = new Role();
            $role->name = $name;
            $role->save();
        }
    }
}
