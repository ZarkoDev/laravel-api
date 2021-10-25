<?php

namespace Database\Seeders;

use App\Http\Services\UserService;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(UserService $userService)
    {
        $userService->store([
            'email' => 'admin@gmail.com',
            'password' => 123456
        ]);
    }
}
