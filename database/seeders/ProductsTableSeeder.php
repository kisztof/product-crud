<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tax;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taxes = Tax::all();
        Product::factory(100)->state(
            fn (array $attributes) => [
                'tax_id' => $taxes[random_int(0, $taxes->count() - 1)]->id,
            ]
        )->create();
    }
}
