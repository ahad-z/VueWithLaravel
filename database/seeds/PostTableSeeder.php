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
            $title = $faker->sentence;

            Post::create([
                "user_id"     => rand(1, 20),
                "category_id" => rand(1,20),
                "title"       => $title,
                "post_slug"   =>$this->slugify($title),
                "content"     => $faker->paragraph,
                "thumbnail"   => $faker->imageUrl(),
                "status"      => $this->getRandomStatus(),
            ]);
       }

    }

    public function getRandomStatus()
    {
        $status = array('draft', 'published');
        return $status[array_rand($status)];
    }
    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }


}
