<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('transactions.index') }}" class="p-2 text-gray-500 hover:text-corporate hover:bg-gray-100 rounded-lg transition">
                <x-lucide-arrow-left class="w-5 h-5" />
            </a>
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                    Tambah {{ ucfirst($jenis) }}
                </h1>
                <p class="text-sm text-gray-500">Isi form berikut untuk mencatat transaksi baru.</p>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 dark:bg-gray-800 dark:border-gray-700">
            <form method="POST" action="{{ route('transactions.store') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="jenis" value="{{ $jenis }}">

                {{-- Jenis indicator --}}
                <div class="flex items-center gap-3 p-3 rounded-lg {{ $jenis === 'pemasukan' ? 'bg-emerald-50 border border-emerald-200' : 'bg-rose-50 border border-rose-200' }}">
                    @if($jenis === 'pemasukan')
                        <x-lucide-trending-up class="w-5 h-5 text-emerald-600" />
                        <span class="text-sm font-semibold text-emerald-700">Transaksi Pemasukan</span>
                    @else
                        <x-lucide-trending-down class="w-5 h-5 text-rose-600" />
                        <span class="text-sm font-semibold text-rose-700">Transaksi Pengeluaran</span>
                    @endif
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Deskripsi <span class="text-rose-500">*</span></label>
                    <input type="text" name="deskripsi" id="deskripsi" value="{{ old('deskripsi') }}" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-corporate focus:border-corporate dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="Contoh: Penjualan Produk Bulan Mei">
                    @error('deskripsi') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                {{-- Nominal --}}
                <div>
                    <label for="jumlah" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nominal (Rp) <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-500 text-sm font-medium">Rp</span>
                        <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" required min="1"
                            class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2.5 text-sm focus:ring-2 focus:ring-corporate focus:border-corporate dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            placeholder="0">
                    </div>
                    @error('jumlah') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                {{-- Tanggal --}}
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Tanggal <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-corporate focus:border-corporate dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('tanggal') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Kategori</label>
                    <select name="category_id" id="category_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-corporate focus:border-corporate dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">— Pilih Kategori —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nama }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Catatan --}}
                <div>
                    <label for="catatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Catatan (Opsional)</label>
                    <textarea name="catatan" id="catatan" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-corporate focus:border-corporate dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="Tambahkan catatan jika diperlukan...">{{ old('catatan') }}</textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 py-2.5 px-5 {{ $jenis === 'pemasukan' ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-rose-600 hover:bg-rose-700' }} text-white font-semibold rounded-lg transition shadow">
                        Simpan Transaksi
                    </button>
                    <a href="{{ route('transactions.index') }}"
                       class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-medium text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
