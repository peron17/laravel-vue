<?php

namespace Database\Seeders;

use App\Models\books;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class bookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 200; $i++) {
            $books = new books();

            $books->isbn = $faker->randomNumber(8);
            $books->title = $faker->name;
            $books->year = rand(2010, 2022);
            $books->publisher_id = rand(1, 200);
            $books->author_id = rand(1, 200);
            $books->catalog_id = rand(1, 200);
            $books->qty = rand(1, 200);
            $books->price = rand(10000, 200000);

            $books->save();
        }
    }
}