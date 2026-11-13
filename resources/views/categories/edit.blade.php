@extends('layouts.admin')

@section('title', __('messages.categories'))
@section('page-title', __('messages.edit'))

@section('content')
    <div class="rounded-3xl border border-white/10 bg-slate-900/65 p-5 shadow-xl backdrop-blur-xl">
        <div class="mb-5 flex items-center justify-between">
            <h3 class="text-xl font-semibold text-white">{{ __('messages.edit') }}</h3>
            <a href="{{ route('categories.index') }}" class="text-sm text-slate-300 hover:text-white">{{ __('messages.back_to_list') }}</a>
        </div>

        <form method="POST" action="{{ route('categories.update', $category) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-medium text-slate-200">{{ __('messages.name') }}</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-white" required>
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-medium text-slate-200">{{ __('messages.description') }}</label>
                    <textarea name="description" rows="4" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-3 py-2.5 text-white">{{ old('description', $category->description) }}</textarea>
                </div>
            </div>

            <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/5 p-4">
                <h4 class="mb-3 text-sm font-semibold uppercase tracking-[0.18em] text-emerald-200">{{ __('messages.translation_fields') }}</h4>
                <div class="grid gap-4 md:grid-cols-3">
                    @foreach(['en' => __('messages.english_label'), 'tr' => __('messages.turkish_label'), 'ru' => __('messages.russian_label')] as $locale => $label)
                        <div class="space-y-2 rounded-2xl border border-slate-700 bg-slate-950/80 p-3">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ $label }}</p>
                            <input type="text" name="translations[{{ $locale }}][name]" value="{{ old("translations.$locale.name", $category->translations->firstWhere('locale', $locale)?->name) }}" placeholder="{{ __('messages.name') }}" class="w-full rounded-xl border border-slate-700 bg-slate-900 px-3 py-2 text-sm text-white">
                            <textarea name="translations[{{ $locale }}][description]" rows="3" placeholder="{{ __('messages.description') }}" class="w-full rounded-xl border border-slate-700 bg-slate-900 px-3 py-2 text-sm text-white">{{ old("translations.$locale.description", $category->translations->firstWhere('locale', $locale)?->description) }}</textarea>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('categories.index') }}" class="rounded-xl border border-slate-700 px-4 py-2 text-sm text-slate-200">{{ __('messages.cancel') }}</a>
                <button type="submit" class="rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-900">{{ __('messages.save') }}</button>
            </div>
        </form>
    </div>
@endsection
