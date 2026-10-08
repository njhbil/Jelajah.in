const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    if (window.scrollY > 50) navbar.classList.add('scrolled');
    else navbar.classList.remove('scrolled');
});

const btnMenu = document.getElementById('btn-menu');
const mobileMenu = document.getElementById('mobile-menu');
btnMenu.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
});

const formSearch = document.getElementById('form-search');
if (formSearch) {
    formSearch.addEventListener('submit', (e) => {
        e.preventDefault();
        const cari = document.getElementById('input-cari').value;
        const provinsi = document.getElementById('input-provinsi').value;
        const info = document.getElementById('search-info');
        if (!cari && !provinsi) {
            info.textContent = 'Tulis tujuan dulu ya, misal "Bali".';
            return;
        }
        info.textContent = `Mencari "${cari || 'semua destinasi'}" ${provinsi ? 'di ' + provinsi : ''}...`;
    });
}

document.querySelectorAll('.btn-fav').forEach((btn) => {
    btn.addEventListener('click', () => {
        btn.classList.toggle('aktif');
    });
});

const formNews = document.getElementById('form-newsletter');
if (formNews) {
    formNews.addEventListener('submit', (e) => {
        e.preventDefault();
        alert('Makasih sudah subscribe!');
        formNews.reset();
    });
}
