@extends('layouts.app')

@section('content')

{{-- data dummy dari controller, dipakai JS sebagai fallback bila localStorage kosong --}}
<script type="application/json" id="dummy-data">{!! json_encode(['trip' => $trip, 'budget' => $budget], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>

<header class="bg-primary pt-32 pb-12">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <p class="text-accent font-bold text-sm tracking-wide">— Dashboard</p>
        <h1 class="text-white font-extrabold text-3xl md:text-5xl mt-1">Dashboard & Budget</h1>
        <p class="text-white/75 mt-3 max-w-xl text-sm md:text-base">Pantau ringkasan perjalanan dan hitung budget liburanmu dalam satu tempat.</p>
    </div>
</header>

{{-- ============ Ringkasan Perjalanan ============ --}}
<section class="max-w-7xl mx-auto px-5 lg:px-8 mt-10">
    <div class="flex items-end justify-between mb-6">
        <div>
            <p class="text-accent font-bold text-sm tracking-wide">— Perjalananmu</p>
            <h2 class="text-2xl md:text-3xl font-extrabold">Ringkasan Perjalanan</h2>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Nama Trip</p>
            <p id="trip-nama" class="font-extrabold text-lg mt-1 text-primary">{{ $trip['nama'] }}</p>
        </div>
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Tanggal</p>
            <p id="trip-tanggal" class="font-extrabold text-lg mt-1">{{ \Carbon\Carbon::parse($trip['tanggal_mulai'])->format('d M Y') }}</p>
        </div>
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Durasi</p>
            <p id="trip-durasi" class="font-extrabold text-lg mt-1">{{ $trip['jumlah_hari'] }} hari {{ $trip['jumlah_hari'] - 1 }} malam</p>
        </div>
        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Penumpang</p>
            <p id="trip-penumpang" class="font-extrabold text-lg mt-1">{{ $trip['penumpang'] }} orang</p>
        </div>
    </div>

    <div class="mt-6">
        <h3 class="font-bold mb-3">Destinasi dalam trip <span id="trip-jumlah-destinasi" class="text-slate-400 font-semibold text-sm">({{ count($trip['destinasi']) }})</span></h3>
        <div id="trip-destinasi" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($trip['destinasi'] as $d)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <img src="{{ $d['gambar'] }}" alt="{{ $d['nama'] }}" class="w-full h-32 object-cover" loading="lazy">
                <div class="p-4">
                    <div class="flex items-center justify-between gap-2">
                        <h4 class="font-bold text-sm">{{ $d['nama'] }}</h4>
                        <span class="text-[11px] font-bold bg-cream text-primary px-2.5 py-1 rounded-full shrink-0">{{ $d['kategori'] }}</span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">{{ $d['lokasi'] }}</p>
                    <p class="text-sm font-extrabold text-primary mt-2">{{ $d['tiket'] == 0 ? 'Gratis' : 'Rp ' . number_format($d['tiket'], 0, ',', '.') }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div id="trip-kosong" class="hidden bg-white rounded-3xl border border-slate-100 p-12 text-center">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-cream text-primary flex items-center justify-center mb-4">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h18v13H3zM8 7V4h8v3"/></svg>
            </div>
            <h3 class="font-extrabold text-lg">Belum ada destinasi</h3>
            <p class="text-sm text-slate-500 mt-1">Tambahkan destinasi lewat halaman Itinerary dulu ya.</p>
            <a href="/explore" class="inline-block mt-5 bg-primary text-white font-bold text-sm px-6 py-2.5 rounded-full hover:bg-secondary transition">Explore Destinasi</a>
        </div>
    </div>
</section>

{{-- ============ Budget Calculator ============ --}}
<section class="max-w-7xl mx-auto px-5 lg:px-8 mt-16">
    <div class="flex items-end justify-between mb-6">
        <div>
            <p class="text-accent font-bold text-sm tracking-wide">— Kalkulator</p>
            <h2 class="text-2xl md:text-3xl font-extrabold">Budget Calculator</h2>
        </div>
        <button type="button" id="btn-reset-budget" class="text-sm font-bold text-primary hover:text-secondary transition">Reset</button>
    </div>

    <div class="flex flex-col lg:flex-row gap-8 items-start">
        <div class="flex-1 w-full bg-white rounded-3xl p-6 md:p-8 border border-slate-100 shadow-sm">
            <form id="budget-form" class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label for="budget-transport" class="block text-sm font-bold mb-2">Transport</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">Rp</span>
                        <input id="budget-transport" data-kategori="transport" type="text" inputmode="numeric" value="{{ number_format($budget['transport'], 0, ',', '.') }}" placeholder="0" class="budget-input w-full pl-10 pr-4 py-3 rounded-xl bg-cream border border-amber-100 outline-none text-sm font-semibold text-right focus:border-primary">
                    </div>
                    <p class="text-xs text-slate-400 mt-1.5">Pesawat, kereta, sewa mobil, bensin...</p>
                </div>
                <div>
                    <label for="budget-hotel" class="block text-sm font-bold mb-2">Hotel</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">Rp</span>
                        <input id="budget-hotel" data-kategori="hotel" type="text" inputmode="numeric" value="{{ number_format($budget['hotel'], 0, ',', '.') }}" placeholder="0" class="budget-input w-full pl-10 pr-4 py-3 rounded-xl bg-cream border border-amber-100 outline-none text-sm font-semibold text-right focus:border-primary">
                    </div>
                    <p class="text-xs text-slate-400 mt-1.5">Total menginap selama trip</p>
                </div>
                <div>
                    <label for="budget-makanan" class="block text-sm font-bold mb-2">Makanan</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">Rp</span>
                        <input id="budget-makanan" data-kategori="makanan" type="text" inputmode="numeric" value="{{ number_format($budget['makanan'], 0, ',', '.') }}" placeholder="0" class="budget-input w-full pl-10 pr-4 py-3 rounded-xl bg-cream border border-amber-100 outline-none text-sm font-semibold text-right focus:border-primary">
                    </div>
                    <p class="text-xs text-slate-400 mt-1.5">Sarapan, makan siang, ngemil...</p>
                </div>
                <div>
                    <label for="budget-tiket" class="block text-sm font-bold mb-2">Tiket Masuk</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">Rp</span>
                        <input id="budget-tiket" data-kategori="tiket" type="text" inputmode="numeric" value="{{ number_format($budget['tiket'], 0, ',', '.') }}" placeholder="0" class="budget-input w-full pl-10 pr-4 py-3 rounded-xl bg-cream border border-amber-100 outline-none text-sm font-semibold text-right focus:border-primary">
                    </div>
                    <p class="text-xs text-slate-400 mt-1.5">Tiket masuk destinasi</p>
                </div>
                <div class="sm:col-span-2">
                    <label for="budget-aktivitas" class="block text-sm font-bold mb-2">Aktivitas & Lainnya</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">Rp</span>
                        <input id="budget-aktivitas" data-kategori="aktivitas" type="text" inputmode="numeric" value="{{ number_format($budget['aktivitas'], 0, ',', '.') }}" placeholder="0" class="budget-input w-full pl-10 pr-4 py-3 rounded-xl bg-cream border border-amber-100 outline-none text-sm font-semibold text-right focus:border-primary">
                    </div>
                    <p class="text-xs text-slate-400 mt-1.5">Snorkeling, oleh-oleh, tips...</p>
                </div>
            </form>
        </div>

        <div class="w-full lg:w-80 shrink-0 space-y-4 lg:sticky lg:top-24">
            <div class="bg-primary rounded-3xl p-6 text-white">
                <p class="text-white/70 text-sm font-bold">Total Budget</p>
                <p id="total-budget" class="font-extrabold text-3xl mt-1">Rp 0</p>
                <p class="text-white/60 text-xs mt-1">Akumulasi semua kategori</p>
            </div>
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
                <p class="text-slate-500 text-sm font-bold">Estimasi Budget per Hari</p>
                <p id="estimasi-hari" class="font-extrabold text-2xl text-primary mt-1">Rp 0</p>
                <p class="text-slate-400 text-xs mt-1">Dihitung dari total ÷ <span id="jumlah-hari">{{ $trip['jumlah_hari'] }}</span> hari trip</p>
            </div>
        </div>
    </div>
</section>

{{-- ============ Trip Summary ============ --}}
<section class="max-w-7xl mx-auto px-5 lg:px-8 mt-16">
    <div class="flex items-end justify-between mb-6">
        <div>
            <p class="text-accent font-bold text-sm tracking-wide">— Ringkasan akhir</p>
            <h2 class="text-2xl md:text-3xl font-extrabold">Trip Summary</h2>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-100 shadow-sm">
        <div id="summary-isi">
            <div class="mb-5">
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="font-semibold">Transport</span>
                    <span class="shrink-0 ml-4"><span data-sum="transport" class="font-bold">Rp 0</span> <span data-pct="transport" class="text-slate-400 text-xs inline-block w-12 text-right">0%</span></span>
                </div>
                <div class="bar-track"><div data-bar="transport" class="bar-fill" style="width: 0%"></div></div>
            </div>
            <div class="mb-5">
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="font-semibold">Hotel</span>
                    <span class="shrink-0 ml-4"><span data-sum="hotel" class="font-bold">Rp 0</span> <span data-pct="hotel" class="text-slate-400 text-xs inline-block w-12 text-right">0%</span></span>
                </div>
                <div class="bar-track"><div data-bar="hotel" class="bar-fill" style="width: 0%"></div></div>
            </div>
            <div class="mb-5">
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="font-semibold">Makanan</span>
                    <span class="shrink-0 ml-4"><span data-sum="makanan" class="font-bold">Rp 0</span> <span data-pct="makanan" class="text-slate-400 text-xs inline-block w-12 text-right">0%</span></span>
                </div>
                <div class="bar-track"><div data-bar="makanan" class="bar-fill" style="width: 0%"></div></div>
            </div>
            <div class="mb-5">
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="font-semibold">Tiket Masuk</span>
                    <span class="shrink-0 ml-4"><span data-sum="tiket" class="font-bold">Rp 0</span> <span data-pct="tiket" class="text-slate-400 text-xs inline-block w-12 text-right">0%</span></span>
                </div>
                <div class="bar-track"><div data-bar="tiket" class="bar-fill" style="width: 0%"></div></div>
            </div>
            <div class="mb-6">
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="font-semibold">Aktivitas & Lainnya</span>
                    <span class="shrink-0 ml-4"><span data-sum="aktivitas" class="font-bold">Rp 0</span> <span data-pct="aktivitas" class="text-slate-400 text-xs inline-block w-12 text-right">0%</span></span>
                </div>
                <div class="bar-track"><div data-bar="aktivitas" class="bar-fill" style="width: 0%"></div></div>
            </div>

            <div class="border-t border-slate-100 pt-5 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Total</p>
                    <p id="summary-total" class="font-extrabold text-xl text-primary">Rp 0</p>
                </div>
                <div class="text-right">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Estimasi / hari</p>
                    <p id="summary-estimasi" class="font-extrabold text-xl">Rp 0</p>
                </div>
            </div>
        </div>

        <div id="summary-kosong" class="hidden text-center py-10">
            <h3 class="font-extrabold text-lg">Belum ada budget</h3>
            <p class="text-sm text-slate-500 mt-1">Isi kalkulator budget di atas, ringkasannya muncul di sini.</p>
        </div>
    </div>
</section>

<template id="tpl-destinasi">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <img data-field="gambar" src="" alt="" class="w-full h-32 object-cover" loading="lazy">
        <div class="p-4">
            <div class="flex items-center justify-between gap-2">
                <h4 data-field="nama" class="font-bold text-sm"></h4>
                <span data-field="kategori" class="text-[11px] font-bold bg-cream text-primary px-2.5 py-1 rounded-full shrink-0"></span>
            </div>
            <p data-field="lokasi" class="text-xs text-slate-500 mt-1"></p>
            <p data-field="tiket" class="text-sm font-extrabold text-primary mt-2"></p>
        </div>
    </div>
</template>

<script src="{{ asset('js/dashboard.js') }}"></script>

@endsection
