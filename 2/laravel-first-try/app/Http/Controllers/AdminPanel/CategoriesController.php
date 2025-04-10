<?php

namespace App\Http\Controllers\AdminPanel;

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
        return view('pages.AdminPanel.categories.index', compact('categories'));
    }

    public function edit(Category $category): View
    {
        return view('pages.AdminPanel.categories.edit', compact('category'));
    }

    public function create(): View
    {
        return view('pages.AdminPanel.categories.create');
    }

    public function show(Category $category): View {
        return view('pages.AdminPanel.categories.show', compact('category'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:15',
            'description' => 'required|string|max:60'
        ]);

        Category::query()->create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with(['success' => true, 'message' => 'Категория успешно добавлена']);
    }

    public function update(Category $category, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:15',
            'description' => 'required|string|max:60'
        ]);

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with(['success' => true, 'message' => 'Категория успешно обновлена']);
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
        return redirect()
            ->route('admin.categories.index')
            ->with(['success' => true, 'message' => "Категория успешно удалена"]);
    }
}
