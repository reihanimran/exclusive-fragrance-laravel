<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'category_name' => 'Limited-Edition Exclusives',
                'description' => 'A rare collection of luxurious fragrances crafted for special moments. These exclusive scents are available in limited quantities, offering unique, captivating aromas that leave a lasting impression. Perfect for those who seek elegance and individuality.',
                'featured_img' => 'uploads/categories/678a1ec3c8be4.png'
            ],
            [
                'category_name' => 'Everyday Classic',
                'description' => 'A timeless collection of fragrances designed for daily wear, blending subtle elegance with lasting freshness. Perfect for any occasion, these perfumes offer a balanced aroma that complements your natural charm, making them ideal for work, casual outings.',
                'featured_img' => 'uploads/categories/678a1f077a1ed.png'
            ],
            [
                'category_name' => 'Enchanted Evenings',
                'description' => 'A captivating collection of fragrances designed to add a touch of mystery and allure to your evenings. With rich, elegant notes, these perfumes create a mesmerizing aura, perfect for romantic nights and special occasions.',
                'featured_img' => 'uploads/categories/678a1f31df9bf.png'
            ],
            [
                'category_name' => 'Bridal Collections',
                'description' => 'A captivating selection of elegant perfumes, crafted to add a touch of romance and sophistication to your special day. Perfect for weddings and memorable celebrations.',
                'featured_img' => 'uploads/categories/678a1f66297e1.png'
            ],
            [
                'category_name' => 'Seasonal Picks',
                'description' => 'A curated collection of fragrances inspired by the essence of each season. Refreshing scents for summer, cozy notes for winter, and floral delights for spring—perfect for every time of the year.',
                'featured_img' => 'uploads/categories/678a1f964ee05.png'
            ],
            [
                'category_name' => ' Athleisure Collection',
                'description' => 'Energizing and refreshing fragrances designed for active lifestyles. Perfect for staying fresh and confident during workouts, casual outings, and on-the-go moments.',
                'featured_img' => 'uploads/categories/678a1fc8a05a1.png'
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}