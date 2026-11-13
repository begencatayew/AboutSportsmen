<?php

namespace App\Http\Controllers;

use App\Models\Fact;
use App\Models\Player;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FactController extends Controller
{
    public function index(): View
    {
        $facts = Fact::with('player')->latest()->paginate(10);

        return view('facts.index', compact('facts'));
    }

    public function create(): View
    {
        $players = Player::orderBy('name')->get();

        return view('facts.create', compact('players'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'player_id' => ['required', 'exists:players,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'translations.en.title' => ['nullable', 'string', 'max:255'],
            'translations.en.description' => ['nullable', 'string'],
            'translations.tr.title' => ['nullable', 'string', 'max:255'],
            'translations.tr.description' => ['nullable', 'string'],
            'translations.ru.title' => ['nullable', 'string', 'max:255'],
            'translations.ru.description' => ['nullable', 'string'],
        ]);

        $fact = Fact::create([
            'player_id' => $data['player_id'],
            'title' => $data['title'],
            'description' => $data['description'],
        ]);

        $this->syncTranslations($fact, $request->input('translations', []));

        return redirect()->route('facts.index')->with('success', __('messages.fact_created'));
    }

    public function edit(Fact $fact): View
    {
        $players = Player::orderBy('name')->get();

        return view('facts.edit', compact('fact', 'players'));
    }

    public function update(Request $request, Fact $fact): RedirectResponse
    {
        $data = $request->validate([
            'player_id' => ['required', 'exists:players,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'translations.en.title' => ['nullable', 'string', 'max:255'],
            'translations.en.description' => ['nullable', 'string'],
            'translations.tr.title' => ['nullable', 'string', 'max:255'],
            'translations.tr.description' => ['nullable', 'string'],
            'translations.ru.title' => ['nullable', 'string', 'max:255'],
            'translations.ru.description' => ['nullable', 'string'],
        ]);

        $fact->update([
            'player_id' => $data['player_id'],
            'title' => $data['title'],
            'description' => $data['description'],
        ]);

        $this->syncTranslations($fact, $request->input('translations', []));

        return redirect()->route('facts.index')->with('success', __('messages.fact_updated'));
    }

    public function destroy(Fact $fact): RedirectResponse
    {
        $fact->delete();

        return redirect()->route('facts.index')->with('success', __('messages.fact_deleted'));
    }

    protected function syncTranslations(Fact $fact, array $translations): void
    {
        foreach (['en', 'tr', 'ru'] as $locale) {
            $payload = $translations[$locale] ?? [];

            if (empty($payload['title']) && empty($payload['description'])) {
                continue;
            }

            $fact->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'title' => $payload['title'] ?? $fact->title,
                    'description' => $payload['description'] ?? $fact->description,
                ],
            );
        }
    }
}
