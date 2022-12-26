<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\product_category;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        product_category::create([
            'name' => 'Жилая мебель',
        ]);
        product_category::create([
            'name' => 'Кухни',
        ]);
        product_category::create([
            'name' => 'Прихожие',
        ]);
        product_category::create([
            'name' => 'Мебель для ванной',
        ]);
        product_category::create([
            'name' => 'Мебель для спальни ',
        ]);
        product_category::create([
            'name' => 'Гардеробные',
        ]);
        product_category::create([
            'name' => 'Гостиные',
        ]);
        product_category::create([
            'name' => 'Детские',
        ]);
        product_category::create([
            'name' => 'Кабинеты',
        ]);
        product_category::create([
            'name' => 'Межкомнатные перегородки',
        ]);
        product_category::create([
            'name' => 'Островные павильоны',
        ]);
        product_category::create([
            'name' => 'Зоны ресепшн',
        ]);
        product_category::create([
            'name' => 'Выставочные стенды',
        ]);
    }
}
