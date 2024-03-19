<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Product A',
                'company_id' => 1,
                'price' => 1000,
                'stock' => 50,
                'comment' => 'This is a sample product A.',
                'image_path' => 'images/product_a.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product B',
                'company_id' => 2,
                'price' => 2500,
                'stock' => 30,
                'comment' => 'This is a sample product B.',
                'image_path' => 'images/product_b.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product C',
                'company_id' => 3,
                'price' => 5000,
                'stock' => 20,
                'comment' => 'This is a sample product C.',
                'image_path' => 'images/product_c.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product D',
                'company_id' => 4,
                'price' => 3000,
                'stock' => 40,
                'comment' => 'This is a sample product D.',
                'image_path' => 'images/product_d.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product E',
                'company_id' => 5,
                'price' => 1500,
                'stock' => 60,
                'comment' => 'This is a sample product E.',
                'image_path' => 'images/product_e.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}