<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_roles')->delete();
        
        \DB::table('user_roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Super admin',
                'roles' => '["Ads", "Areas", "Common", "Contactus", "Copons", "Cuisine", "Orders", "Pages", "Services", "Sliders", "Stores", "Subscribe", "User", "Categories", "Options", "Products", "Cuisines" , "StoresRequests"]',
                'created_at' => NULL,
                'updated_at' => '2020-12-02 18:20:44',
            ),
        ));
        
        
    }
}