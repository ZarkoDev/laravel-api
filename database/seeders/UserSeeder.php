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
            'email' => env('ADMIN_USER_EMAIL'),
            'password' => env('ADMIN_USER_PASSWORD')
        ]);
    }
}
