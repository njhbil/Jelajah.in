
@extends('layouts.app')

@section('content')

<section class="max-w-7xl mx-auto px-5 lg:px-8 pt-28 pb-20">

    <!-- BREADCRUMB -->
    <nav class="text-sm text-slate-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-primary">
            Home
        </a>
        <span class="mx-2">/</span>
        <a href="{{ route('explore') }}" class="hover:text-primary">
            Explore
        </a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-primary">
            {{ $destinasi['nama'] }}
        </span>
    </nav>

    <!-- HEADER DESTINASI -->
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-5 mb-8">

        <div>
            <span class="inline-block bg-green-100 text-secondary text-xs font-bold px-4 py-2 rounded-full mb-4">
                {{ $destinasi['kategori'] }}
            </span>

            <h1 class="text-3xl md:text-5xl font-extrabold text-primary">
                {{ $destinasi['nama'] }}
            </h1>

            <p class="text-slate-500 mt-3">
                📍 {{ $destinasi['lokasi'] }}
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="text-yellow-500 text-2xl">★</span>
            <span class="font-extrabold text-xl">
                {{ $destinasi['rating'] }}
            </span>
            <span class="text-sm text-slate-400">
                / 5
            </span>
        </div>

    </div>

    <!-- FOTO DESTINASI -->
    <div class="relative rounded-3xl overflow-hidden shadow-xl mb-10">

        <img
            src="{{ $destinasi['gambar'] }}"
            alt="{{ $destinasi['nama'] }}"
            class="w-full h-72 md:h-120 object-cover"
        >

        <a
            href="{{ $destinasi['gambar'] }}"
            target="_blank"
            rel="noopener noreferrer"
            class="absolute bottom-5 right-5 bg-white text-primary font-bold text-sm px-5 py-3 rounded-full shadow-lg hover:bg-cream transition"
        >
            Lihat Foto ↗
        </a>

    </div>

    <!-- INFORMASI DESTINASI -->
    <div class="grid lg:grid-cols-3 gap-8">

        <!-- BAGIAN KIRI -->
        <div class="lg:col-span-2 space-y-8">

            <!-- DESKRIPSI -->
            <div class="bg-white rounded-3xl p-7 md:p-8 shadow-sm">

                <h2 class="text-2xl font-extrabold text-primary mb-4">
                    Tentang Destinasi
                </h2>

                <p class="text-slate-600 leading-8 text-justify">
                    {{ $deskripsi }}
                </p>

            </div>

            <!-- FASILITAS -->
            <div class="bg-white rounded-3xl p-7 md:p-8 shadow-sm">

                <h2 class="text-2xl font-extrabold text-primary mb-4">
                    Fasilitas Wisata
                </h2>

                <p class="text-xs text-slate-400 mb-5">
                    Fasilitas berikut merupakan contoh untuk simulasi frontend.
                </p>

                <div class="grid sm:grid-cols-2 gap-4">

                    @foreach ($fasilitas as $item)

                    <div class="flex items-center gap-3 bg-cream rounded-2xl p-4">

                        <span class="w-9 h-9 rounded-full bg-green-100 text-secondary flex items-center justify-center font-bold">
                            ✓
                        </span>

                        <span class="font-semibold text-sm">
                            {{ $item }}
                        </span>

                    </div>

                    @endforeach

                </div>

            </div>

            <!-- INFORMASI TAMBAHAN -->
            <div class="bg-white rounded-3xl p-7 md:p-8 shadow-sm">

                <h2 class="text-2xl font-extrabold text-primary mb-5">
                    Informasi Wisata
                </h2>

                <div class="grid sm:grid-cols-2 gap-6">

                    <div>
                        <p class="text-slate-400 text-sm mb-2">
                            Provinsi
                        </p>
                        <p class="font-bold">
                            {{ $destinasi['provinsi'] }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-400 text-sm mb-2">
                            Kategori
                        </p>
                        <p class="font-bold">
                            {{ $destinasi['kategori'] }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-400 text-sm mb-2">
                            Jam Operasional
                        </p>
                        <p class="font-bold">
                            {{ $jamBuka }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-400 text-sm mb-2">
                            Rating
                        </p>
                        <p class="font-bold text-yellow-500">
                            ★ {{ $destinasi['rating'] }} / 5
                        </p>
                    </div>

                </div>

            </div>

        </div>

        <!-- BAGIAN KANAN -->
        <aside>

            <div class="bg-white rounded-3xl p-7 shadow-lg border border-slate-100 lg:sticky lg:top-28">

                <p class="text-sm text-slate-500">
                    Estimasi Harga Tiket
                </p>

                <h3 class="text-3xl font-extrabold text-primary mt-2">
                    {{ $destinasi['harga'] }}
                </h3>

                <p class="text-xs text-slate-400 mt-2">
                    Harga masih menggunakan data dummy.
                </p>

                <hr class="my-6 border-slate-100">

                <div class="space-y-5 mb-8">

                    <div>
                        <p class="text-sm text-slate-400 mb-1">
                            Destinasi
                        </p>
                        <p class="font-bold">
                            {{ $destinasi['nama'] }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-400 mb-1">
                            Lokasi
                        </p>
                        <p class="font-bold">
                            {{ $destinasi['lokasi'] }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-400 mb-1">
                            Jam Buka
                        </p>
                        <p class="font-bold">
                            {{ $jamBuka }}
                        </p>
                    </div>

                </div>

                <!-- FAVORITE -->
                <button
                    type="button"
                    id="btn-favorite-detail"
                    aria-pressed="false"
                    class="w-full border-2 border-primary text-primary font-bold py-3.5 rounded-full hover:bg-green-50 transition mb-3"
                >
                    ♡ Tambah ke Favorite
                </button>

                <a href="{{ route('favorites.index') }}"
                    class="block text-center w-full mb-3
                    text-primary font-bold text-sm
                    py-3 rounded-full bg-green-50
                 hover:bg-green-100 transition">
    ♥ Lihat Semua Favorite →
</a>


                <!-- ITINERARY -->
                <a
                    href="{{ route('itinerary') }}"
                    class="block text-center w-full bg-primary text-white font-bold py-3.5 rounded-full hover:bg-secondary transition"
                >
                    Lihat Itinerary →
                </a>

                <a
                    href="{{ route('explore') }}"
                    class="block text-center mt-5 text-sm font-semibold text-slate-500 hover:text-primary"
                >
                    ← Kembali ke Explore
                </a>

            </div>

        </aside>

    </div>

</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const tombol = document.getElementById('btn-favorite-detail');

    const storageKey = 'jelajah.in:favorites';

    const destinasi = @json($destinasi);

    function getFavorites() {
        try {
            const data = JSON.parse(
                localStorage.getItem(storageKey) || '[]'
            );

            return Array.isArray(data) ? data : [];
        } catch (error) {
            return [];
        }
    }

    function updateButton() {
        const favorites = getFavorites();

        const sudahFavorit = favorites.some(function (item) {
            return item.slug === destinasi.slug;
        });

        tombol.textContent = sudahFavorit
            ? '♥ Hapus dari Favorite'
            : '♡ Tambah ke Favorite';

        tombol.setAttribute(
            'aria-pressed',
            String(sudahFavorit)
        );
    }

    tombol.addEventListener('click', function () {

        let favorites = getFavorites();

        const sudahFavorit = favorites.some(function (item) {
            return item.slug === destinasi.slug;
        });

        if (sudahFavorit) {

            favorites = favorites.filter(function (item) {
                return item.slug !== destinasi.slug;
            });

        } else {

            favorites.push(destinasi);

        }

        try {
            localStorage.setItem(
                storageKey,
                JSON.stringify(favorites)
            );

            updateButton();

        } catch (error) {
            alert('Favorite tidak dapat disimpan di browser.');
        }

    });

    updateButton();

});
</script>
@endpush
