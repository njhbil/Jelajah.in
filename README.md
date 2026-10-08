# Jelajah.in

Smart travel planner buat keliling Indonesia. Cari destinasi, susun itinerary harian, sama atur budget liburan dalam satu tempat.

## Fitur

- Cari destinasi berdasarkan nama, provinsi, dan budget
- Destinasi populer dan rekomendasi pilihan editor
- Jelajah berdasarkan kategori: pantai, gunung, budaya, kuliner, danau, kota
- Susun itinerary Day 1, Day 2, dan seterusnya
- Hitung estimasi budget perjalanan

## Jalanin project

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Buka http://127.0.0.1:8000 di browser.

## Dibangun dengan

Laravel, Blade, Tailwind CSS, JavaScript
