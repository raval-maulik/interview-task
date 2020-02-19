<?php

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
    	$email = ["gmail","ymail","hotmail"];
    	$gender = ["m","f"];
    	for($i = 0; $i < 3000; $i++) {
	        App\User::create([
	            'name' => str_random(10),
	            'gender' => $gender[rand(0,1)],
	            'city' => str_random(10),
	            'address' => str_random(20),
	            'email' => str_random(10).'@'.$email[rand(0,2)].'.com',
	            'password' => bcrypt('secret'),
	        ]);
	    }
    }
}
