<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$477Sq1kivrRuJA3TjeeCCudSrcIrCmm8daHdeex13ZSSQOKKfQ1G2',
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
