<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->email = 'manager@gmail.com';
        $user->password = Hash::make('manager123');
        $user->role_id = Role::where('name', 'manager')->first()->id;
        $user->saveOrFail();
    }
}
