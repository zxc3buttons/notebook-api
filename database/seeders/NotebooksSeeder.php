<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class NotebooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('notebooks')->insert([
                'full_name' => $faker->name(),
                'company' => $faker->company(),
                'phone' => $faker->phoneNumber(),
                'email' => $faker->email(),
                'birth_date' => $faker->dateTimeBetween('-60 years', '-18 years')
                    ->format('Y-m-d'),
                'image_link' => $faker->imageUrl(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
