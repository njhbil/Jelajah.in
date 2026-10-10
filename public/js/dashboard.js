// Dashboard & Budget – baca/tulis localStorage (jelajah.trip, jelajah.budget),
// fallback ke data dummy dari controller bila localStorage kosong.

const budgetForm = document.getElementById('budget-form');

if (budgetForm) {
    const dummyEl = document.getElementById('dummy-data');
    const dummy = dummyEl ? JSON.parse(dummyEl.textContent) : { trip: null, budget: {} };

    const KEY_TRIP = 'jelajah.trip';
    const KEY_BUDGET = 'jelajah.budget';

    const bacaJson = (key) => {
        try { return JSON.parse(localStorage.getItem(key)); } catch (e) { return null; }
    };

    // trip dari localStorage (kontrak Anggota 4) atau dummy
    let trip = bacaJson(KEY_TRIP) || dummy.trip;

    // budget dari localStorage atau dummy
    const budgetAwal = Object.assign({}, dummy.budget, bacaJson(KEY_BUDGET) || {});
    let budget = Object.assign({}, budgetAwal);

    const rupiah = (n) => 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(n));
    const hariDari = (t) => {
        if (!t || !t.tanggalMulai) return 1;
        const mulai = new Date(t.tanggalMulai);
        const selesai = new Date(t.tanggalSelesai || t.tanggalMulai);
        const hari = Math.round((selesai - mulai) / 86400000) + 1;
        return Math.max(1, hari);
    };

    // ---------- Ringkasan Perjalanan ----------
    function renderTrip() {
        if (!trip) return;
        const hari = hariDari(trip);

        const setTeks = (id, teks) => {
            const el = document.getElementById(id);
            if (el) el.textContent = teks;
        };
        setTeks('trip-nama', trip.nama || '-');
        setTeks('trip-tanggal', trip.tanggalMulai ? new Date(trip.tanggalMulai).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) : '-');
        setTeks('trip-durasi', hari + ' hari ' + (hari - 1) + ' malam');
        setTeks('trip-penumpang', (trip.penumpang || 1) + ' orang');

        const dest = Array.isArray(trip.destinasi) ? trip.destinasi : [];
        setTeks('trip-jumlah-destinasi', '(' + dest.length + ')');

        const grid = document.getElementById('trip-destinasi');
        const kosong = document.getElementById('trip-kosong');
        const tpl = document.getElementById('tpl-destinasi');
        if (!grid || !tpl) return;

        grid.innerHTML = '';
        grid.classList.toggle('hidden', dest.length === 0);
        kosong.classList.toggle('hidden', dest.length > 0);

        dest.forEach((d) => {
            const kartu = tpl.content.cloneNode(true);
            const img = kartu.querySelector('[data-field="gambar"]');
            img.src = d.gambar || '';
            img.alt = d.nama || 'Destinasi';
            kartu.querySelector('[data-field="nama"]').textContent = d.nama || '-';
            kartu.querySelector('[data-field="kategori"]').textContent = d.kategori || '-';
            kartu.querySelector('[data-field="lokasi"]').textContent = d.lokasi || '-';
            kartu.querySelector('[data-field="tiket"]').textContent = d.tiket ? rupiah(d.tiket) : 'Gratis';
            grid.appendChild(kartu);
        });
    }

    // ---------- Format input uang ----------
    const inputs = Array.from(document.querySelectorAll('.budget-input'));

    function pasangFormat(input) {
        input.addEventListener('input', () => {
            const bersih = input.value.replace(/\D/g, '');
            input.value = bersih ? new Intl.NumberFormat('id-ID').format(Number(bersih)) : '';
            budget[input.dataset.kategori] = Number(bersih) || 0;
            render();
            simpan();
        });
        input.addEventListener('focus', () => {
            input.value = input.value.replace(/\D/g, '').replace(/^0+(?=\d)/, '');
            input.select();
        });
        input.addEventListener('blur', () => {
            const n = Number(input.value.replace(/\D/g, '')) || 0;
            input.value = n ? new Intl.NumberFormat('id-ID').format(n) : '';
        });
    }
    inputs.forEach(pasangFormat);

    // ---------- Hitung & render total + summary ----------
    const warnaBar = {
        transport: '#1B4332',
        hotel: '#2D6A4F',
        makanan: '#F59E0B',
        tiket: '#0EA5E9',
        aktivitas: '#A16207',
    };

    function render() {
        const total = Object.values(budget).reduce((a, b) => a + (Number(b) || 0), 0);
        const hari = hariDari(trip);
        const perHari = total > 0 ? Math.round(total / hari) : 0;

        const totalEl = document.getElementById('total-budget');
        const hariEl = document.getElementById('estimasi-hari');
        if (totalEl) totalEl.textContent = rupiah(total);
        if (hariEl) hariEl.textContent = rupiah(perHari);

        document.querySelectorAll('[data-sum]').forEach((el) => {
            el.textContent = rupiah(Number(budget[el.dataset.sum]) || 0);
        });

        document.querySelectorAll('[data-bar]').forEach((el) => {
            const k = el.dataset.bar;
            const nilai = Number(budget[k]) || 0;
            const pct = total > 0 ? (nilai / total) * 100 : 0;
            el.style.width = pct + '%';
            el.style.background = warnaBar[k] || '#1B4332';
        });
        document.querySelectorAll('[data-pct]').forEach((el) => {
            const nilai = Number(budget[el.dataset.pct]) || 0;
            el.textContent = total > 0 ? Math.round((nilai / total) * 100) + '%' : '0%';
        });

        const sumTotal = document.getElementById('summary-total');
        const sumHari = document.getElementById('summary-estimasi');
        if (sumTotal) sumTotal.textContent = rupiah(total);
        if (sumHari) sumHari.textContent = rupiah(perHari);

        const isi = document.getElementById('summary-isi');
        const kosong = document.getElementById('summary-kosong');
        if (isi && kosong) {
            isi.classList.toggle('hidden', total === 0);
            kosong.classList.toggle('hidden', total > 0);
        }
    }

    // ---------- Simpan ke localStorage (debounce) ----------
    let jedaSimpan;
    function simpan() {
        clearTimeout(jedaSimpan);
        jedaSimpan = setTimeout(() => {
            localStorage.setItem(KEY_BUDGET, JSON.stringify(budget));
        }, 300);
    }

    // ---------- Reset ke budget awal ----------
    const btnReset = document.getElementById('btn-reset-budget');
    if (btnReset) {
        btnReset.addEventListener('click', () => {
            budget = Object.assign({}, budgetAwal);
            localStorage.removeItem(KEY_BUDGET);
            isiInputDariBudget();
            render();
        });
    }

    function isiInputDariBudget() {
        inputs.forEach((input) => {
            const n = Number(budget[input.dataset.kategori]) || 0;
            input.value = n ? new Intl.NumberFormat('id-ID').format(n) : '';
        });
    }

    // ---------- Init ----------
    renderTrip();
    isiInputDariBudget();
    render();
}
