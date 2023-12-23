<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = [
            'name'=>'administrator',
            'email'=>'admin@admin.com',
            'password'=>bcrypt('password'),
        ];
        $exist =  User::where('email', '=', $admin['email'])->first();
        if(!$exist){
            User::create($admin);
        }
    }
}
