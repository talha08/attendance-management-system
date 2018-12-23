<?php

use App\Models\UserInfo;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Test Admin',
            'email' => 'test@admin.com',
            'password' => bcrypt('a')
        ]);
        User::create([
            'name' => 'Test User1',
            'email' => 'test@user1.com',
            'password' => bcrypt('a')
        ]);
        User::create([
            'name' => 'Test User2',
            'email' => 'test@user2.com',
            'password' => bcrypt('a')
        ]);


        UserInfo::create([
            'user_id' => '1',
        ]);
        UserInfo::create([
            'user_id' => '2',
        ]);
        UserInfo::create([
            'user_id' => '3',
        ]);
    }
}
