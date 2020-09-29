<?php

use Illuminate\Database\Seeder;
use App\Post;
class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        foreach (range(1, 20) as $index){

            Post::create([
                "user_id"   => rand(1, 20),
                "category_id" => rand(1,20),
                "title" => $faker->sentence,
                "content" => $faker->paragraph,
                "thumbnail" => $faker->imageUrl(),
                "status" => $this->getRandomStatus(),
            ]);
       }

    }

    public function getRandomStatus()
    {
        $status = array('draft', 'published');
        return $status[array_rand($status)];
    }
}
