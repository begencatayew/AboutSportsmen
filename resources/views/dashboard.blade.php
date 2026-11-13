@extends('layouts.admin')

@section('title', __('messages.dashboard'))
@section('page-title', __('messages.dashboard'))

@section('content')
    <div class="grid gap-5 md:grid-cols-3">
        <div class="rounded-3xl border border-white/10 bg-slate-900/70 p-5 shadow-xl backdrop-blur-xl">
            <p class="text-sm text-slate-400">{{ __('messages.players') }}</p>
            <h3 class="mt-3 text-3xl font-semibold text-white">{{ $stats['players'] ?? 0 }}</h3>
        </div>

        <div class="rounded-3xl border border-white/10 bg-slate-900/70 p-5 shadow-xl backdrop-blur-xl">
            <p class="text-sm text-slate-400">{{ __('messages.categories') }}</p>
            <h3 class="mt-3 text-3xl font-semibold text-white">{{ $stats['categories'] ?? 0 }}</h3>
        </div>

        <div class="rounded-3xl border border-white/10 bg-slate-900/70 p-5 shadow-xl backdrop-blur-xl">
            <p class="text-sm text-slate-400">{{ __('messages.player_facts') }}</p>
            <h3 class="mt-3 text-3xl font-semibold text-white">{{ $stats['facts'] ?? 0 }}</h3>
        </div>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[1.5fr_1fr]">
        <div class="rounded-3xl border border-white/10 bg-slate-900/70 p-5 shadow-xl backdrop-blur-xl">
            <div class="mb-5 flex items-center justify-between">
                <h3 class="text-xl font-semibold text-white">{{ __('messages.quick_access') }}</h3>
            </div>

            <div class="grid gap-3 sm:grid-cols-3">
                <a href="{{ route('categories.index') }}" class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-left transition hover:border-emerald-400/60 hover:bg-emerald-500/15">
                    <div class="text-2xl">▣</div>
                    <p class="mt-3 text-sm text-emerald-100 font-semibold">{{ __('messages.categories') }}</p>
                </a>

                <a href="{{ route('players.index') }}" class="rounded-2xl border border-sky-500/30 bg-sky-500/10 p-4 text-left transition hover:border-sky-400/60 hover:bg-sky-500/15">
                    <div class="text-2xl">◉</div>
                    <p class="mt-3 text-sm text-sky-100 font-semibold">{{ __('messages.players') }}</p>
                </a>

                <a href="{{ route('facts.index') }}" class="rounded-2xl border border-violet-500/30 bg-violet-500/10 p-4 text-left transition hover:border-violet-400/60 hover:bg-violet-500/15">
                    <div class="text-2xl">✦</div>
                    <p class="mt-3 text-sm text-violet-100 font-semibold">{{ __('messages.player_facts') }}</p>
                </a>
            </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-slate-900/70 p-5 shadow-xl backdrop-blur-xl">
            <h3 class="text-xl font-semibold text-white">{{ __('messages.recent_players') }}</h3>
            <div class="mt-4 space-y-3">
                @forelse ($recentPlayers as $player)
                    <div class="flex items-center justify-between rounded-2xl border border-white/10 bg-slate-950/50 p-3">
                        <div>
                            <p class="font-medium text-white">{{ $player->localized_name ?? $player->name }}</p>
                            <p class="text-xs text-slate-400">{{ $player->category?->localized_name ?? $player->category?->name ?? '—' }}</p>
                        </div>
                        <span class="text-xs text-slate-300">#{{ $player->jersey_number ?? '—' }}</span>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">{{ __('messages.no_records') }}</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
