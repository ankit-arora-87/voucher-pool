<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // $this->call('UsersTableSeeder');
		for($i = 0; $i<10; $i++){
			 DB::table('offers')->insert([
				'name' => 'Special Offer for - '.$faker->name,
				'discount' => rand(1, 100) / 10
			]);
			
			 DB::table('recipients')->insert([
				'name' => $faker->name,
				'email' =>$faker->email
			]);
		}
	}
}
