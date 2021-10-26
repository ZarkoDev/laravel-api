<?php

namespace Database\Seeders;

use App\Http\Services\JobTaskService;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class JobTaskDomainSeeder extends Seeder
{
    const DOMAIN_VALID = 'segment.com';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(JobTaskService $taskService)
    {
        $adminUser = User::firstWhere('email', env('ADMIN_USER_EMAIL'));

        if (!$adminUser) {
            return false;
        }

        Auth::login($adminUser);

        $taskService->createDomainTask(['domain' => self::DOMAIN_VALID]);
    }
}
