
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">

    <div class="max-w-7xl mx-auto px-5 lg:px-8">

        <div class="flex items-center justify-between h-[72px] gap-4">

            <!-- LOGO -->
            <a href="{{ route('home') }}"
               class="flex items-center gap-2 shrink-0">

                <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white font-extrabold text-xl">
                    J
                </div>

                <span class="text-xl font-extrabold text-white nav-text">
                    Jelajah<span class="text-accent">.in</span>
                </span>

            </a>

            <!-- MENU DESKTOP -->
            <div class="hidden xl:flex items-center gap-5 text-sm font-semibold text-white/90 nav-text">

                <a href="{{ route('home') }}"
                   class="hover:text-accent transition {{ request()->routeIs('home') ? 'text-accent' : '' }}">
                    Home
                </a>

                <a href="{{ route('explore') }}"
                   class="hover:text-accent transition {{ request()->routeIs('explore') ? 'text-accent' : '' }}">
                    Explore
                </a>

                <a href="{{ route('home') }}#kategori"
                   class="hover:text-accent transition">
                    Kategori
                </a>

                <a href="{{ route('home') }}#rekomendasi"
                   class="hover:text-accent transition">
                    Rekomendasi
                </a>

                <!-- MENU FAVORITE - HAKIM -->
                <a href="{{ route('favorites.index') }}"
                   class="inline-flex items-center gap-1.5 hover:text-accent transition {{ request()->routeIs('favorites.*') ? 'text-accent' : '' }}">

                    <svg width="17"
                         height="17"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round">

                        <path d="M12 20.5s-7-4.3-9-8.7c-1.2-2.6.4-5.8 3.3-5.8 1.9 0 3.4 1.4 5.7 3.9 2.3-2.5 3.8-3.9 5.7-3.9 2.9 0 4.5 3.2 3.3 5.8-2 4.4-9 8.7-9 8.7z"/>

                    </svg>

                    Favorite

                </a>

                <a href="{{ route('dashboard') }}"
                   class="hover:text-accent transition {{ request()->routeIs('dashboard') ? 'text-accent' : '' }}">
                    Dashboard
                </a>

                <a href="{{ route('itinerary') }}"
                   class="hover:text-accent transition {{ request()->routeIs('itinerary') ? 'text-accent' : '' }}">
                    Itinerary
                </a>

            </div>

            <!-- TOMBOL DESKTOP -->
            <div class="hidden xl:flex items-center gap-3 shrink-0">

                <a href="#"
                   class="text-sm font-bold text-white nav-text">
                    Masuk
                </a>

                <a href="{{ route('explore') }}"
                   class="text-sm font-bold bg-accent text-white px-5 py-2.5 rounded-full hover:bg-amber-600 transition">
                    Mulai Jelajah
                </a>

            </div>

            <!-- TOMBOL MENU MOBILE -->
            <button id="btn-menu"
                    type="button"
                    class="xl:hidden text-white nav-text p-2"
                    aria-label="Buka menu navigasi"
                    aria-controls="mobile-menu"
                    aria-expanded="false">

                <svg width="28"
                     height="28"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          d="M4 7h16M4 12h16M4 17h16"/>

                </svg>

            </button>

        </div>

    </div>

    <!-- MENU MOBILE -->
    <div id="mobile-menu"
         class="hidden xl:hidden bg-white mx-4 rounded-2xl shadow-xl p-5 space-y-3 font-semibold">

        <!-- HOME -->
        <a href="{{ route('home') }}"
           class="block text-primary hover:text-secondary transition">
            Home
        </a>

        <!-- EXPLORE -->
        <a href="{{ route('explore') }}"
           class="block hover:text-secondary transition">
            Explore
        </a>

        <!-- KATEGORI -->
        <a href="{{ route('home') }}#kategori"
           class="block hover:text-secondary transition">
            Kategori
        </a>

        <!-- REKOMENDASI -->
        <a href="{{ route('home') }}#rekomendasi"
           class="block hover:text-secondary transition">
            Rekomendasi
        </a>

        <!-- FAVORITE MOBILE -->
        <a href="{{ route('favorites.index') }}"
           class="flex items-center gap-2 hover:text-secondary transition">

            <svg width="19"
                 height="19"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round">

                <path d="M12 20.5s-7-4.3-9-8.7c-1.2-2.6.4-5.8 3.3-5.8 1.9 0 3.4 1.4 5.7 3.9 2.3-2.5 3.8-3.9 5.7-3.9 2.9 0 4.5 3.2 3.3 5.8-2 4.4-9 8.7-9 8.7z"/>

            </svg>

            Favorite

        </a>

        <!-- DASHBOARD -->
        <a href="{{ route('dashboard') }}"
           class="block hover:text-secondary transition">
            Dashboard
        </a>

        <!-- ITINERARY -->
        <a href="{{ route('itinerary') }}"
           class="block hover:text-secondary transition">
            Itinerary
        </a>

        <!-- MULAI JELAJAH -->
        <a href="{{ route('explore') }}"
           class="block bg-accent text-white text-center py-2.5 rounded-full hover:bg-amber-600 transition">
            Mulai Jelajah
        </a>

    </div>

</nav>


{{-- NAVBAR UNTUK HALAMAN SELAIN HOME --}}
@if (!request()->routeIs('home'))

<style>
    /* Background navbar langsung putih */
    #navbar {
        background-color: rgba(255, 255, 255, 0.98) !important;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06) !important;
        backdrop-filter: blur(12px);
    }

    /* Tulisan navbar menjadi hijau tua */
    #navbar .nav-text,
    #navbar .nav-text > a {
        color: #1B4332 !important;
    }

    /* Menu yang aktif dan saat hover */
    #navbar .nav-text > a.text-accent,
    #navbar .nav-text > a:hover,
    #navbar .nav-text .text-accent {
        color: #F59E0B !important;
    }

    /* Ikon menu hamburger */
    #navbar #btn-menu {
        color: #1B4332 !important;
    }
</style>

@endif