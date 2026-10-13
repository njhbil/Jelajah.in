<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

class DestinationController extends Controller
{
    public function show(string $slug)
    {
        // Mengambil seluruh destinasi dari Explore
        $destinasi = collect(ExploreController::allDestinations())
            ->first(function ($item) use ($slug) {
                return Str::slug($item['nama']) === $slug;
            });

        // Menampilkan halaman 404 jika destinasi tidak ditemukan
        abort_if($destinasi === null, 404);

        // Menambahkan identitas destinasi
        $destinasi['slug'] = $slug;

        // Mengubah format harga menjadi Rupiah
        $destinasi['harga'] = $destinasi['tiket'] == 0
            ? 'Gratis'
            : 'Rp ' . number_format(
                $destinasi['tiket'],
                0,
                ',',
                '.'
            );

        // Deskripsi dummy untuk tahap frontend
        $deskripsi = "Nikmati pengalaman wisata di {$destinasi['nama']}, "
            . "yang berlokasi di {$destinasi['lokasi']}. "
            . "Destinasi ini dapat menjadi pilihan untuk "
            . "menjelajahi keindahan dan keberagaman Indonesia. "
            . "Rencanakan perjalananmu dengan lebih mudah "
            . "bersama Jelajah.in.";

        // Fasilitas contoh, belum diverifikasi per destinasi
        $fasilitas = [
            'Area Parkir',
            'Toilet Umum',
            'Tempat Makan',
            'Spot Foto',
        ];

        // Belum tersedia dalam data Explore
        $jamBuka = 'Belum tersedia';

        return view('destinations.show', compact(
            'destinasi',
            'deskripsi',
            'fasilitas',
            'jamBuka'
        ));
    }
}
