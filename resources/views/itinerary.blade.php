@extends('layouts.app')

@section('content')

<header class="bg-primary pt-32 pb-12">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <p class="text-accent font-bold text-sm tracking-wide">
            — Itinerary
        </p>

        <h1 class="text-white font-extrabold text-3xl md:text-5xl mt-1">
            Itinerary Perjalanan
        </h1>

        <p class="text-white/75 mt-3 max-w-xl text-sm md:text-base">
            Rencanakan perjalanan, atur aktivitas harian, dan susun
            petualanganmu dengan lebih mudah.
        </p>
    </div>
</header>

<section class="pb-16">
    <div class="max-w-7xl mx-auto px-5 lg:px-8 mt-10">

        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100">
            <h2 class="text-xl font-extrabold mb-6">
                Informasi Perjalanan
            </h2>

            <form id="form-itinerary" class="grid md:grid-cols-2 gap-5">
                <div>
                    <label for="nama-perjalanan"
                        class="block text-sm font-semibold mb-2">
                        Nama Perjalanan
                    </label>
                    <input id="nama-perjalanan" type="text"
                        placeholder="Contoh: Liburan ke Bali"
                        required
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-secondary">
                </div>

                <div>
                    <label for="destinasi"
                        class="block text-sm font-semibold mb-2">
                        Destinasi Utama
                    </label>
                    <input id="destinasi" type="text"
                        placeholder="Contoh: Bali, Yogyakarta"
                        required
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-secondary">
                </div>

                <div>
                    <label for="tanggal-mulai"
                        class="block text-sm font-semibold mb-2">
                        Tanggal Mulai
                    </label>
                    <input id="tanggal-mulai" type="date" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-secondary">
                </div>

                <div>
                    <label for="jumlah-hari"
                        class="block text-sm font-semibold mb-2">
                        Durasi Perjalanan
                    </label>
                    <select id="jumlah-hari"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-secondary">
                        <option value="1">1 hari</option>
                        <option value="2" selected>2 hari</option>
                        <option value="3">3 hari</option>
                        <option value="4">4 hari</option>
                        <option value="5">5 hari</option>
                        <option value="7">7 hari</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <button type="submit"
                        class="bg-primary text-white font-bold px-6 py-3 rounded-xl hover:bg-secondary transition">
                        Buat Rencana Perjalanan
                    </button>
                </div>
            </form>
        </div>

        <div id="area-aktivitas"
            class="hidden bg-white rounded-3xl p-6 md:p-8 mt-8 shadow-sm border border-slate-100">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
                <div>
                    <h2 id="judul-rencana"
                        class="text-2xl font-extrabold text-primary">
                        Rencana Perjalanan
                    </h2>
                    <p id="info-rencana" class="text-sm text-slate-500 mt-1"></p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-5">
                        <div class="rounded-2xl bg-cream p-4">
                            <p class="text-sm text-slate-500">Tanggal Selesai</p>
                            <p id="ringkasan-selesai" class="font-extrabold text-primary mt-1">-</p>
                        </div>
                        <div class="rounded-2xl bg-cream p-4">
                            <p class="text-sm text-slate-500">Durasi Perjalanan</p>
                            <p id="ringkasan-durasi" class="font-extrabold text-primary mt-1">-</p>
                        </div>
                        <div class="rounded-2xl bg-cream p-4">
                            <p class="text-sm text-slate-500">Total Aktivitas</p>
                            <p id="ringkasan-aktivitas" class="font-extrabold text-primary mt-1">0 aktivitas</p>
                        </div>
                    </div>
                </div>

                <button id="btn-hapus-semua" type="button"
                    class="text-red-600 border border-red-200 rounded-xl px-4 py-2 text-sm font-bold hover:bg-red-50">
                    Hapus Rencana
                </button>
            </div>

            <div id="daftar-hari" class="flex flex-wrap gap-2 mb-6"></div>

            <div class="bg-cream rounded-2xl p-5 mb-6">
                <h3 id="judul-hari" class="text-lg font-extrabold mb-4">
                    Aktivitas Hari 1
                </h3>

                <form id="form-aktivitas" class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="waktu-aktivitas"
                            class="block text-sm font-semibold mb-2">
                            Waktu
                        </label>
                        <input id="waktu-aktivitas" type="time" required
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3">
                    </div>

                    <div>
                        <label for="nama-aktivitas"
                            class="block text-sm font-semibold mb-2">
                            Nama Aktivitas
                        </label>
                        <input id="nama-aktivitas" type="text" required
                            placeholder="Contoh: Mengunjungi pantai"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3">
                    </div>

                    <div>
                        <label for="lokasi-aktivitas"
                            class="block text-sm font-semibold mb-2">
                            Lokasi
                        </label>
                        <input id="lokasi-aktivitas" type="text"
                            placeholder="Nama tempat wisata"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3">
                    </div>

                    <div>
                        <label for="catatan-aktivitas"
                            class="block text-sm font-semibold mb-2">
                            Catatan
                        </label>
                        <input id="catatan-aktivitas" type="text"
                            placeholder="Catatan tambahan (opsional)"
                            class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3">
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit"
                            class="bg-accent text-white font-bold px-6 py-3 rounded-xl hover:bg-amber-600 transition">
                            + Tambahkan Aktivitas
                        </button>
                    </div>
                </form>
            </div>

            <div id="daftar-aktivitas" class="space-y-3"></div>

            <p id="pesan-kosong"
                class="text-center text-slate-400 py-8">
                Belum ada aktivitas. Tambahkan aktivitas pertamamu!
            </p>

            <div class="mt-6 flex justify-end">
                <button id="btn-simpan" type="button"
                    class="bg-primary text-white font-bold px-6 py-3 rounded-xl hover:bg-secondary transition">
                    Simpan Perubahan
                </button>
            </div>

            <p id="pesan-status" class="text-sm text-secondary mt-3"></p>
        </div>

    </div>
</section>

@endsection

@push('scripts')
    <script src="{{ asset('js/itinerary.js') }}"></script>
@endpush