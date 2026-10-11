document.addEventListener('DOMContentLoaded', () => {
    const STORAGE_KEY = 'jelajah_in_itinerary_v1';

    const formItinerary = document.getElementById('form-itinerary');
    const formAktivitas = document.getElementById('form-aktivitas');
    const areaAktivitas = document.getElementById('area-aktivitas');

    if (!formItinerary || !formAktivitas || !areaAktivitas) return;

    const inputNama = document.getElementById('nama-perjalanan');
    const inputDestinasi = document.getElementById('destinasi');
    const inputTanggal = document.getElementById('tanggal-mulai');
    const inputJumlahHari = document.getElementById('jumlah-hari');

    const inputWaktu = document.getElementById('waktu-aktivitas');
    const inputNamaAktivitas = document.getElementById('nama-aktivitas');
    const inputLokasi = document.getElementById('lokasi-aktivitas');
    const inputCatatan = document.getElementById('catatan-aktivitas');

    const judulRencana = document.getElementById('judul-rencana');
    const infoRencana = document.getElementById('info-rencana');
    const ringkasanSelesai = document.getElementById('ringkasan-selesai');
    const ringkasanDurasi = document.getElementById('ringkasan-durasi');
    const ringkasanAktivitas = document.getElementById('ringkasan-aktivitas');
    const daftarHari = document.getElementById('daftar-hari');
    const judulHari = document.getElementById('judul-hari');
    const daftarAktivitas = document.getElementById('daftar-aktivitas');
    const pesanKosong = document.getElementById('pesan-kosong');
    const pesanStatus = document.getElementById('pesan-status');

    const btnHapusSemua = document.getElementById('btn-hapus-semua');
    const btnSimpan = document.getElementById('btn-simpan');

    let rencana = null;
    let hariAktif = 1;
    let aktivitasEditId = null;

    function buatId() {
        return `${Date.now()}-${Math.random().toString(16).slice(2)}`;
    }

    function simpanKeBrowser(tampilkanPesan = false) {
        if (!rencana) return;

        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(rencana));

            if (tampilkanPesan) {
                pesanStatus.textContent = 'Perubahan berhasil disimpan di browser.';
            }
        } catch (error) {
            pesanStatus.textContent =
                'Data gagal disimpan. Periksa kapasitas penyimpanan browser.';
        }
    }

    function formatTanggal(tanggal) {
        if (!tanggal) return '-';

        const date = new Date(`${tanggal}T00:00:00`);

        return date.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
    }

    function buatRencana(nama, destinasi, tanggal, jumlahHari) {
        const aktivitasPerHari = {};

        for (let hari = 1; hari <= jumlahHari; hari++) {
            aktivitasPerHari[hari] = [];
        }

        return {
            nama,
            destinasi,
            tanggal,
            jumlahHari,
            aktivitasPerHari
        };
    }

    function tampilkanRingkasan() {
        const tanggalMulai = new Date(`${rencana.tanggal}T00:00:00`);
        const tanggalSelesai = new Date(tanggalMulai);

        tanggalSelesai.setDate(
        tanggalMulai.getDate() + rencana.jumlahHari - 1
        );

        ringkasanSelesai.textContent =
            tanggalSelesai.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });

        ringkasanDurasi.textContent =
            `${rencana.jumlahHari} hari`;

        const totalAktivitas = Object.values(rencana.aktivitasPerHari)
            .reduce((total, aktivitas) => total + aktivitas.length, 0);

        ringkasanAktivitas.textContent =
            `${totalAktivitas} aktivitas`;
        }

    function tampilkanRencana() {
        if (!rencana) {
            areaAktivitas.classList.add('hidden');
            return;
        }

        areaAktivitas.classList.remove('hidden');

        inputNama.value = rencana.nama;
        inputDestinasi.value = rencana.destinasi;
        inputTanggal.value = rencana.tanggal;
        inputJumlahHari.value = String(rencana.jumlahHari);

        judulRencana.textContent = rencana.nama;
        infoRencana.textContent =
            `${rencana.destinasi} • ${formatTanggal(rencana.tanggal)} • ${rencana.jumlahHari} hari`;
        
        tampilkanRingkasan();
        tampilkanDaftarHari();
        tampilkanAktivitas();
    }

    function tampilkanDaftarHari() {
        daftarHari.replaceChildren();

        for (let hari = 1; hari <= rencana.jumlahHari; hari++) {
            const tombol = document.createElement('button');

            tombol.type = 'button';
            tombol.textContent = `Hari ${hari}`;
            tombol.className =
                'px-5 py-2.5 rounded-xl text-sm font-bold transition ' +
                (hari === hariAktif
                    ? 'bg-primary text-white'
                    : 'bg-slate-100 text-slate-600 hover:bg-slate-200');

            tombol.addEventListener('click', () => {
                hariAktif = hari;
                pesanStatus.textContent = '';
                tampilkanDaftarHari();
                tampilkanAktivitas();
            });

            daftarHari.appendChild(tombol);
        }

        judulHari.textContent = `Aktivitas Hari ${hariAktif}`;
    }

    function tampilkanAktivitas() {
        daftarAktivitas.replaceChildren();

        const aktivitas = rencana.aktivitasPerHari[hariAktif] || [];

        pesanKosong.classList.toggle('hidden', aktivitas.length > 0);

        aktivitas
            .sort((a, b) => a.waktu.localeCompare(b.waktu))
            .forEach((item) => {
                const kartu = document.createElement('article');

                kartu.className =
                    'flex flex-col sm:flex-row sm:items-start gap-4 p-5 ' +
                    'border border-slate-100 rounded-2xl bg-white';

                const waktu = document.createElement('div');
                waktu.className =
                    'text-primary font-extrabold text-lg sm:w-20 shrink-0';
                waktu.textContent = item.waktu;

                const isi = document.createElement('div');
                isi.className = 'flex-1 min-w-0';

                const nama = document.createElement('h4');
                nama.className = 'font-bold text-slate-800';
                nama.textContent = item.nama;

                isi.appendChild(nama);

                if (item.lokasi) {
                    const lokasi = document.createElement('p');
                    lokasi.className = 'text-sm text-slate-500 mt-1';
                    lokasi.textContent = `📍 ${item.lokasi}`;
                    isi.appendChild(lokasi);
                }

                if (item.catatan) {
                    const catatan = document.createElement('p');
                    catatan.className = 'text-sm text-slate-500 mt-1';
                    catatan.textContent = item.catatan;
                    isi.appendChild(catatan);
                }

                const tombolEdit = document.createElement('button');
                tombolEdit.type = 'button';
                tombolEdit.textContent = 'Edit';
                tombolEdit.className =
                    'text-sm font-bold text-secondary hover:text-primary self-start';

                tombolEdit.addEventListener('click', () => {
                    aktivitasEditId = item.id;

                inputWaktu.value = item.waktu;
                inputNamaAktivitas.value = item.nama;
                inputLokasi.value = item.lokasi;
                inputCatatan.value = item.catatan;

                formAktivitas.querySelector('button[type="submit"]').textContent =
                    'Simpan Edit';

                pesanStatus.textContent = 'Ubah informasi aktivitas, lalu simpan.';
                formAktivitas.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                inputNamaAktivitas.focus();
                });

                const tombolHapus = document.createElement('button');
                tombolHapus.type = 'button';
                tombolHapus.textContent = 'Hapus';
                tombolHapus.className =
                    'text-sm font-bold text-red-600 hover:text-red-800 self-start';

                tombolHapus.addEventListener('click', () => {
                    rencana.aktivitasPerHari[hariAktif] =
                        rencana.aktivitasPerHari[hariAktif]
                            .filter((aktivitasItem) => aktivitasItem.id !== item.id);

                    simpanKeBrowser();
                    tampilkanAktivitas();
                    pesanStatus.textContent = 'Aktivitas berhasil dihapus.';
                });

                const aksi = document.createElement('div');
                aksi.className = 'flex items-center gap-4';

                aksi.append(tombolEdit, tombolHapus);
                kartu.append(waktu, isi, aksi);
                daftarAktivitas.appendChild(kartu);
            });
    }

    formItinerary.addEventListener('submit', (event) => {
        event.preventDefault();

        const nama = inputNama.value.trim();
        const destinasi = inputDestinasi.value.trim();
        const tanggal = inputTanggal.value;
        const jumlahHari = Number(inputJumlahHari.value);

        if (!nama || !destinasi || !tanggal || !jumlahHari) {
            alert('Lengkapi informasi perjalanan terlebih dahulu.');
            return;
        }

        if (
            rencana &&
            !confirm('Membuat rencana baru akan mengganti rencana saat ini. Lanjutkan?')
        ) {
            return;
        }

        rencana = buatRencana(nama, destinasi, tanggal, jumlahHari);
        hariAktif = 1;

        simpanKeBrowser();
        tampilkanRencana();

        pesanStatus.textContent = 'Rencana perjalanan berhasil dibuat.';
        areaAktivitas.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    formAktivitas.addEventListener('submit', (event) => {
        event.preventDefault();

        if (!rencana) return;

        const nama = inputNamaAktivitas.value.trim();

        if (!nama || !inputWaktu.value) {
            alert('Isi waktu dan nama aktivitas.');
            return;
        }

        const dataAktivitas = {
            waktu: inputWaktu.value,
            nama,
            lokasi: inputLokasi.value.trim(),
            catatan: inputCatatan.value.trim()
        };

        if (aktivitasEditId) {
            const aktivitasLama =
                rencana.aktivitasPerHari[hariAktif].find(
                    (item) => item.id === aktivitasEditId
                );

            if (aktivitasLama) {
                Object.assign(aktivitasLama, dataAktivitas);
            }

            pesanStatus.textContent = 'Aktivitas berhasil diperbarui.';
            aktivitasEditId = null;
        } else {
            rencana.aktivitasPerHari[hariAktif].push({
                id: buatId(),
                ...dataAktivitas
            });

            pesanStatus.textContent = 'Aktivitas berhasil ditambahkan.';
        }

        formAktivitas.reset();

        formAktivitas.querySelector('button[type="submit"]').textContent =
            '+ Tambahkan Aktivitas';

        simpanKeBrowser();
        tampilkanAktivitas();

        simpanKeBrowser();
        tampilkanAktivitas();

        formAktivitas.reset();
        pesanStatus.textContent = 'Aktivitas berhasil ditambahkan.';
    });

    btnSimpan.addEventListener('click', () => {
        simpanKeBrowser(true);
    });

    btnHapusSemua.addEventListener('click', () => {
        if (!rencana) return;

        if (!confirm('Yakin ingin menghapus seluruh rencana perjalanan?')) {
            return;
        }

        rencana = null;
        hariAktif = 1;

        localStorage.removeItem(STORAGE_KEY);
        formItinerary.reset();
        areaAktivitas.classList.add('hidden');
        pesanStatus.textContent = '';
    });

    try {
        const dataTersimpan = localStorage.getItem(STORAGE_KEY);

        if (dataTersimpan) {
            const data = JSON.parse(dataTersimpan);

            if (
                data &&
                typeof data.nama === 'string' &&
                typeof data.destinasi === 'string' &&
                Number.isInteger(data.jumlahHari) &&
                data.jumlahHari >= 1 &&
                data.jumlahHari <= 7 &&
                data.aktivitasPerHari &&
                typeof data.aktivitasPerHari === 'object'
            ) {
                for (let hari = 1; hari <= data.jumlahHari; hari++) {
                    if (!Array.isArray(data.aktivitasPerHari[hari])) {
                        data.aktivitasPerHari[hari] = [];
                    }
                }

                rencana = data;
                tampilkanRencana();
            }
        }
    } catch (error) {
        pesanStatus.textContent =
            'Data itinerary sebelumnya tidak dapat dibaca.';
    }
});