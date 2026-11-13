@extends('layouts.admin')

@section('title', __('messages.players'))
@section('page-title', __('messages.players'))

@section('content')
    <div class="rounded-3xl border border-white/10 bg-slate-900/65 p-5 shadow-xl backdrop-blur-xl">
        <div class="mb-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h3 class="text-xl font-semibold text-white">{{ __('messages.players') }}</h3>
                <p class="text-sm text-slate-400">{{ __('messages.manage_content') }}</p>
            </div>
            <a href="{{ route('players.create') }}" class="inline-flex items-center justify-center rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-emerald-400">{{ __('messages.add_new') }}</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="text-slate-400">
                    <tr>
                        <th class="px-4 py-3">{{ __('messages.name') }}</th>
                        <th class="px-4 py-3">{{ __('messages.team') }}</th>
                        <th class="px-4 py-3">{{ __('messages.position') }}</th>
                        <th class="px-4 py-3">{{ __('messages.category') }}</th>
                        <th class="px-4 py-3">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($players as $player)
                        <tr class="border-t border-white/10 text-slate-200">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if ($player->image)
                                        <img src="{{ asset('storage/'.$player->image) }}" alt="{{ $player->name }}" class="h-12 w-12 rounded-full object-cover">
                                    @else
                                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-700 text-sm font-bold text-white">{{ strtoupper(substr($player->name, 0, 1)) }}</div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-white">{{ $player->localized_name ?? $player->name }}</p>
                                        <p class="text-xs text-slate-400">#{{ $player->jersey_number ?? '—' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">{{ $player->localized_team ?? $player->team }}</td>
                            <td class="px-4 py-3">{{ $player->localized_position ?? $player->position }}</td>
                            <td class="px-4 py-3">{{ $player->category?->localized_name ?? $player->category?->name ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('players.edit', $player) }}" class="rounded-lg border border-sky-500/40 bg-sky-500/10 px-3 py-1.5 text-xs font-semibold text-sky-200">{{ __('messages.edit') }}</a>
                                    <form action="{{ route('players.destroy', $player) }}" method="POST" onsubmit="return confirm('{{ __('messages.delete') }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-red-500/40 bg-red-500/10 px-3 py-1.5 text-xs font-semibold text-red-200">{{ __('messages.delete') }}</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-400">{{ __('messages.no_records') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-5">
            {{ $players->links() }}
        </div>
    </div>
@endsection
