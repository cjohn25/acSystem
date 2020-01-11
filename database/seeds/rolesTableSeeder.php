<?php

use Illuminate\Database\Seeder;
use App\Model\Role;
use App\User;
use App\Model\Device;
use App\Model\User_Roles;
class rolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Role::create([
            'position' =>  'admin'
        ]);
        User::create([
            'name' =>  'Admin',
            'email' => 'admin@gmail.com',
            'typeID' => 1,
            'password' =>  Hash::make('password')
        ]); 
        User_Roles::create([
            'user_ID' =>  1,
            'role_ID' => 1
        ]); 
        Device::create([
            'name' =>  'Device101',
            'desc' => 'd1d2',
            'installed' => true,
            'mac_add' => '14-22-01-23-45',
            'location' => 'door'
        ]);
    }
}
