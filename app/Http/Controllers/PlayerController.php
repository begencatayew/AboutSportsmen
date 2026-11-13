<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Player;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PlayerController extends Controller
{
    public function index(): View
    {
        $players = Player::with('category')->latest()->paginate(10);

        return view('players.index', compact('players'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('players.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'team' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'nationality' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'height' => ['nullable', 'numeric'],
            'weight' => ['nullable', 'numeric'],
            'jersey_number' => ['nullable', 'integer'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],
            'biography' => ['nullable', 'string'],
            'translations.en.name' => ['nullable', 'string', 'max:255'],
            'translations.en.team' => ['nullable', 'string', 'max:255'],
            'translations.en.position' => ['nullable', 'string', 'max:255'],
            'translations.en.nationality' => ['nullable', 'string', 'max:255'],
            'translations.en.biography' => ['nullable', 'string'],
            'translations.tr.name' => ['nullable', 'string', 'max:255'],
            'translations.tr.team' => ['nullable', 'string', 'max:255'],
            'translations.tr.position' => ['nullable', 'string', 'max:255'],
            'translations.tr.nationality' => ['nullable', 'string', 'max:255'],
            'translations.tr.biography' => ['nullable', 'string'],
            'translations.ru.name' => ['nullable', 'string', 'max:255'],
            'translations.ru.team' => ['nullable', 'string', 'max:255'],
            'translations.ru.position' => ['nullable', 'string', 'max:255'],
            'translations.ru.nationality' => ['nullable', 'string', 'max:255'],
            'translations.ru.biography' => ['nullable', 'string'],
        ]);

        $player = Player::create([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'team' => $data['team'],
            'position' => $data['position'],
            'nationality' => $data['nationality'],
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'height' => $data['height'] ?? null,
            'weight' => $data['weight'] ?? null,
            'jersey_number' => $data['jersey_number'] ?? null,
            'image' => $request->file('image') ? Storage::disk('public')->putFile('players', $request->file('image')) : null,
            'biography' => $data['biography'] ?? null,
        ]);

        $this->syncTranslations($player, $request->input('translations', []));

        return redirect()->route('players.index')->with('success', __('messages.player_created'));
    }

    public function edit(Player $player): View
    {
        $categories = Category::orderBy('name')->get();

        return view('players.edit', compact('player', 'categories'));
    }

    public function update(Request $request, Player $player): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'team' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'nationality' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'height' => ['nullable', 'numeric'],
            'weight' => ['nullable', 'numeric'],
            'jersey_number' => ['nullable', 'integer'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],
            'biography' => ['nullable', 'string'],
            'translations.en.name' => ['nullable', 'string', 'max:255'],
            'translations.en.team' => ['nullable', 'string', 'max:255'],
            'translations.en.position' => ['nullable', 'string', 'max:255'],
            'translations.en.nationality' => ['nullable', 'string', 'max:255'],
            'translations.en.biography' => ['nullable', 'string'],
            'translations.tr.name' => ['nullable', 'string', 'max:255'],
            'translations.tr.team' => ['nullable', 'string', 'max:255'],
            'translations.tr.position' => ['nullable', 'string', 'max:255'],
            'translations.tr.nationality' => ['nullable', 'string', 'max:255'],
            'translations.tr.biography' => ['nullable', 'string'],
            'translations.ru.name' => ['nullable', 'string', 'max:255'],
            'translations.ru.team' => ['nullable', 'string', 'max:255'],
            'translations.ru.position' => ['nullable', 'string', 'max:255'],
            'translations.ru.nationality' => ['nullable', 'string', 'max:255'],
            'translations.ru.biography' => ['nullable', 'string'],
        ]);

        $image = $player->image;

        if ($request->hasFile('image')) {
            if ($player->image && Storage::disk('public')->exists($player->image)) {
                Storage::disk('public')->delete($player->image);
            }

            $image = Storage::disk('public')->putFile('players', $request->file('image'));
        }

        $player->update([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'team' => $data['team'],
            'position' => $data['position'],
            'nationality' => $data['nationality'],
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'height' => $data['height'] ?? null,
            'weight' => $data['weight'] ?? null,
            'jersey_number' => $data['jersey_number'] ?? null,
            'image' => $image,
            'biography' => $data['biography'] ?? null,
        ]);

        $this->syncTranslations($player, $request->input('translations', []));

        return redirect()->route('players.index')->with('success', __('messages.player_updated'));
    }

    public function destroy(Player $player): RedirectResponse
    {
        if ($player->image && Storage::disk('public')->exists($player->image)) {
            Storage::disk('public')->delete($player->image);
        }

        $player->delete();

        return redirect()->route('players.index')->with('success', __('messages.player_deleted'));
    }

    protected function syncTranslations(Player $player, array $translations): void
    {
        foreach (['en', 'tr', 'ru'] as $locale) {
            $payload = $translations[$locale] ?? [];

            if (empty($payload['name']) && empty($payload['team']) && empty($payload['position']) && empty($payload['nationality']) && empty($payload['biography'])) {
                continue;
            }

            $player->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'name' => $payload['name'] ?? $player->name,
                    'team' => $payload['team'] ?? $player->team,
                    'position' => $payload['position'] ?? $player->position,
                    'nationality' => $payload['nationality'] ?? $player->nationality,
                    'biography' => $payload['biography'] ?? $player->biography,
                ],
            );
        }
    }
}
