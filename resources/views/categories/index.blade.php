@extends('layouts.admin')

@section('title', __('messages.categories'))
@section('page-title', __('messages.categories'))

@section('content')
    <div class="rounded-3xl border border-white/10 bg-slate-900/65 p-5 shadow-xl backdrop-blur-xl">
        <div class="mb-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h3 class="text-xl font-semibold text-white">{{ __('messages.categories') }}</h3>
                <p class="text-sm text-slate-400">{{ __('messages.manage_content') }}</p>
            </div>
            <a href="{{ route('categories.create') }}" class="inline-flex items-center justify-center rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-emerald-400">{{ __('messages.add_new') }}</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="text-slate-400">
                    <tr>
                        <th class="px-4 py-3">{{ __('messages.name') }}</th>
                        <th class="px-4 py-3">{{ __('messages.description') }}</th>
                        <th class="px-4 py-3">{{ __('messages.players') }}</th>
                        <th class="px-4 py-3">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="border-t border-white/10 text-slate-200">
                            <td class="px-4 py-3 font-medium text-white">{{ $category->localized_name ?? $category->name }}</td>
                            <td class="px-4 py-3 text-slate-400">{{ Str::limit($category->localized_description ?? $category->description, 80) }}</td>
                            <td class="px-4 py-3">{{ $category->players_count }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('categories.edit', $category) }}" class="rounded-lg border border-sky-500/40 bg-sky-500/10 px-3 py-1.5 text-xs font-semibold text-sky-200">{{ __('messages.edit') }}</a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('{{ __('messages.delete') }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-red-500/40 bg-red-500/10 px-3 py-1.5 text-xs font-semibold text-red-200">{{ __('messages.delete') }}</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-slate-400">{{ __('messages.no_records') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-5">
            {{ $categories->links() }}
        </div>
    </div>
@endsection
