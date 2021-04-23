<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\User;

class AnimalTableSeeder extends Seeder
{
 /**
 * Run the database seeds.
 * @return void
 */
 public function run()
 {
 //created an instance of Faker class to the variable $faker
 $faker = Faker::create();

 //getting all existing User ids into a $users array
 $users = User::all()->pluck('id')->toArray();



//generate 10 records for the accounts table
 foreach (range(1,10) as $index) {
 DB::table('animals')->insert([
 'userid' =>1,
 'name'=>$faker->name,
 'DOB'=>$faker->date($format = 'Y-m-d', $max = 'now'),
 'description'=>$faker->paragraph,
 ]);
 }
 }
}