<div class="m-0 flex flex-wrap items-center justify-between gap-3 bg-[#0f172a]/80 px-4 py-3 shadow-[0_10px_30px_rgba(15,23,42,0.35)] backdrop-blur-sm sm:px-6">
    <div class="ml-0 text-2xl font-semibold text-lime-400 sm:ml-4">
        <i>Sportsmens</i>
    </div>

    <div class="flex flex-wrap items-center justify-end gap-3 py-2 sm:gap-8 sm:py-3">
        <div class="text-base font-semibold sm:text-xl">
            <a href="{{ route('home') }}" class="text-lime-400 hover:text-slate-100 transition-colors duration-400">Home</a>
        </div>

        <div class="text-base font-semibold sm:text-xl">
            <a href="{{ route('sportsmens') }}" class="text-lime-400 hover:text-slate-100 transition-colors duration-400">Sportsmens</a>
        </div>

        <div class="text-base font-semibold sm:text-xl">
            <a href="{{ route('contact') }}" class="text-lime-400 hover:text-slate-100 transition-colors duration-400">Contact Us</a>
        </div>

        @auth
            <div class="text-base font-semibold sm:text-xl">
                <a href="{{ route('dashboard') }}" class="text-lime-400 hover:text-slate-100 transition-colors duration-400">Dashboard</a>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-full border border-lime-400/40 bg-lime-400/10 px-4 py-2 text-sm font-semibold text-lime-300 transition hover:bg-lime-400/20">Logout</button>
            </form>
        @else
            <div class="text-base font-semibold sm:text-xl">
                <a href="{{ route('login') }}" class="text-lime-400 hover:text-slate-100 transition-colors duration-400">Login</a>
            </div>

            <div class="text-base font-semibold sm:text-xl">
                <a href="{{ route('register') }}" class="rounded-full border border-lime-400/40 bg-lime-400/10 px-4 py-2 text-lime-300 transition hover:bg-lime-400/20">Register</a>
            </div>
        @endauth
    </div>
</div>
