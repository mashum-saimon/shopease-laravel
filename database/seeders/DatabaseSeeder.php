<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(['email' => 'demo@example.com'], ['name' => 'Demo User']);

        $brands = collect(['Apple', 'Samsung', 'Sony', 'Nike', 'Adidas', 'Dell'])->map(fn ($name) => Brand::firstOrCreate(
            ['slug' => Str::slug($name)],
            ['name' => $name, 'image' => 'https://picsum.photos/seed/brand-'.Str::slug($name).'/200/120'],
        ));

        $categories = collect(['Phones', 'Laptops', 'Audio', 'Shoes', 'Watches', 'Cameras'])->map(fn ($name) => Category::firstOrCreate(
            ['slug' => Str::slug($name)],
            ['name' => $name, 'image' => 'https://picsum.photos/seed/cat-'.Str::slug($name).'/200/120'],
        ));

        $sliders = [
            ['Mega Tech Sale', 'Up to 30% off on phones and laptops', 'slider-1'],
            ['Step Into Style', 'New arrivals in sports shoes', 'slider-2'],
            ['Sound That Moves You', 'Premium headphones and speakers', 'slider-3'],
        ];
        foreach ($sliders as [$title, $subtitle, $seed]) {
            Slider::firstOrCreate(['title' => $title], [
                'subtitle' => $subtitle,
                'image' => "https://picsum.photos/seed/{$seed}/1400/500",
                'link' => '/products',
            ]);
        }

        for ($i = 1; $i <= 24; $i++) {
            $name = 'Product '.$i;
            Product::firstOrCreate(['slug' => Str::slug($name)], [
                'brand_id' => $brands[$i % $brands->count()]->id,
                'category_id' => $categories[$i % $categories->count()]->id,
                'name' => $name,
                'description' => 'High quality item number '.$i.'. Built to last with a modern design, reliable performance and a one-year warranty.',
                'price' => rand(20, 1500) + 0.99,
                'image' => "https://picsum.photos/seed/product-{$i}/600/450",
                'is_featured' => $i % 3 === 0,
            ]);
        }
    }
}
