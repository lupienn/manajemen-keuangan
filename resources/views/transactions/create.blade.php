<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('transactions.index') }}" class="p-2 text-slate-500 hover:text-blue-400 hover:bg-slate-800 rounded-xl transition">
                <x-lucide-arrow-left class="w-5 h-5" />
            </a>
            <div>
                <h1 class="text-2xl font-black text-white tracking-tight">
                    Tambah {{ ucfirst($jenis) }}
                </h1>
                <p class="text-sm text-slate-400 mt-1 font-medium">Isi form berikut untuk mencatat transaksi baru.</p>
            </div>
        </div>

        <div class="bg-slate-900 border border-slate-800 rounded-3xl shadow-2xl p-8">
            <form method="POST" action="{{ route('transactions.store') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="jenis" value="{{ $jenis }}">

                {{-- Jenis indicator --}}
                <div class="flex items-center gap-3 p-4 rounded-2xl {{ $jenis === 'pemasukan' ? 'bg-emerald-500/10 border border-emerald-500/20' : 'bg-rose-500/10 border border-rose-500/20' }}">
                    @if($jenis === 'pemasukan')
                        <x-lucide-trending-up class="w-5 h-5 text-emerald-400" />
                        <span class="text-xs font-black uppercase tracking-widest text-emerald-400">Transaksi Pemasukan</span>
                    @else
                        <x-lucide-trending-down class="w-5 h-5 text-rose-400" />
                        <span class="text-xs font-black uppercase tracking-widest text-rose-400">Transaksi Pengeluaran</span>
                    @endif
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="deskripsi" class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Deskripsi <span class="text-rose-500">*</span></label>
                    <input type="text" name="deskripsi" id="deskripsi" value="{{ old('deskripsi') }}" required
                        class="w-full border-0 bg-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 placeholder-slate-600 font-bold"
                        placeholder="Contoh: Penjualan Produk Bulan Mei">
                    @error('deskripsi') <p class="mt-2 text-[10px] font-bold text-rose-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>

                {{-- Nominal --}}
                <div>
                    <label for="jumlah" class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Nominal (Rp) <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-4 flex items-center text-slate-500 text-sm font-bold">Rp</span>
                        <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" required min="1"
                            class="w-full border-0 bg-slate-800 rounded-xl pl-11 pr-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 placeholder-slate-600 font-bold"
                            placeholder="0">
                    </div>
                    @error('jumlah') <p class="mt-2 text-[10px] font-bold text-rose-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>

                {{-- Tanggal --}}
                <div>
                    <label for="tanggal" class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Tanggal <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}" required
                        class="w-full border-0 bg-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 font-bold">
                    @error('tanggal') <p class="mt-2 text-[10px] font-bold text-rose-500 uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="category_id" class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Kategori</label>
                    <select name="category_id" id="category_id"
                        class="w-full border-0 bg-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 font-bold">
                        <option value="">— Pilih Kategori —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nama }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Catatan --}}
                <div>
                    <label for="catatan" class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Catatan (Opsional)</label>
                    <textarea name="catatan" id="catatan" rows="3"
                        class="w-full border-0 bg-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 placeholder-slate-600 font-bold"
                        placeholder="Tambahkan catatan jika diperlukan...">{{ old('catatan') }}</textarea>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="submit"
                        class="flex-1 py-4 px-6 {{ $jenis === 'pemasukan' ? 'bg-emerald-600 hover:bg-emerald-500 shadow-emerald-900/20' : 'bg-rose-600 hover:bg-rose-500 shadow-rose-900/20' }} text-white text-xs font-black uppercase tracking-widest rounded-xl transition shadow-xl">
                        Simpan Transaksi
                    </button>
                    <a href="{{ route('transactions.index') }}"
                       class="px-6 py-4 border border-slate-800 text-slate-400 rounded-xl hover:bg-slate-800 transition text-[10px] font-black uppercase tracking-widest text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
