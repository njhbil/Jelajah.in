<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $populer = [
            [
                'nama' => 'Pantai Kuta',
                'lokasi' => 'Bali',
                'kategori' => 'Pantai',
                'rating' => '4.8',
                'harga' => 'Rp 25rb',
                'gambar' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600&q=80',
            ],
            [
                'nama' => 'Candi Borobudur',
                'lokasi' => 'Magelang, Jawa Tengah',
                'kategori' => 'Budaya',
                'rating' => '4.9',
                'harga' => 'Rp 50rb',
                'gambar' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?w=600&q=80',
            ],
            [
                'nama' => 'Gunung Bromo',
                'lokasi' => 'Malang, Jawa Timur',
                'kategori' => 'Gunung',
                'rating' => '4.9',
                'harga' => 'Rp 35rb',
                'gambar' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&q=80',
            ],
            [
                'nama' => 'Raja Ampat',
                'lokasi' => 'Papua Barat',
                'kategori' => 'Pantai',
                'rating' => '5.0',
                'harga' => 'Rp 100rb',
                'gambar' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=600&q=80',
            ],
        ];

        $rekomendasi = [
            [
                'nama' => 'Labuan Bajo',
                'lokasi' => 'Nusa Tenggara Timur',
                'deskripsi' => 'Gerbang menuju Komodo dan sunset pink beach yang terkenal.',
                'rating' => '4.9',
                'harga' => 'Rp 75rb',
                'gambar' => 'https://images.unsplash.com/photo-1512100356356-de1b84283e18?w=800&q=80',
            ],
            [
                'nama' => 'Danau Toba',
                'lokasi' => 'Sumatera Utara',
                'deskripsi' => 'Danau vulkanik terbesar di Asia Tenggara, tenang dan sejuk.',
                'rating' => '4.7',
                'harga' => 'Rp 20rb',
                'gambar' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?w=800&q=80',
            ],
            [
                'nama' => 'Malioboro',
                'lokasi' => 'Yogyakarta',
                'deskripsi' => 'Pusat kuliner dan belanja, cocok buat jalan santai malam hari.',
                'rating' => '4.6',
                'harga' => 'Gratis',
                'gambar' => 'https://images.unsplash.com/photo-1590076215667-875d4ef2d7de?w=800&q=80',
            ],
        ];

        $kategori = [
            ['nama' => 'Pantai', 'jumlah' => '120 tempat', 'icon' => 'pantai'],
            ['nama' => 'Gunung', 'jumlah' => '85 tempat', 'icon' => 'gunung'],
            ['nama' => 'Budaya', 'jumlah' => '96 tempat', 'icon' => 'budaya'],
            ['nama' => 'Kuliner', 'jumlah' => '150 tempat', 'icon' => 'kuliner'],
            ['nama' => 'Danau', 'jumlah' => '40 tempat', 'icon' => 'danau'],
            ['nama' => 'Kota', 'jumlah' => '70 tempat', 'icon' => 'kota'],
        ];

        return view('home', compact('populer', 'rekomendasi', 'kategori'));
    }
}
