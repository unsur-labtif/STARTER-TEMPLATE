<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'isUser',

                'email' => 'user@mail.com',
                'password' => bcrypt('12345'),
                'roles_id' => 2,
            ],
            [
                'name' => 'isAdmin',

                'email' => 'admin@mail.com',
                'password' => bcrypt('12345'),
                'roles_id' => 1,
            ]
        ];
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
