<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function testGetProductsRecords(): void
    {
        /** @var TestResponse $response */
        $response = $this->get('/api/products');

        $response
            ->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
            $json
                ->hasAll([
                    'first_page_url',
                    'from',
                    'next_page_url',
                    'path',
                    'prev_page_url',
                    'to',
                    'data',
                    'per_page',
                    'current_page',
                ])
                ->whereAllType([
                'data.0.name' => 'string',
                'data.0.description' => 'string',
                'data.0.price' => 'integer',
                'data.0.tax.id' => 'string',
                'data.0.tax.value' => 'integer'
            ])
            );

        /** @var TestResponse $response */
        $response = $this->get('/api/products?page=2');
        $response
            ->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
            $json
                ->hasAll([
                    'first_page_url',
                    'from',
                    'next_page_url',
                    'path',
                    'prev_page_url',
                    'to',
                    'data',
                    'per_page',
                    'current_page',
                ])
                ->whereAllType([
                    'data.0.name' => 'string',
                    'data.0.description' => 'string',
                    'data.0.price' => 'integer',
                    'data.0.tax.id' => 'string',
                    'data.0.tax.value' => 'integer'
                ])
            );
    }

    public function testGetProduct(): void
    {
        $product = Product::create([
            'name' => 'TestProduct',
            'description' => 'Some long description.',
            'price' => 1000,
            'tax_id' => 'a',
        ]);

        /** @var TestResponse $response */
        $response = $this->get('/api/products/' . $product->id);

        $response->assertStatus(200)
            ->assertJsonPath('name', 'TestProduct')
            ->assertJsonPath('description', 'Some long description.')
            ->assertJsonPath('price', 1000)
            ->assertJsonPath('tax.id', 'a');
    }

    public function testGetProduct404(): void
    {
        /** @var TestResponse $response */
        $response = $this->get('/api/products/' . fake()->uuid);

        $response->assertStatus(404);
    }

    public function testPostUpdateProductValid(): void
    {
        $product = Product::create([
            'name' => 'TestProduct',
            'description' => 'Some long description.',
            'price' => 1000,
            'tax_id' => 'a',
        ]);

        $response = $this->putJson(
            '/api/products/' . $product->id,
            [
                'name' => 'Updated',
                'description' => 'Updated',
                'price' => 1,
                'tax' => 'b',
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJsonPath('name', 'Updated')
            ->assertJsonPath('description', 'Updated')
            ->assertJsonPath('price', 1);
    }

    public function testPostNewProductValid(): void
    {
        $response = $this->postJson(
            '/api/products',
            [
                'name' => 'TestProduct',
                'description' => 'Some long description.',
                'price' => 1000,
                'tax' => 'a',
            ]
        );

        $response
            ->assertStatus(201)
            ->assertJsonPath('name', 'TestProduct')
            ->assertJsonPath('description', 'Some long description.')
            ->assertJsonPath('price', 1000)
            ->assertJsonPath('tax.id', 'a');
    }

    public function testPostNewProductInvalid(): void
    {
        $response = $this->postJson(
            '/api/products',
            [
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', 'The name field is required. (and 3 more errors)')
            ->assertJsonPath('errors.name.0', 'The name field is required.')
            ->assertJsonPath('errors.description.0', 'The description field is required.')
            ->assertJsonPath('errors.price.0', 'The price field is required.')
            ->assertJsonPath('errors.tax.0', 'The tax field is required.');

        $response = $this->postJson(
            '/api/products',
            [
                'name' => fake()->regexify('[A-Za-z0-9]{300}'),
                'description' => 'Some long description.',
                'price' => -500,
                'tax' => 'a',
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', 'The name must not be greater than 255 characters. (and 1 more error)')
            ->assertJsonPath('errors.price.0', 'The price must be at least 0.')
            ->assertJsonPath('errors.name.0', 'The name must not be greater than 255 characters.');
    }

    public function testDeleteProduct(): void
    {
        $product = Product::create([
            'name' => 'TestProduct',
            'description' => 'Some long description.',
            'price' => 1000,
            'tax_id' => 'a',
        ]);

        $response = $this->deleteJson(
            '/api/products/' . $product->id
        );

        $response
            ->assertStatus(204);

        $response = $this->getJson(
            '/api/products/' . $product->id
        );

        $response
            ->assertStatus(404);
    }
}
