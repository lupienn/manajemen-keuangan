<x-app-layout>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Anggaran</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola anggaran bulanan untuk memantau pengeluaran.</p>
        </div>

        {{-- Month filter --}}
        <form method="GET" action="{{ route('budgets.index') }}" class="flex gap-2 items-center">
            <select name="bulan" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-corporate focus:border-corporate">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                @endfor
            </select>
            <select name="tahun" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-corporate focus:border-corporate">
                @for($y = now()->year; $y >= now()->year - 2; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="px-3 py-2 bg-corporate text-white text-sm rounded-lg hover:bg-blue-800 transition">Tampilkan</button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Budget List --}}
        <div class="lg:col-span-2 space-y-4">
            @forelse($budgets as $budget)
            @php $persen = $budget->persentase; @endphp
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $budget->nama }}</h3>
                        <span class="text-xs text-gray-400">{{ $budget->category?->nama ?? 'Tanpa Kategori' }}</span>
                    </div>
                    <div class="flex gap-1.5">
                        <span class="text-sm font-bold {{ $persen >= 90 ? 'text-rose-600' : ($persen >= 70 ? 'text-amber-600' : 'text-emerald-600') }}">
                            {{ $persen }}%
                        </span>
                        <form method="POST" action="{{ route('budgets.destroy', $budget) }}"
                              onsubmit="return confirm('Hapus anggaran ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1 text-gray-400 hover:text-rose-600 transition" title="Hapus">
                                <x-lucide-trash-2 class="w-4 h-4" />
                            </button>
                        </form>
                    </div>
                </div>

                <div class="w-full bg-gray-100 rounded-full h-3 dark:bg-gray-700 mb-2">
                    <div class="h-3 rounded-full transition-all duration-500 {{ $persen >= 90 ? 'bg-rose-500' : ($persen >= 70 ? 'bg-amber-400' : 'bg-emerald-500') }}"
                         style="width: {{ $persen }}%"></div>
                </div>

                <div class="flex justify-between text-sm text-gray-500">
                    <span>Terpakai: <span class="font-medium text-gray-900 dark:text-white">Rp {{ number_format($budget->realisasi, 0, ',', '.') }}</span></span>
                    <span>Anggaran: <span class="font-medium text-gray-900 dark:text-white">Rp {{ number_format($budget->jumlah_anggaran, 0, ',', '.') }}</span></span>
                </div>

                @if($persen >= 90)
                    <div class="mt-3 flex items-center gap-2 text-xs text-rose-600 bg-rose-50 border border-rose-100 rounded-lg px-3 py-2">
                        <x-lucide-alert-circle class="w-4 h-4 flex-shrink-0" />
                        Peringatan! Anggaran hampir habis. Sisa: Rp {{ number_format($budget->jumlah_anggaran - $budget->realisasi, 0, ',', '.') }}
                    </div>
                @endif
            </div>
            @empty
            <div class="bg-white border border-gray-200 rounded-xl p-12 text-center text-gray-400 dark:bg-gray-800 dark:border-gray-700">
                <x-lucide-pie-chart class="w-14 h-14 mx-auto mb-3 opacity-25" />
                <p class="font-medium">Belum ada anggaran untuk periode ini.</p>
                <p class="text-sm mt-1">Buat anggaran baru menggunakan form di samping.</p>
            </div>
            @endforelse
        </div>

        {{-- Add Budget Form --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm dark:bg-gray-800 dark:border-gray-700 h-fit">
            <h3 class="font-bold text-gray-900 dark:text-white mb-4">Tambah Anggaran Baru</h3>
            <form method="POST" action="{{ route('budgets.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Nama Anggaran *</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-corporate focus:border-corporate"
                        placeholder="Contoh: Anggaran Gaji Mei">
                    @error('nama') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Kategori</label>
                    <select name="category_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-corporate focus:border-corporate">
                        <option value="">— Pilih Kategori —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Jumlah Anggaran (Rp) *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-sm">Rp</span>
                        <input type="number" name="jumlah_anggaran" value="{{ old('jumlah_anggaran') }}" required min="1"
                            class="w-full border border-gray-300 rounded-lg pl-9 pr-3 py-2 text-sm focus:ring-2 focus:ring-corporate focus:border-corporate"
                            placeholder="0">
                    </div>
                    @error('jumlah_anggaran') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Bulan *</label>
                        <select name="bulan" class="w-full border border-gray-300 rounded-lg px-2 py-2 text-sm focus:ring-2 focus:ring-corporate focus:border-corporate">
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ (old('bulan', $bulan) == $m) ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Tahun *</label>
                        <select name="tahun" class="w-full border border-gray-300 rounded-lg px-2 py-2 text-sm focus:ring-2 focus:ring-corporate focus:border-corporate">
                            @for($y = now()->year; $y >= now()->year - 2; $y--)
                                <option value="{{ $y }}" {{ (old('tahun', $tahun) == $y) ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <button type="submit" class="w-full py-2.5 bg-corporate text-white font-semibold rounded-lg hover:bg-blue-800 transition text-sm shadow">
                    Simpan Anggaran
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
