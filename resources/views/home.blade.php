@extends('layouts.app')

@section('content')

<header class="relative min-h-[88vh] flex items-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1600&q=80')">
    <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/45 to-black/60"></div>

    <div class="relative max-w-7xl mx-auto px-5 lg:px-8 pt-32 pb-16 w-full text-center">
        <span class="inline-flex items-center gap-2 bg-white/15 backdrop-blur text-white text-xs md:text-sm font-semibold px-4 py-2 rounded-full border border-white/25 mb-5">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M16 8l-2.5 5.5L8 16l2.5-5.5z"/></svg>
            Smart Travel Planner Indonesia
        </span>
        <h1 class="text-white font-extrabold text-4xl md:text-6xl leading-tight max-w-3xl mx-auto">Jelajahi Indonesia,<br>Rencanakan <span class="text-accent">Perjalananmu.</span></h1>
        <p class="text-white/80 mt-4 max-w-xl mx-auto">Cari destinasi, susun itinerary harian, dan hitung budget liburanmu dalam satu tempat.</p>

        <form id="form-search" class="bg-white rounded-3xl md:rounded-full p-3 mt-8 max-w-3xl mx-auto flex flex-col md:flex-row gap-3 shadow-2xl text-left">
            <input id="input-cari" type="text" placeholder="Mau ke mana? cth: Bali, Bromo..." class="flex-1 px-5 py-3 rounded-full outline-none text-sm">
            <select id="input-provinsi" class="px-5 py-3 rounded-full outline-none text-sm text-slate-600 bg-cream md:w-48">
                <option value="">Semua Provinsi</option>
                <option>Bali</option>
                <option>Jawa Timur</option>
                <option>Jawa Tengah</option>
                <option>NTT</option>
                <option>Papua Barat</option>
            </select>
            <button class="bg-primary text-white font-bold text-sm px-8 py-3 rounded-full hover:bg-secondary transition">Cari</button>
        </form>
        <p id="search-info" class="text-accent text-sm font-semibold mt-3 h-5"></p>

        <div class="flex justify-center gap-8 mt-6 text-white">
            <div><p class="font-extrabold text-2xl">500+</p><p class="text-xs text-white/70">Destinasi</p></div>
            <div><p class="font-extrabold text-2xl">34</p><p class="text-xs text-white/70">Provinsi</p></div>
            <div><p class="font-extrabold text-2xl">4.9</p><p class="text-xs text-white/70">Rating</p></div>
        </div>
    </div>
</header>

<section id="kategori" class="max-w-7xl mx-auto px-5 lg:px-8 mt-12 scroll-mt-24">
    <div class="flex items-end justify-between mb-6">
        <div>
            <h2 class="text-2xl md:text-3xl font-extrabold">Mau liburan apa?</h2>
            <p class="text-slate-500 text-sm mt-1">Pilih kategori sesuai mood perjalananmu.</p>
        </div>
    </div>
    <div class="grid grid-cols-3 md:grid-cols-6 gap-4">
        @foreach ($kategori as $k)
        <a href="#populer" class="bg-white rounded-2xl p-5 text-center shadow-sm hover:shadow-lg hover:-translate-y-1 transition border border-slate-100">
            <div class="w-12 h-12 mx-auto rounded-xl bg-cream flex items-center justify-center text-primary mb-2">
                @if ($k['icon'] == 'pantai')
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M2 9c2-2 4-2 6 0s4 2 6 0 4-2 6 0"/><path d="M2 14c2-2 4-2 6 0s4 2 6 0 4-2 6 0"/><path d="M2 19c2-2 4-2 6 0s4 2 6 0 4-2 6 0"/></svg>
                @elseif ($k['icon'] == 'gunung')
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 20L10 5l4 7 2.5-3.5L21 20z"/><circle cx="17.5" cy="5.5" r="1.8"/></svg>
                @elseif ($k['icon'] == 'budaya')
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-5.5L21 9"/><path d="M4 9.5V19M20 9.5V19M8 12.5v4M12 12.5v4M16 12.5v4M2.5 19.5h19"/></svg>
                @elseif ($k['icon'] == 'kuliner')
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M6 3v7M3.5 3v3.5a2.5 2.5 0 005 0V3M6 10v11"/><path d="M17 3c-1.8 1-2.8 3.6-2.8 6.5V13h2.8v8M17 3v10"/></svg>
                @elseif ($k['icon'] == 'danau')
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><path d="M12 3.5s5.5 5.8 5.5 10a5.5 5.5 0 01-11 0c0-4.2 5.5-10 5.5-10z"/></svg>
                @else
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><rect x="5" y="3.5" width="14" height="17"/><path d="M9 7.5h2M13 7.5h2M9 11h2M13 11h2M9 14.5h2M13 14.5h2M10 20.5v-2.5h4v2.5"/></svg>
                @endif
            </div>
            <p class="font-bold text-sm">{{ $k['nama'] }}</p>
            <p class="text-xs text-slate-400">{{ $k['jumlah'] }}</p>
        </a>
        @endforeach
    </div>
</section>

<section id="populer" class="max-w-7xl mx-auto px-5 lg:px-8 mt-16">
    <div class="flex items-end justify-between mb-6">
        <div>
            <p class="text-accent font-bold text-sm tracking-wide">— Paling ramai</p>
            <h2 class="text-2xl md:text-3xl font-extrabold">Destinasi Populer</h2>
        </div>
        <a href="#" class="text-sm font-bold text-primary">Lihat Semua →</a>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ($populer as $d)
            @include('components.destination-card', $d)
        @endforeach
    </div>
</section>

<section id="rekomendasi" class="bg-primary mt-16 py-14">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <p class="text-accent font-bold text-sm tracking-wide">— Pilihan editor</p>
        <h2 class="text-2xl md:text-3xl font-extrabold text-white mb-8">Rekomendasi Buat Kamu</h2>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($rekomendasi as $r)
            <div class="relative rounded-3xl overflow-hidden h-[380px] group">
                <img src="{{ $r['gambar'] }}" alt="{{ $r['nama'] }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition duration-500" loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute bottom-0 p-6 text-white">
                    <span class="inline-flex items-center gap-1 bg-accent text-xs font-bold px-3 py-1 rounded-full">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.5l2.9 6.6 7.1.6-5.4 4.7 1.6 7-6.2-3.7-6.2 3.7 1.6-7L2 9.7l7.1-.6z"/></svg>
                        {{ $r['rating'] }}
                    </span>
                    <h3 class="font-extrabold text-xl mt-2">{{ $r['nama'] }}</h3>
                    <p class="text-xs text-white/70">{{ $r['lokasi'] }} • {{ $r['harga'] }}</p>
                    <p class="text-sm text-white/80 mt-2">{{ $r['deskripsi'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-5 lg:px-8 mt-16 text-center">
    <h2 class="text-2xl md:text-3xl font-extrabold">Liburan Anti Ribet</h2>
    <p class="text-slate-500 text-sm mt-1 mb-8">Ikuti 3 langkah gampang ini.</p>
    <div class="grid md:grid-cols-3 gap-6 text-left">
        <div class="bg-white rounded-3xl p-7 border border-slate-100 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-primary text-white font-extrabold flex items-center justify-center text-lg mb-4">1</div>
            <h3 class="font-bold text-lg mb-1">Explore Destinasi</h3>
            <p class="text-sm text-slate-500">Cari dan filter 500+ destinasi di seluruh Indonesia.</p>
        </div>
        <div class="bg-white rounded-3xl p-7 border border-slate-100 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-accent text-white font-extrabold flex items-center justify-center text-lg mb-4">2</div>
            <h3 class="font-bold text-lg mb-1">Susun Itinerary</h3>
            <p class="text-sm text-slate-500">Atur jadwal Day 1, Day 2, aktivitas dan catatan perjalanan.</p>
        </div>
        <div class="bg-white rounded-3xl p-7 border border-slate-100 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-secondary text-white font-extrabold flex items-center justify-center text-lg mb-4">3</div>
            <h3 class="font-bold text-lg mb-1">Atur Budget</h3>
            <p class="text-sm text-slate-500">Hitung transport, hotel, makan dan tiket otomatis.</p>
        </div>
    </div>

    <div class="mt-10 bg-gradient-to-r from-primary to-secondary rounded-3xl p-10 text-white">
        <h3 class="font-extrabold text-2xl md:text-3xl">Siap liburan tanpa drama?</h3>
        <p class="text-white/70 text-sm mt-2 mb-6">Yuk mulai rencanakan perjalanan pertamamu sekarang.</p>
        <a href="#populer" class="inline-block bg-accent font-bold text-sm px-8 py-3 rounded-full hover:bg-amber-600 transition">Jelajahi Sekarang</a>
    </div>
</section>

@endsection
