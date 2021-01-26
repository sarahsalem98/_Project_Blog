<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use  Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $userCount=max((int)$this->command->ask('how many users would you like?',20),1);


    DB::table('users')->insert( [
            'name' => 'sara salem',
            'email' => 'sasasalem44@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'is_admin'=>true,
        ]);

       User::factory()->count($userCount)->create(); 

    }
}
