
// ==============================================
// JELAJAH.IN - FAVORITE CARD SYSTEM
// Sinkronisasi Home, Explore, Detail & Favorite
// Menggunakan localStorage
// ==============================================

(function () {

    const STORAGE_KEY = 'jelajah.in:favorites';

    const BUTTON_SELECTOR = '.js-card-favorite';

    // ==========================================
    // 1. AMBIL FAVORITE DARI LOCALSTORAGE
    // ==========================================

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
                    && typeof item.slug === 'string';
            });

        } catch (error) {

            console.error(
                'Gagal membaca data Favorite:',
                error
            );

            return [];

        }

    }


    // ==========================================
    // 2. SIMPAN FAVORITE KE LOCALSTORAGE
    // ==========================================

    function saveFavorites(favorites) {

        localStorage.setItem(
            STORAGE_KEY,
            JSON.stringify(favorites)
        );

    }


    // ==========================================
    // 3. AMBIL DATA DARI KARTU DESTINASI
    // ==========================================

    function getDestinationFromButton(button) {

        return {

            slug: button.dataset.favSlug,

            nama: button.dataset.favNama,

            lokasi: button.dataset.favLokasi,

            provinsi: button.dataset.favProvinsi || '',

            kategori: button.dataset.favKategori,

            rating: button.dataset.favRating,

            harga: button.dataset.favHarga,

            tiket: Number(
                button.dataset.favTiket || 0
            ),

            gambar: button.dataset.favGambar

        };

    }


    // ==========================================
    // 4. PERBARUI TAMPILAN SELURUH TOMBOL HATI
    // ==========================================

    function updateFavoriteButtons() {

        const favorites = getFavorites();

        const savedSlugs = new Set(
            favorites.map(function (item) {
                return item.slug;
            })
        );

        const buttons = document.querySelectorAll(
            BUTTON_SELECTOR
        );

        buttons.forEach(function (button) {

            const slug = button.dataset.favSlug;

            const nama = button.dataset.favNama;

            const isFavorite = savedSlugs.has(slug);

            // WARNA TOMBOL
            button.classList.toggle(
                'text-rose-500',
                isFavorite
            );

            button.classList.toggle(
                'text-slate-500',
                !isFavorite
            );

            // STATUS FAVORITE
            button.setAttribute(
                'aria-pressed',
                String(isFavorite)
            );

            // LABEL TOMBOL
            const label = isFavorite
                ? 'Hapus ' + nama + ' dari Favorite'
                : 'Tambah ' + nama + ' ke Favorite';

            button.setAttribute(
                'aria-label',
                label
            );

            button.setAttribute(
                'title',
                isFavorite
                    ? 'Hapus dari Favorite'
                    : 'Tambah ke Favorite'
            );

            // UBAH WARNA ISI IKON HATI
            const icon = button.querySelector('svg');

            if (icon) {

                icon.setAttribute(
                    'fill',
                    isFavorite
                        ? 'currentColor'
                        : 'none'
                );

            }

        });

    }


    // ==========================================
    // 5. TAMBAH ATAU HAPUS FAVORITE
    // ==========================================

    function toggleFavorite(button) {

        const destinasi = getDestinationFromButton(
            button
        );

        if (!destinasi.slug) {
            return;
        }

        let favorites = getFavorites();

        const sudahAda = favorites.some(
            function (item) {
                return item.slug === destinasi.slug;
            }
        );

        if (sudahAda) {

            // HAPUS DARI FAVORITE
            favorites = favorites.filter(
                function (item) {
                    return item.slug !== destinasi.slug;
                }
            );

        } else {

            // TAMBAHKAN KE FAVORITE
            favorites.push(destinasi);

        }

        try {

            saveFavorites(favorites);

            updateFavoriteButtons();

        } catch (error) {

            console.error(
                'Gagal menyimpan Favorite:',
                error
            );

            alert(
                'Favorite belum bisa disimpan di browser ini.'
            );

        }

    }


    // ==========================================
    // 6. EVENT KLIK TOMBOL FAVORITE
    // ==========================================

    document.addEventListener(
        'click',
        function (event) {

            const button = event.target.closest(
                BUTTON_SELECTOR
            );

            if (!button) {
                return;
            }

            event.preventDefault();

            toggleFavorite(button);

        }
    );


    // ==========================================
    // 7. SINKRONISASI SAAT HALAMAN DIBUKA
    // ==========================================

    function initializeFavorites() {

        updateFavoriteButtons();

    }

    if (document.readyState === 'loading') {

        document.addEventListener(
            'DOMContentLoaded',
            initializeFavorites
        );

    } else {

        initializeFavorites();

    }


    // ==========================================
    // 8. UPDATE SAAT KEMBALI KE HALAMAN
    // ==========================================

    window.addEventListener(
        'pageshow',
        function () {

            updateFavoriteButtons();

        }
    );


    // ==========================================
    // 9. UPDATE JIKA STORAGE BERUBAH DI TAB LAIN
    // ==========================================

    window.addEventListener(
        'storage',
        function (event) {

            if (
                event.key === STORAGE_KEY ||
                event.key === null
            ) {

                updateFavoriteButtons();

            }

        }
    );

})();
