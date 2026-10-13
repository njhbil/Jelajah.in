
@extends('layouts.app')

@section('content')

<section class="max-w-7xl mx-auto px-5 lg:px-8 pt-28 pb-20 min-h-[75vh]">

    <!-- BREADCRUMB -->
    <nav class="text-sm text-slate-500 mb-8">
        <a href="{{ route('home') }}"
           class="hover:text-primary">Home</a>

        <span class="mx-2">/</span>

        <span class="text-primary font-semibold">
            Favorite
        </span>
    </nav>

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-end
                md:justify-between gap-5 mb-10">

        <div>
            <p class="text-accent font-bold text-sm mb-2">
                — Destinasi Pilihanmu
            </p>

            <h1 class="text-3xl md:text-5xl font-extrabold
                       text-primary">
                Destinasi Favorit
            </h1>

            <p class="text-slate-500 mt-4 max-w-xl">
                Simpan destinasi impianmu dan temukan kembali
                tempat-tempat yang ingin kamu kunjungi.
            </p>
        </div>

        <a href="{{ route('explore') }}"
           class="inline-flex justify-center items-center
                  bg-primary text-white font-bold text-sm
                  px-6 py-3 rounded-full
                  hover:bg-secondary transition">
            + Jelajahi Destinasi
        </a>
    </div>

    <!-- JUMLAH FAVORIT -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="font-extrabold text-xl text-primary">
            Daftar Favorit
        </h2>

        <span id="jumlah-favorite"
              class="bg-green-100 text-secondary
                     px-4 py-2 rounded-full text-sm font-bold">
            0 Destinasi
        </span>
    </div>

    <!-- KONDISI KOSONG -->
    <div id="favorite-empty"
         class="hidden bg-white rounded-3xl
                border border-slate-100
                p-10 md:p-16 text-center shadow-sm">

        <div class="w-20 h-20 rounded-full bg-green-50
                    flex items-center justify-center
                    mx-auto mb-6">

            <span class="text-4xl text-primary">
                ♡
            </span>
        </div>

        <h3 class="text-2xl font-extrabold text-primary mb-3">
            Belum Ada Destinasi Favorit
        </h3>

        <p class="text-slate-500 max-w-md mx-auto mb-7">
            Kamu belum menyimpan destinasi apa pun.
            Yuk, eksplorasi tempat wisata menarik
            dan tambahkan ke daftar favoritmu!
        </p>

        <a href="{{ route('explore') }}"
           class="inline-block bg-primary text-white
                  font-bold px-7 py-3 rounded-full
                  hover:bg-secondary transition">
            Mulai Explore →
        </a>
    </div>

    <!-- GRID FAVORIT -->
    <div id="favorite-grid"
         class="grid sm:grid-cols-2 lg:grid-cols-3 gap-7">
    </div>

    <!-- PESAN STATUS -->
    <p id="favorite-status"
       role="status"
       aria-live="polite"
       class="sr-only">
    </p>

</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const STORAGE_KEY = 'jelajah.in:favorites';

    const grid = document.getElementById('favorite-grid');
    const empty = document.getElementById('favorite-empty');
    const jumlah = document.getElementById('jumlah-favorite');
    const status = document.getElementById('favorite-status');

    const detailBaseUrl = @json(url('/destinations'));

    // MENGAMBIL DATA FAVORIT
    function getFavorites() {
        try {
            const data = JSON.parse(
                localStorage.getItem(STORAGE_KEY) || '[]'
            );

            if (!Array.isArray(data)) {
                return [];
            }

            return data.filter(function (item) {
                return item
                    && typeof item.slug === 'string'
                    && /^[a-z0-9-]+$/.test(item.slug)
                    && typeof item.nama === 'string';
            });

        } catch (error) {
            return [];
        }
    }

    // MENGHAPUS FAVORIT
    function removeFavorite(slug) {
        const favorites = getFavorites().filter(
            function (item) {
                return item.slug !== slug;
            }
        );

        try {
            localStorage.setItem(
                STORAGE_KEY,
                JSON.stringify(favorites)
            );

            status.textContent = 'Destinasi berhasil dihapus.';
            renderFavorites();

        } catch (error) {
            alert('Gagal menghapus destinasi favorit.');
        }
    }

    // MEMBUAT KARTU DESTINASI
    function createCard(item) {

        const card = document.createElement('article');

        card.className =
            'bg-white rounded-3xl overflow-hidden ' +
            'shadow-sm border border-slate-100 ' +
            'hover:shadow-xl transition duration-300';

        card.innerHTML = `
            <div class="relative h-56 overflow-hidden">

                <img class="favorite-image w-full h-full
                            object-cover"
                     loading="lazy">

                <span class="favorite-category
                             absolute top-4 left-4
                             bg-white/90 text-primary
                             text-xs font-bold
                             px-3 py-2 rounded-full">
                </span>

            </div>

            <div class="p-6">

                <div class="flex items-start
                            justify-between gap-3 mb-2">

                    <h3 class="favorite-name text-lg
                               font-extrabold text-primary">
                    </h3>

                    <span class="favorite-rating
                                 text-accent text-sm
                                 font-extrabold shrink-0">
                    </span>
                </div>

                <p class="favorite-location
                          text-slate-500 text-sm mb-5">
                </p>

                <div class="flex items-center
                            justify-between gap-3 mb-5">

                    <div>
                        <p class="text-xs text-slate-400 mb-1">
                            Estimasi tiket
                        </p>

                        <p class="favorite-price
                                  font-extrabold text-primary">
                        </p>
                    </div>

                </div>

                <div class="flex gap-3">

                    <a class="favorite-detail flex-1
                              bg-primary text-white
                              text-center font-bold text-sm
                              py-3 rounded-full
                              hover:bg-secondary transition">
                        Lihat Detail
                    </a>

                    <button type="button"
                            class="favorite-remove
                                   border border-red-200
                                   text-red-500 font-bold
                                   text-sm px-5 py-3
                                   rounded-full
                                   hover:bg-red-50 transition">
                        Hapus
                    </button>

                </div>

            </div>
        `;

        // MEMASUKKAN DATA KE KARTU
        const image = card.querySelector('.favorite-image');

        image.src = item.gambar || '';
        image.alt = item.nama;

        card.querySelector('.favorite-category')
            .textContent = item.kategori || 'Wisata';

        card.querySelector('.favorite-name')
            .textContent = item.nama;

        card.querySelector('.favorite-rating')
            .textContent = '★ ' + (item.rating || '-');

        card.querySelector('.favorite-location')
            .textContent = '📍 ' + (item.lokasi || '-');

        card.querySelector('.favorite-price')
            .textContent = item.harga ||
                (item.tiket === 0
                    ? 'Gratis'
                    : 'Rp ' + Number(item.tiket || 0)
                        .toLocaleString('id-ID'));

        // LINK KE DETAIL DESTINASI
        card.querySelector('.favorite-detail').href =
            detailBaseUrl + '/' + encodeURIComponent(item.slug);

        // TOMBOL HAPUS FAVORIT
        card.querySelector('.favorite-remove')
            .addEventListener('click', function () {
                removeFavorite(item.slug);
            });

        return card;
    }

    // MENAMPILKAN SELURUH FAVORIT
    function renderFavorites() {

        const favorites = getFavorites();

        grid.replaceChildren();

        jumlah.textContent =
            favorites.length + ' Destinasi';

        if (favorites.length === 0) {
            empty.classList.remove('hidden');
            grid.classList.add('hidden');
            return;
        }

        empty.classList.add('hidden');
        grid.classList.remove('hidden');

        favorites.forEach(function (item) {
            grid.appendChild(createCard(item));
        });
    }

    // SINKRONISASI JIKA FAVORIT BERUBAH DI TAB LAIN
    window.addEventListener('storage', function (event) {
        if (event.key === STORAGE_KEY) {
            renderFavorites();
        }
    });

    // JALANKAN SAAT HALAMAN DIBUKA
    renderFavorites();

});
</script>
@endpush
