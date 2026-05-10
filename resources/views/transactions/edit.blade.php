<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('transactions.index') }}" class="p-2 text-gray-500 hover:text-corporate hover:bg-gray-100 rounded-lg transition">
                <x-lucide-arrow-left class="w-5 h-5" />
            </a>
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">Edit Transaksi</h1>
                <p class="text-sm text-gray-500">Perbarui detail transaksi di bawah ini.</p>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 dark:bg-gray-800 dark:border-gray-700">
            <form method="POST" action="{{ route('transactions.update', $transaction) }}" class="space-y-5">
                @csrf @method('PUT')

                {{-- Jenis indicator --}}
                <div class="flex items-center gap-3 p-3 rounded-lg {{ $transaction->jenis === 'pemasukan' ? 'bg-emerald-50 border border-emerald-200' : 'bg-rose-50 border border-rose-200' }}">
                    @if($transaction->jenis === 'pemasukan')
                        <x-lucide-trending-up class="w-5 h-5 text-emerald-600" />
                        <span class="text-sm font-semibold text-emerald-700">Transaksi Pemasukan</span>
                    @else
                        <x-lucide-trending-down class="w-5 h-5 text-rose-600" />
                        <span class="text-sm font-semibold text-rose-700">Transaksi Pengeluaran</span>
                    @endif
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi <span class="text-rose-500">*</span></label>
                    <input type="text" name="deskripsi" id="deskripsi" value="{{ old('deskripsi', $transaction->deskripsi) }}" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-corporate focus:border-corporate">
                    @error('deskripsi') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1.5">Nominal (Rp) <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-500 text-sm">Rp</span>
                        <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah', $transaction->jumlah) }}" required min="1"
                            class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2.5 text-sm focus:ring-2 focus:ring-corporate focus:border-corporate">
                    </div>
                    @error('jumlah') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $transaction->tanggal->format('Y-m-d')) }}" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-corporate focus:border-corporate">
                    @error('tanggal') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1.5">Kategori</label>
                    <select name="category_id" id="category_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-corporate focus:border-corporate">
                        <option value="">— Pilih Kategori —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $transaction->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1.5">Catatan (Opsional)</label>
                    <textarea name="catatan" id="catatan" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-corporate focus:border-corporate">{{ old('catatan', $transaction->catatan) }}</textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 py-2.5 px-5 bg-corporate hover:bg-blue-800 text-white font-semibold rounded-lg transition shadow">
                        Perbarui Transaksi
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
