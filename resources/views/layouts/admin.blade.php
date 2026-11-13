<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 antialiased">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(59,130,246,0.16),_transparent_25%),radial-gradient(circle_at_bottom_right,_rgba(34,197,94,0.12),_transparent_25%),#020817]">
        <div class="mx-auto flex max-w-[1600px] gap-6 p-4 lg:p-6">
            <aside class="hidden w-72 shrink-0 rounded-3xl border border-white/10 bg-slate-900/75 p-5 shadow-2xl backdrop-blur-xl lg:flex lg:flex-col">
                <div class="mb-8 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-400/15 text-xl text-emerald-300">⚽</div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-400">CONTROLLER</p>
                        <h1 class="text-lg font-semibold text-white">Football CRM</h1>
                    </div>
                </div>

                <nav class="space-y-2">
                    @php
                        $navItems = [
                            ['route' => route('dashboard'), 'label' => __('messages.dashboard'), 'icon' => '⌂'],
                            ['route' => route('categories.index'), 'label' => __('messages.categories'), 'icon' => '▣'],
                            ['route' => route('players.index'), 'label' => __('messages.players'), 'icon' => '◉'],
                            ['route' => route('facts.index'), 'label' => __('messages.player_facts'), 'icon' => '✦'],
                            ['route' => route('home'), 'label' => __('messages.home'), 'icon' => '↗'],
                        ];
                    @endphp
                    @foreach($navItems as $item)
                        <a href="{{ $item['route'] }}" class="flex items-center gap-3 rounded-2xl border px-3 py-2.5 text-sm font-medium transition {{ request()->fullUrlIs($item['route'].'*') || request()->routeIs(str_replace(['route(', ')'], '', $item['route'])) ? 'border-emerald-400/40 bg-emerald-500/10 text-emerald-200' : 'border-transparent bg-slate-900/60 text-slate-300 hover:border-slate-700 hover:bg-slate-800/80' }}">
                            <span>{{ $item['icon'] }}</span>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </nav>

                <div class="mt-auto rounded-2xl border border-emerald-400/20 bg-emerald-500/10 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-emerald-200/80">{{ __('messages.language') }}</p>
                    <div class="mt-3 flex gap-2 text-xs">
                        @foreach(['en' => '🇬🇧 EN', 'tr' => '🇹🇷 TR', 'ru' => '🇷🇺 RU'] as $code => $flag)
                            <a href="{{ route('language.switch', ['locale' => $code, 'redirect' => url()->current()]) }}" class="rounded-full border px-2 py-1 {{ app()->getLocale() === $code ? 'border-emerald-300 bg-emerald-400/10 text-emerald-100' : 'border-slate-700 text-slate-300' }}">{{ $flag }}</a>
                        @endforeach
                    </div>
                </div>
            </aside>

            <div class="flex-1">
                <header class="mb-6 rounded-3xl border border-white/10 bg-slate-900/75 px-4 py-4 shadow-2xl backdrop-blur-xl sm:px-6">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.22em] text-slate-400">{{ __('messages.dashboard') }}</p>
                            <h2 class="mt-1 text-2xl font-semibold text-white">@yield('page-title', __('messages.dashboard'))</h2>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="hidden items-center gap-2 rounded-full border border-slate-700 bg-slate-800/80 px-3 py-2 md:flex">
                                @foreach(['en' => '🇬🇧', 'tr' => '🇹🇷', 'ru' => '🇷🇺'] as $code => $flag)
                                    <a href="{{ route('language.switch', ['locale' => $code, 'redirect' => url()->current()]) }}" class="rounded-full px-2 py-1 text-xs font-semibold {{ app()->getLocale() === $code ? 'bg-emerald-500/15 text-emerald-200' : 'text-slate-400 hover:text-white' }}">{{ $flag }}</a>
                                @endforeach
                            </div>

                            <div class="flex items-center gap-3 rounded-full border border-slate-700 bg-slate-800/80 px-3 py-2">
                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-500/15 text-sm font-semibold text-emerald-200">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                </div>
                                <div class="hidden sm:block">
                                    <p class="text-sm font-medium text-white">{{ Auth::user()->name ?? 'Admin' }}</p>
                                    <p class="text-[11px] text-slate-400">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <main>
                    @if (session('success'))
                        <div class="mb-6 rounded-2xl border border-emerald-400/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-100">
                            {{ session('success') }}
                        </div>
                    @endif
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>
</html>
