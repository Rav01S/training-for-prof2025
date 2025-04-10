<?php

namespace App\Http\Controllers\AdminPanel;

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

        return view('pages.AdminPanel.products.index', compact('products'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::query()
            ->select([
                'id as value', 'name'
            ])
            ->get();
        return view('pages.AdminPanel.products.edit', compact('categories', 'product'));
    }

    public function create(): View
    {
        $categories = Category::query()
            ->select([
                'id as value', 'name'
            ])
            ->get();
        return view('pages.AdminPanel.products.create', compact('categories'));
    }


    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:20',
            'description' => 'required|string|max:50',
            'price' => 'required|decimal:0,2|min:10',
            'image' => 'required|file|mimes:jpg|max:2048',
            'category_id' => 'required|integer|exists:categories,id'
        ]);

        $newProduct = Product::query()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'image_url' => "",
            'category_id' => $validated['category_id'],
        ]);

        $image_url = $this->saveImage($validated['image'], $newProduct->id);

        $newProduct->update([
            'image_url' => $image_url
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with(['success' => true, 'message' => 'Товар успешно создан']);
    }

    public function update(Product $product, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:20',
            'description' => 'sometimes|string|max:50',
            'price' => 'sometimes|decimal:0,2|min:10',
            'image' => 'sometimes|file|mimes:jpg|max:2048',
            'category_id' => 'sometimes|integer|exists:categories,id'
        ]);

        $product->update($request->except('image'));

        if (isset($validated['image'])) {
            Storage::delete($product->image_url);

            $image_url = $this->saveImage($validated['image'], $product->id);

            $product->update([
                'image_url' => $image_url
            ]);
        }

        return redirect()
            ->route('admin.products.index')
            ->with(['success' => true, 'message' => 'Товар успешно обновлен']);
    }

    public function destroy(Product $product): RedirectResponse
    {
        Storage::delete($product->image_url);

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with(['success' => true, 'message' => 'Товар успешно удален']);
    }

    public function show(Product $product): View
    {
        $categories = Category::query()
            ->select([
                'id as value', 'name'
            ])
            ->get();
        return view('pages.AdminPanel.products.show', compact('categories', 'product'));
    }


    private function saveImage(UploadedFile $image, $id)
    {
        $maxWidth = 300;
        $maxHeight = 300;

        list($originalWidth, $originalHeight) = getimagesize($image->getRealPath());

        $scale = min($maxWidth / $originalWidth, $maxHeight / $originalHeight);
        $newWidth = (int)($originalWidth * $scale);
        $newHeight = (int)($originalHeight * $scale);

        $srcImage = imagecreatefromjpeg($image->getRealPath());
        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresampled($newImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

        $this->addWatermark($newImage, $newWidth, $newHeight);

        $filename = "$id.jpeg";
        $path = storage_path("app/public/products/$filename");

        imagejpeg($newImage, $path, 85);

        imagedestroy($srcImage);
        imagedestroy($newImage);

        return Storage::url("products/$filename");
    }

    private function addWatermark(GdImage &$image, $width, $height)
    {
        $text = 'Shop';
        $fontSize = 6;
        $textColor = imagecolorallocatealpha($image, 0, 0, 0, 50);

        $textWidth = imagefontwidth($fontSize) * strlen($fontSize);
        $textHeight = imagefontheight($fontSize);

        $x = $width - $textWidth - 30;
        $y = $height - $textHeight - 10;

        imagestring($image, $fontSize, $x, $y, $text, $textColor);
    }
}
