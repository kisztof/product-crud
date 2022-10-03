<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Product::simplePaginate(10));
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'tax_id' => $request->tax,
        ]);

        return response()->json($product, 201);
    }

    public function show(Product $product): JsonResponse
    {
        return \response()->json($product, 200);
    }

    public function update(StoreProductRequest $request, Product $product): JsonResponse
    {
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'tax_id' => 'b'
        ]);

        return response()->json($product);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return \response()->json([], 204);
    }
}
