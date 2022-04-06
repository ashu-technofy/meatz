<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'status' => 1,
                'role_id' => 1,
                'username' => 'hos',
                'first_name' => 'hos',
                'last_name' => NULL,
                'email' => 'admin@admin.com',
                'mobile' => '0976854543',
                'password' => bcrypt('123123'),
                'social_id' => NULL,
                'social_type' => NULL,
                'image' => NULL,
                'lang' => 'ar',
                'last_copon' => null,
                'remember_token' => null,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => '2021-01-18 13:24:45',
            ),
            1 => 
            array (
                'id' => 2,
                'status' => 1,
                'role_id' => NULL,
                'username' => 'hossam',
                'first_name' => 'hossam',
                'last_name' => NULL,
                'email' => 'hos@test.com',
                'mobile' => '12345678',
                'password' => bcrypt('123123'),
                'social_id' => NULL,
                'social_type' => NULL,
                'image' => NULL,
                'lang' => 'ar',
                'last_copon' => NULL,
                'remember_token' => null,
                'deleted_at' => NULL,
                'created_at' => '2020-12-03 17:40:16',
                'updated_at' => '2020-12-14 14:17:42',
            )
        ));
        
        
    }
}