<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $trip = [
            'nama' => 'Liburan Bali',
            'tanggal_mulai' => '2026-07-10',
            'tanggal_selesai' => '2026-07-13',
            'penumpang' => 2,
            'destinasi' => [
                [
                    'nama' => 'Pantai Kuta',
                    'lokasi' => 'Badung, Bali',
                    'kategori' => 'Pantai',
                    'tiket' => 25000,
                    'gambar' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600&q=80',
                ],
                [
                    'nama' => 'Pura Ulun Danu Beratan',
                    'lokasi' => 'Tabanan, Bali',
                    'kategori' => 'Budaya',
                    'tiket' => 75000,
                    'gambar' => 'https://images.unsplash.com/photo-1604999333679-b86d54738315?w=600&q=80',
                ],
                [
                    'nama' => 'Sawah Tegallalang',
                    'lokasi' => 'Gianyar, Bali',
                    'kategori' => 'Budaya',
                    'tiket' => 25000,
                    'gambar' => 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=600&q=80',
                ],
            ],
        ];

        $trip['jumlah_hari'] = (int) Carbon::parse($trip['tanggal_mulai'])
            ->diffInDays(Carbon::parse($trip['tanggal_selesai'])) + 1;

        $budget = [
            'transport' => 1200000,
            'hotel' => 1800000,
            'makanan' => 900000,
            'tiket' => 125000,
            'aktivitas' => 450000,
        ];

        return view('dashboard', compact('trip', 'budget'));
    }
}
