@extends('layouts.app')

@section('content')

<header class="relative bg-primary overflow-hidden">
    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1600&q=80" alt="" class="absolute inset-0 w-full h-full object-cover opacity-25">
    <div class="absolute inset-0 bg-gradient-to-b from-primary/70 to-primary"></div>

    <div class="relative max-w-7xl mx-auto px-5 lg:px-8 pt-32 pb-12">
        <p class="text-accent font-bold text-sm tracking-wide">— Explore</p>
        <h1 class="text-white font-extrabold text-3xl md:text-5xl leading-tight mt-1">Temukan Destinasi Impianmu</h1>
        <p class="text-white/75 mt-3 max-w-xl text-sm md:text-base">Cari, filter, dan bandingkan {{ count($destinasi) }} destinasi dari berbagai provinsi di Indonesia.</p>

        <form id="form-explore" class="bg-white rounded-full p-2 mt-7 max-w-2xl flex items-center gap-2 shadow-2xl">
            <svg class="ml-4 text-slate-400 shrink-0" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
            <input id="explore-cari" type="text" placeholder="Cari nama destinasi atau kota..." class="flex-1 min-w-0 px-2 py-2.5 outline-none text-sm">
            <button class="bg-primary text-white font-bold text-sm px-6 py-2.5 rounded-full hover:bg-secondary transition">Cari</button>
        </form>
    </div>
</header>

<section class="max-w-7xl mx-auto px-5 lg:px-8 mt-8">
    <div id="kategori-chips" class="flex gap-2 overflow-x-auto pb-2 -mx-5 px-5 lg:mx-0 lg:px-0">
        <button type="button" data-kategori="" class="chip-kategori aktif shrink-0 text-sm font-bold px-5 py-2.5 rounded-full border transition">
            Semua <span class="opacity-60 font-semibold">{{ count($destinasi) }}</span>
        </button>
        @foreach ($kategori as $k)
        <button type="button" data-kategori="{{ $k }}" class="chip-kategori shrink-0 text-sm font-bold px-5 py-2.5 rounded-full border transition">
            {{ $k }} <span class="opacity-60 font-semibold">{{ count(array_filter($destinasi, fn ($d) => $d['kategori'] == $k)) }}</span>
        </button>
        @endforeach
    </div>
</section>

<section id="hasil" class="max-w-7xl mx-auto px-5 lg:px-8 mt-6 scroll-mt-24">
    <div class="flex flex-col lg:flex-row gap-8">

        <aside id="panel-filter" class="hidden lg:block lg:w-64 shrink-0">
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm lg:sticky lg:top-24">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="font-extrabold text-lg">Filter</h2>
                    <button type="button" id="btn-reset" class="text-xs font-bold text-accent hover:text-amber-600">Reset</button>
                </div>

                <label for="filter-provinsi" class="block text-sm font-bold mb-2">Provinsi</label>
                <select id="filter-provinsi" class="w-full px-4 py-2.5 rounded-xl outline-none text-sm text-slate-600 bg-cream border border-amber-100">
                    <option value="">Semua Provinsi</option>
                    @foreach ($provinsi as $p)
                    <option>{{ $p }}</option>
                    @endforeach
                </select>

                <p class="text-sm font-bold mt-6 mb-3">Budget Tiket</p>
                <div class="space-y-2.5 text-sm">
                    <label class="flex items-center gap-3 cursor-pointer"><input type="radio" name="budget" value="" class="accent-[#1B4332] w-4 h-4" checked> Semua harga</label>
                    <label class="flex items-center gap-3 cursor-pointer"><input type="radio" name="budget" value="0-0" class="accent-[#1B4332] w-4 h-4"> Gratis</label>
                    <label class="flex items-center gap-3 cursor-pointer"><input type="radio" name="budget" value="1-25000" class="accent-[#1B4332] w-4 h-4"> Sampai Rp 25rb</label>
                    <label class="flex items-center gap-3 cursor-pointer"><input type="radio" name="budget" value="25001-75000" class="accent-[#1B4332] w-4 h-4"> Rp 25rb – 75rb</label>
                    <label class="flex items-center gap-3 cursor-pointer"><input type="radio" name="budget" value="75001-" class="accent-[#1B4332] w-4 h-4"> Di atas Rp 75rb</label>
                </div>

                <button type="button" id="btn-tutup-filter" class="lg:hidden w-full mt-6 bg-primary text-white font-bold text-sm py-3 rounded-full">Lihat Hasil</button>
            </div>
        </aside>

        <div class="flex-1 min-w-0">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                <p id="info-hasil" class="text-sm text-slate-500"></p>
                <div class="flex items-center gap-2">
                    <button type="button" id="btn-filter" class="lg:hidden inline-flex items-center gap-2 text-sm font-bold bg-white border border-slate-200 px-4 py-2.5 rounded-full">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 6h16M7 12h10M10 18h4"/></svg>
                        Filter
                    </button>
                    <select id="sort" class="text-sm font-semibold bg-white border border-slate-200 px-4 py-2.5 rounded-full outline-none">
                        <option value="rekomendasi">Rekomendasi</option>
                        <option value="rating">Rating tertinggi</option>
                        <option value="termurah">Harga termurah</option>
                        <option value="termahal">Harga termahal</option>
                        <option value="nama">Nama A–Z</option>
                    </select>
                </div>
            </div>

            <div id="explore-grid" class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach ($destinasi as $i => $d)
                <div class="explore-item"
                    data-urutan="{{ $i }}"
                    data-nama="{{ $d['nama'] }}"
                    data-lokasi="{{ $d['lokasi'] }}"
                    data-kategori="{{ $d['kategori'] }}"
                    data-provinsi="{{ $d['provinsi'] }}"
                    data-tiket="{{ $d['tiket'] }}"
                    data-rating="{{ $d['rating'] }}">
                    @include('components.destination-card', $d)
                </div>
                @endforeach
            </div>

            <div id="explore-kosong" class="hidden bg-white rounded-3xl border border-slate-100 p-12 text-center">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-cream text-primary flex items-center justify-center mb-4">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5M8.5 11h5"/></svg>
                </div>
                <h3 class="font-extrabold text-lg">Destinasi nggak ketemu</h3>
                <p class="text-sm text-slate-500 mt-1 mb-5">Coba kata kunci lain atau longgarkan filternya.</p>
                <button type="button" id="btn-reset-kosong" class="bg-primary text-white font-bold text-sm px-6 py-2.5 rounded-full hover:bg-secondary transition">Reset Filter</button>
            </div>

            <nav id="pagination" class="flex flex-wrap justify-center gap-2 mt-10" aria-label="Halaman"></nav>
        </div>
    </div>
</section>

<script src="{{ asset('js/explore.js') }}"></script>

@endsection
