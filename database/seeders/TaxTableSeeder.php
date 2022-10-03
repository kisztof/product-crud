<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Seeder;

class TaxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tax::factory()->create([
            'id' => 'a',
            'value' => 23,
        ]);

        Tax::factory()->create([
            'id' => 'b',
            'value' => 8,
        ]);

        Tax::factory()->create([
            'id' => 'c',
            'value' => 5,
        ]);

        Tax::factory()->create([
            'id' => 'd',
            'value' => 0,
        ]);
    }
}
