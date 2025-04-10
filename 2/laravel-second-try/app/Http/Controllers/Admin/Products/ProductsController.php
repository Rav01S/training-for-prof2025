<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use GdImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductsController extends Controller
{
    public function index(): View
    {
        $products = Product::all();

        return view('pages.admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::query()->select([
            'name', 'id as value'
        ])->get();

        return view('pages.admin.products.create', compact('categories'));
    }

    public function show(Product $product): View
    {
        $categories = Category::query()->select([
            'name', 'id as value'
        ])->get();

        return view('pages.admin.products.show', compact('product', 'categories'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::query()->select([
            'name', 'id as value'
        ])->get();

        return view('pages.admin.products.edit', compact('product', 'categories'));
    }


    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:15',
            'description' => 'required|string|max:50',
            'price' => 'required|decimal:0,2',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|file|mimes:jpg|max:2048'
        ]);

        $newProduct = Product::query()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'image_url' => ''
        ]);

        $image_url = $this->saveImage($validated['image'], $newProduct->id);

        $newProduct->update([
            'image_url' => $image_url
        ]);

        return redirect()->back()->with(['success' => true, 'message' => 'Товар создан']);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:15',
            'description' => 'sometimes|string|max:50',
            'price' => 'sometimes|decimal:0,2',
            'category_id' => 'sometimes|exists:categories,id',
            'image' => 'sometimes|file|mimes:jpeg|max:2048'
        ]);

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
        ]);

        if (isset($validated['image'])) {
            $this->deleteImage($product->image_url);

            $image_url = $this->saveImage($validated['image'], $product->id);

            $product->update([
                'image_url' => $image_url
            ]);
        }

        return redirect()->back()->with(['success' => true, 'message' => 'Товар обновлен']);
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $this->deleteImage($product->image_url);

        $product->delete();

        return redirect()->back()->with(['success' => true, 'message' => 'Товар удален']);
    }


    private function saveImage(UploadedFile $image, $id): string
    {
        list($originalWidth, $originalHeight) = getimagesize($image->getRealPath());

        $maxWidth = 300;
        $maxHeight = 300;

        $ratio = min($maxHeight / $originalHeight, $maxWidth / $originalWidth);
        $newWidth = (int)($originalWidth * $ratio);
        $newHeight = (int)($originalHeight * $ratio);

        $miniImg = imagecreatetruecolor($newWidth, $newHeight);
        $originalImg = imagecreatefromjpeg($image->getRealPath());

        imagecopyresampled($miniImg, $originalImg, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

        $this->addWatermark($miniImg, $newWidth, $newHeight);

        $filename = "$id.jpeg";
        $path = storage_path("app/public/products/$filename");

        imagejpeg($miniImg, $path, 80);

        imagedestroy($miniImg);
        imagedestroy($originalImg);

        return Storage::url("/products/$filename");
    }

    private function addWatermark(GdImage &$image, $width, $height): void
    {
        $text = "Shop";
        $fontSize = 30;
        $fontPath = public_path('/verdana.ttf');
        $color = imagecolorallocatealpha($image, 0, 0, 0, 0);

        $x = $width - ($fontSize * strlen($text) * 0.6) - 30;
        $y = $height - imagefontheight($fontSize) - 30;

        imagettftext($image, $fontSize, 0, $x, $y, $color, $fontPath, $text);
    }

    private function deleteImage($path): void
    {
        Storage::delete($path);
    }
}
