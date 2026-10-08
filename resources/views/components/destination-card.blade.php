<div class="bg-white rounded-3xl overflow-hidden shadow-[0_10px_40px_-15px_rgba(0,0,0,0.2)] hover:-translate-y-2 transition duration-300 group">
    <div class="relative h-56 overflow-hidden">
        <img src="{{ $gambar }}" alt="{{ $nama }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" loading="lazy">
        <span class="absolute top-4 left-4 bg-white/90 text-primary text-xs font-bold px-3 py-1.5 rounded-full">{{ $kategori }}</span>
        <button class="btn-fav absolute top-4 right-4 w-9 h-9 bg-white/90 rounded-full flex items-center justify-center text-slate-500" aria-label="Simpan favorit">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20.5s-7-4.3-9-8.7c-1.2-2.6.4-5.8 3.3-5.8 1.9 0 3.4 1.4 5.7 3.9 2.3-2.5 3.8-3.9 5.7-3.9 2.9 0 4.5 3.2 3.3 5.8-2 4.4-9 8.7-9 8.7z"/></svg>
        </button>
    </div>
    <div class="p-5">
        <div class="flex items-center justify-between mb-1">
            <h3 class="font-bold text-lg">{{ $nama }}</h3>
            <span class="inline-flex items-center gap-1 text-sm font-bold text-accent">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.5l2.9 6.6 7.1.6-5.4 4.7 1.6 7-6.2-3.7-6.2 3.7 1.6-7L2 9.7l7.1-.6z"/></svg>
                {{ $rating }}
            </span>
        </div>
        <p class="text-sm text-slate-500 mb-4">{{ $lokasi }}</p>
        <div class="flex items-center justify-between">
            <span class="font-extrabold text-primary">{{ $harga }} <span class="font-normal text-xs text-slate-400">/ orang</span></span>
            <a href="#" class="text-sm font-bold bg-primary text-white px-4 py-2 rounded-full hover:bg-secondary transition">Detail</a>
        </div>
    </div>
</div>
