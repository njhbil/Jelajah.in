const exploreGrid = document.getElementById('explore-grid');

if (exploreGrid) {
    const PER_HALAMAN = 9;
    const items = Array.from(exploreGrid.querySelectorAll('.explore-item'));

    const inputCari = document.getElementById('explore-cari');
    const selectProvinsi = document.getElementById('filter-provinsi');
    const selectSort = document.getElementById('sort');
    const chips = document.querySelectorAll('.chip-kategori');
    const radioBudget = document.querySelectorAll('input[name="budget"]');
    const infoHasil = document.getElementById('info-hasil');
    const kosong = document.getElementById('explore-kosong');
    const pagination = document.getElementById('pagination');
    const panelFilter = document.getElementById('panel-filter');

    const state = {
        cari: '',
        kategori: '',
        provinsi: '',
        budget: '',
        sort: 'rekomendasi',
        halaman: 1,
    };

    // ambil filter awal dari URL, misal /explore?cari=bali&kategori=Pantai
    const params = new URLSearchParams(window.location.search);
    state.cari = params.get('cari') || params.get('q') || '';
    state.kategori = params.get('kategori') || '';
    state.provinsi = params.get('provinsi') || '';
    state.budget = params.get('budget') || '';
    state.sort = params.get('sort') || 'rekomendasi';
    state.halaman = parseInt(params.get('halaman')) || 1;

    inputCari.value = state.cari;
    selectProvinsi.value = state.provinsi;
    selectSort.value = state.sort;
    if (selectProvinsi.value !== state.provinsi) state.provinsi = '';
    if (selectSort.value !== state.sort) state.sort = 'rekomendasi';
    radioBudget.forEach((r) => (r.checked = r.value === state.budget));
    if (!document.querySelector('input[name="budget"]:checked')) {
        state.budget = '';
        radioBudget[0].checked = true;
    }

    function cocokBudget(tiket) {
        if (!state.budget) return true;
        const [min, max] = state.budget.split('-');
        if (tiket < Number(min)) return false;
        if (max !== '' && tiket > Number(max)) return false;
        return true;
    }

    function urutkan(list) {
        const angka = (el, key) => parseFloat(el.dataset[key]);
        const sorter = {
            rekomendasi: (a, b) => angka(a, 'urutan') - angka(b, 'urutan'),
            rating: (a, b) => angka(b, 'rating') - angka(a, 'rating'),
            termurah: (a, b) => angka(a, 'tiket') - angka(b, 'tiket'),
            termahal: (a, b) => angka(b, 'tiket') - angka(a, 'tiket'),
            nama: (a, b) => a.dataset.nama.localeCompare(b.dataset.nama),
        };
        return list.sort(sorter[state.sort] || sorter.rekomendasi);
    }

    function simpanKeUrl() {
        const p = new URLSearchParams();
        if (state.cari) p.set('cari', state.cari);
        if (state.kategori) p.set('kategori', state.kategori);
        if (state.provinsi) p.set('provinsi', state.provinsi);
        if (state.budget) p.set('budget', state.budget);
        if (state.sort !== 'rekomendasi') p.set('sort', state.sort);
        if (state.halaman > 1) p.set('halaman', state.halaman);
        const qs = p.toString();
        history.replaceState(null, '', window.location.pathname + (qs ? '?' + qs : ''));
    }

    function render() {
        const kata = state.cari.trim().toLowerCase();

        const hasil = urutkan(
            items.filter((el) => {
                const d = el.dataset;
                if (kata && !(d.nama + ' ' + d.lokasi).toLowerCase().includes(kata)) return false;
                if (state.kategori && d.kategori !== state.kategori) return false;
                if (state.provinsi && d.provinsi !== state.provinsi) return false;
                return cocokBudget(Number(d.tiket));
            })
        );

        const totalHalaman = Math.max(1, Math.ceil(hasil.length / PER_HALAMAN));
        state.halaman = Math.min(Math.max(1, state.halaman), totalHalaman);
        const mulai = (state.halaman - 1) * PER_HALAMAN;
        const tampil = hasil.slice(mulai, mulai + PER_HALAMAN);

        items.forEach((el) => el.classList.add('hidden'));
        tampil.forEach((el) => {
            el.classList.remove('hidden');
            exploreGrid.appendChild(el);
        });

        kosong.classList.toggle('hidden', hasil.length > 0);
        exploreGrid.classList.toggle('hidden', hasil.length === 0);

        infoHasil.innerHTML = hasil.length
            ? `Menampilkan <b class="text-slate-800">${mulai + 1}–${mulai + tampil.length}</b> dari <b class="text-slate-800">${hasil.length}</b> destinasi`
            : 'Tidak ada destinasi yang cocok';

        chips.forEach((c) => c.classList.toggle('aktif', c.dataset.kategori === state.kategori));

        renderPagination(totalHalaman, hasil.length);
        simpanKeUrl();
    }

    function tombolHalaman(label, halaman, opsi = {}) {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'page-btn' + (opsi.aktif ? ' aktif' : '');
        btn.innerHTML = label;
        btn.disabled = !!opsi.disabled;
        if (opsi.aria) btn.setAttribute('aria-label', opsi.aria);
        if (opsi.aktif) btn.setAttribute('aria-current', 'page');
        btn.addEventListener('click', () => {
            state.halaman = halaman;
            render();
            document.getElementById('hasil').scrollIntoView({ behavior: 'smooth' });
        });
        return btn;
    }

    function renderPagination(totalHalaman, jumlah) {
        pagination.innerHTML = '';
        if (jumlah === 0 || totalHalaman === 1) return;

        pagination.appendChild(tombolHalaman('&lsaquo;', state.halaman - 1, { disabled: state.halaman === 1, aria: 'Sebelumnya' }));
        for (let i = 1; i <= totalHalaman; i++) {
            pagination.appendChild(tombolHalaman(i, i, { aktif: i === state.halaman }));
        }
        pagination.appendChild(tombolHalaman('&rsaquo;', state.halaman + 1, { disabled: state.halaman === totalHalaman, aria: 'Berikutnya' }));
    }

    function ubah(key, value) {
        state[key] = value;
        state.halaman = 1;
        render();
    }

    let jeda;
    inputCari.addEventListener('input', () => {
        clearTimeout(jeda);
        jeda = setTimeout(() => ubah('cari', inputCari.value), 250);
    });

    document.getElementById('form-explore').addEventListener('submit', (e) => {
        e.preventDefault();
        clearTimeout(jeda);
        ubah('cari', inputCari.value);
        document.getElementById('hasil').scrollIntoView({ behavior: 'smooth' });
    });

    chips.forEach((chip) => {
        chip.addEventListener('click', () => ubah('kategori', chip.dataset.kategori));
    });

    selectProvinsi.addEventListener('change', () => ubah('provinsi', selectProvinsi.value));
    selectSort.addEventListener('change', () => ubah('sort', selectSort.value));
    radioBudget.forEach((r) => {
        r.addEventListener('change', () => ubah('budget', r.value));
    });

    function resetFilter() {
        state.cari = '';
        state.kategori = '';
        state.provinsi = '';
        state.budget = '';
        state.sort = 'rekomendasi';
        state.halaman = 1;
        inputCari.value = '';
        selectProvinsi.value = '';
        selectSort.value = 'rekomendasi';
        radioBudget[0].checked = true;
        render();
    }

    document.getElementById('btn-reset').addEventListener('click', resetFilter);
    document.getElementById('btn-reset-kosong').addEventListener('click', resetFilter);

    // panel filter versi mobile
    document.getElementById('btn-filter').addEventListener('click', () => {
        panelFilter.classList.toggle('hidden');
    });
    document.getElementById('btn-tutup-filter').addEventListener('click', () => {
        panelFilter.classList.add('hidden');
        document.getElementById('hasil').scrollIntoView({ behavior: 'smooth' });
    });

    render();
}
