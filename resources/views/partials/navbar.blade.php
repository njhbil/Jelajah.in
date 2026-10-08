<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <div class="flex items-center justify-between h-[72px]">
            <a href="/" class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white font-extrabold text-xl">J</div>
                <span class="text-xl font-extrabold text-white nav-text">Jelajah<span class="text-accent">.in</span></span>
            </a>

            <div class="hidden md:flex items-center gap-8 text-[15px] font-semibold text-white/90 nav-text">
                <a href="/" class="text-accent">Home</a>
                <a href="#populer" class="hover:text-accent transition">Explore</a>
                <a href="#kategori" class="hover:text-accent transition">Kategori</a>
                <a href="#rekomendasi" class="hover:text-accent transition">Rekomendasi</a>
                <a href="#" class="hover:text-accent transition">Itinerary</a>
            </div>

            <div class="hidden md:flex items-center gap-3">
                <a href="#" class="text-sm font-bold text-white nav-text">Masuk</a>
                <a href="#populer" class="text-sm font-bold bg-accent text-white px-5 py-2.5 rounded-full hover:bg-amber-600 transition">Mulai Jelajah</a>
            </div>

            <button id="btn-menu" class="md:hidden text-white nav-text p-2">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-white mx-4 rounded-2xl shadow-xl p-5 space-y-3 font-semibold">
        <a href="/" class="block text-primary">Home</a>
        <a href="#populer" class="block">Explore</a>
        <a href="#kategori" class="block">Kategori</a>
        <a href="#rekomendasi" class="block">Rekomendasi</a>
        <a href="#populer" class="block bg-accent text-white text-center py-2.5 rounded-full">Mulai Jelajah</a>
    </div>
</nav>
