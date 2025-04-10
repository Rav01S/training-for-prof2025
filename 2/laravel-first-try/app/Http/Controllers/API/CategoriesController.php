<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::query()->select([
            'id', 'name', 'description'
        ])->get();

        return response()->json(['data' => $categories]);
    }

    public function show(Category $category, Request $request): JsonResponse
    {
        $products = $category->products()->select([
            'id', 'name', 'description', 'price', 'image_url'
        ])->get();

        $formated_products = [];
        foreach ($products as $product) {
            $formated_products[] = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'image_url' => url($product->image_url)
            ];
        }

        return response()->json(['data' => $formated_products]);
    }
}
