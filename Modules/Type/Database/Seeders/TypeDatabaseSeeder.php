<?php

namespace Modules\Type\Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Modules\Type\Entities\Type;

class TypeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Seed data using Eloquent model and Faker
        for ($i = 0; $i < 10; $i++) {
            Type::create([
                'name' => $faker->word,
                // Add other fields and Faker methods as needed
            ]);
        }
    }
}
