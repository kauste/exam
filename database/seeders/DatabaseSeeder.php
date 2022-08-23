<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('lt_LT');
        foreach(range(1, 10) as $_){
            DB::table('menus')->insert([
                'menu_name'=>  $faker->firstName . ' menu',
            ]);
        }
        foreach(range(1, 10) as $_){
            DB::table('restaurants')->insert([
                'restaurant_name'=>  $faker->firstName . ' restaurant',
                'city'=> $faker->city,
                'adress'=> $faker->streetAddress,
                'menu_id'=> rand(1, 10),
            ]);
        }
        $dishes = ['soup', 'butter', 'bread', 'orange', 'banana', 'pizza', 'borsch', 'cepelinai', 'corns', 'cornflakes', 'suflowerseeds'];
        foreach(range(1, 30) as $_){
            DB::table('dishes')->insert([
                'dish_name'=>  $dishes[rand(0, 10)] . ' and ' . $dishes[rand(0, 10)],
                'description'=> 'place for description',
                'menu_id'=> rand(1, 10),
            ]);
        }
  
        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => Hash::make('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Adnim',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123'),
            'role'=> 10,
        ]);
    }
}
