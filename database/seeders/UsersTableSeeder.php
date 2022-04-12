<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'super admin',
            'email' => 'super_admin@gmail.com',
            'password' => bcrypt('12345678'),
            'type' => 'super_admin',
        ]);
        $user1->attachRole('super_admin');

        $user2 = User::create([
            'name' => 'normal user',
            'email' => 'user@gmail.com',
            'password' => bcrypt('12345678'),
            'type' => 'user',
        ]);
        $user2->attachRole('user');
    }
}
