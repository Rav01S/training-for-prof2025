<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    public function index(Request $request): View
    {
        $page = $request->query('page') ?? 1;
        $categories = Category::query()->forPage($page, 5);

        return view('pages.admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('pages.admin.categories.create');
    }

    public function show(Category $category): View
    {
        return view('pages.admin.categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        return view('pages.admin.categories.edit', compact('category'));
    }


    public function store(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:15',
            'description' => 'nullable|string|max:50'
        ]);

        Category::query()->create($request->only('name', 'description'));

        return redirect()->back()->with(['success' => true, 'message' => 'Категория создана']);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:15',
            'description' => 'nullable|string|max:50'
        ]);

        $category->update($request->only('name', 'description'));

        return redirect()->back()->with(['success' => true, 'message' => 'Категория обновлена']);
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        $page = $request->query('page');

        $category->delete();

        return redirect()->route('admin.categories.index')->with(['success' => true, 'message' => 'Категория удалена']);
    }
}
