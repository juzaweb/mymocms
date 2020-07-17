<?php

use Illuminate\Database\Seeder;

class MoviesSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
        foreach (range(1, 50) as $row) {
            $name = $faker->name;
            $genres = \App\Models\Genres::where('status', '=', 1)
                ->inRandomOrder()
                ->limit(3)
                ->pluck('id')
                ->toArray();
            
            $countries = \App\Models\Countries::where('status', '=', 1)
                ->inRandomOrder()
                ->limit(3)
                ->pluck('id')
                ->toArray();
            
            $tags = \App\Models\Tags::inRandomOrder()
                ->limit(3)
                ->pluck('id')
                ->toArray();
            $type = \App\Models\Types::inRandomOrder()->first();
            $random_key = array_rand([1, 2],1);
            
            DB::table('movies')->insert([
                'name' => $name,
                'other_name' => $faker->name,
                'type_id' => $type->id,
                'genres' => implode(',', $genres),
                'countries' => implode(',', $countries),
                'tags' => implode(',', $tags),
                'slug' => \Illuminate\Support\Str::slug($name),
                'tv_series' => $random_key,
                'video_quality' => 'HD',
                'description' => $faker->sentence(50),
                'short_description' => $faker->sentence(10),
                'release' => $faker->date(),
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime(),
            ]);
        }
    }
}
