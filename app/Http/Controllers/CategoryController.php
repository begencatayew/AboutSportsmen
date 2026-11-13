<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('players')->latest()->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'translations.en.name' => ['nullable', 'string', 'max:255'],
            'translations.en.description' => ['nullable', 'string'],
            'translations.tr.name' => ['nullable', 'string', 'max:255'],
            'translations.tr.description' => ['nullable', 'string'],
            'translations.ru.name' => ['nullable', 'string', 'max:255'],
            'translations.ru.description' => ['nullable', 'string'],
        ]);

        $category = Category::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);

        $this->syncTranslations($category, $request->input('translations', []));

        return redirect()->route('categories.index')->with('success', __('messages.category_created'));
    }

    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'translations.en.name' => ['nullable', 'string', 'max:255'],
            'translations.en.description' => ['nullable', 'string'],
            'translations.tr.name' => ['nullable', 'string', 'max:255'],
            'translations.tr.description' => ['nullable', 'string'],
            'translations.ru.name' => ['nullable', 'string', 'max:255'],
            'translations.ru.description' => ['nullable', 'string'],
        ]);

        $category->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);

        $this->syncTranslations($category, $request->input('translations', []));

        return redirect()->route('categories.index')->with('success', __('messages.category_updated'));
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', __('messages.category_deleted'));
    }

    protected function syncTranslations(Category $category, array $translations): void
    {
        foreach (['en', 'tr', 'ru'] as $locale) {
            $payload = $translations[$locale] ?? [];

            if (empty($payload['name']) && empty($payload['description'])) {
                continue;
            }

            $category->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'name' => $payload['name'] ?? $category->name,
                    'description' => $payload['description'] ?? null,
                ],
            );
        }
    }
}
