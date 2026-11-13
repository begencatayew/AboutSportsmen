@extends('layouts.admin')

@section('title', __('messages.players'))
@section('page-title', __('messages.edit'))

@section('content')
    <div class="rounded-3xl border border-white/10 bg-slate-900/65 p-5 shadow-xl backdrop-blur-xl">
        <div class="mb-5 flex items-center justify-between">
            <h3 class="text-xl font-semibold text-white">{{ __('messages.edit') }}</h3>
            <a href="{{ route('players.index') }}" class="text-sm text-slate-300 hover:text-white">{{ __('messages.back_to_list') }}</a>
        </div>

        <form method="POST" action="{{ route('players.update', $player) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-200">{{ __('messages.category') }}</label>
                    <select name="category_id" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-white" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $player->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-200">{{ __('messages.name') }}</label>
                    <input type="text" name="name" value="{{ old('name', $player->name) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-white" required>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-200">{{ __('messages.team') }}</label>
                    <input type="text" name="team" value="{{ old('team', $player->team) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-white" required>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-200">{{ __('messages.position') }}</label>
                    <input type="text" name="position" value="{{ old('position', $player->position) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-white" required>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-200">{{ __('messages.nationality') }}</label>
                    <input type="text" name="nationality" value="{{ old('nationality', $player->nationality) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-white" required>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-200">{{ __('messages.date_of_birth') }}</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $player->date_of_birth?->format('Y-m-d')) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-white">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-200">{{ __('messages.height') }}</label>
                    <input type="number" step="0.01" name="height" value="{{ old('height', $player->height) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-white">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-200">{{ __('messages.weight') }}</label>
                    <input type="number" step="0.01" name="weight" value="{{ old('weight', $player->weight) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-white">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-200">{{ __('messages.jersey_number') }}</label>
                    <input type="number" name="jersey_number" value="{{ old('jersey_number', $player->jersey_number) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-white">
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-medium text-slate-200">{{ __('messages.image') }}</label>
                    @if($player->image)
                        <img src="{{ asset('storage/'.$player->image) }}" alt="{{ $player->name }}" class="mb-3 h-24 w-24 rounded-xl object-cover">
                    @endif
                    <input type="file" name="image" accept="image/*" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-white">
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-medium text-slate-200">{{ __('messages.biography') }}</label>
                    <textarea name="biography" rows="4" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-white">{{ old('biography', $player->biography) }}</textarea>
                </div>
            </div>

            <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/5 p-4">
                <h4 class="mb-3 text-sm font-semibold uppercase tracking-[0.18em] text-emerald-200">{{ __('messages.translation_fields') }}</h4>
                <div class="grid gap-4 md:grid-cols-3">
                    @foreach(['en' => __('messages.english_label'), 'tr' => __('messages.turkish_label'), 'ru' => __('messages.russian_label')] as $locale => $label)
                        <div class="space-y-2 rounded-2xl border border-slate-700 bg-slate-950/80 p-3">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ $label }}</p>
                            <input type="text" name="translations[{{ $locale }}][name]" value="{{ old("translations.$locale.name", $player->translations->firstWhere('locale', $locale)?->name) }}" placeholder="{{ __('messages.name') }}" class="w-full rounded-xl border border-slate-700 bg-slate-900 px-3 py-2 text-sm text-white">
                            <input type="text" name="translations[{{ $locale }}][team]" value="{{ old("translations.$locale.team", $player->translations->firstWhere('locale', $locale)?->team) }}" placeholder="{{ __('messages.team') }}" class="w-full rounded-xl border border-slate-700 bg-slate-900 px-3 py-2 text-sm text-white">
                            <input type="text" name="translations[{{ $locale }}][position]" value="{{ old("translations.$locale.position", $player->translations->firstWhere('locale', $locale)?->position) }}" placeholder="{{ __('messages.position') }}" class="w-full rounded-xl border border-slate-700 bg-slate-900 px-3 py-2 text-sm text-white">
                            <input type="text" name="translations[{{ $locale }}][nationality]" value="{{ old("translations.$locale.nationality", $player->translations->firstWhere('locale', $locale)?->nationality) }}" placeholder="{{ __('messages.nationality') }}" class="w-full rounded-xl border border-slate-700 bg-slate-900 px-3 py-2 text-sm text-white">
                            <textarea name="translations[{{ $locale }}][biography]" rows="3" placeholder="{{ __('messages.biography') }}" class="w-full rounded-xl border border-slate-700 bg-slate-900 px-3 py-2 text-sm text-white">{{ old("translations.$locale.biography", $player->translations->firstWhere('locale', $locale)?->biography) }}</textarea>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('players.index') }}" class="rounded-xl border border-slate-700 px-4 py-2 text-sm text-slate-200">{{ __('messages.cancel') }}</a>
                <button type="submit" class="rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-900">{{ __('messages.save') }}</button>
            </div>
        </form>
    </div>
@endsection
