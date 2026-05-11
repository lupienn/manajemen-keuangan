<x-app-layout>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Anggaran</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola anggaran bulanan untuk memantau pengeluaran.</p>
        </div>

        {{-- Month filter --}}
        <form method="GET" action="{{ route('budgets.index') }}" class="flex gap-2 items-center bg-slate-900 p-2 rounded-xl border border-slate-800">
            <select name="bulan" class="text-xs border-0 bg-slate-800 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-blue-500 font-bold">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                @endfor
            </select>
            <select name="tahun" class="text-xs border-0 bg-slate-800 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-blue-500 font-bold">
                @for($y = now()->year; $y >= now()->year - 2; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-500 transition">
                <x-lucide-search class="w-4 h-4" />
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Budget List --}}
        <div class="lg:col-span-2 space-y-4">
            @forelse($budgets as $budget)
            @php $persen = $budget->persentase; @endphp
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <h3 class="font-black text-white tracking-tight">{{ $budget->nama }}</h3>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">{{ $budget->category?->nama ?? 'Tanpa Kategori' }}</span>
                    </div>
                    <div class="flex gap-1.5 items-center">
                        <span class="text-sm font-black {{ $persen >= 90 ? 'text-rose-400' : ($persen >= 70 ? 'text-amber-400' : 'text-emerald-400') }}">
                            {{ $persen }}%
                        </span>
                        <form method="POST" action="{{ route('budgets.destroy', $budget) }}"
                              onsubmit="return confirm('Hapus anggaran ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 text-slate-600 hover:text-rose-400 transition" title="Hapus">
                                <x-lucide-trash-2 class="w-4 h-4" />
                            </button>
                        </form>
                    </div>
                </div>

                <div class="w-full bg-slate-800 rounded-full h-2 mb-4 overflow-hidden">
                    <div class="h-2 rounded-full transition-all duration-1000 {{ $persen >= 90 ? 'bg-rose-500' : ($persen >= 70 ? 'bg-amber-500' : 'bg-emerald-500') }}"
                         style="width: {{ $persen }}%"></div>
                </div>

                <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-slate-500">
                    <span>Terpakai: <span class="text-white">Rp {{ number_format($budget->realisasi, 0, ',', '.') }}</span></span>
                    <span>Anggaran: <span class="text-white">Rp {{ number_format($budget->jumlah_anggaran, 0, ',', '.') }}</span></span>
                </div>

                @if($persen >= 90)
                    <div class="mt-4 flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-rose-400 bg-rose-500/10 border border-rose-500/20 rounded-xl px-4 py-2">
                        <x-lucide-alert-circle class="w-4 h-4 flex-shrink-0" />
                        Anggaran hampir habis. Sisa: Rp {{ number_format($budget->jumlah_anggaran - $budget->realisasi, 0, ',', '.') }}
                    </div>
                @endif
            </div>
            @empty
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-16 text-center shadow-xl">
                <x-lucide-pie-chart class="w-16 h-16 mx-auto mb-6 text-slate-800" />
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Belum ada anggaran untuk periode ini.</p>
                <p class="text-[10px] font-bold text-blue-400 uppercase mt-2 tracking-widest">Buat anggaran baru menggunakan form di samping.</p>
            </div>
            @endforelse
        </div>

        {{-- Add Budget Form --}}
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-2xl h-fit">
            <h3 class="text-lg font-black text-white tracking-tight mb-6">Tambah Anggaran Baru</h3>
            <form method="POST" action="{{ route('budgets.store') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Nama Anggaran *</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required
                        class="w-full border-0 bg-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 placeholder-slate-600 font-bold"
                        placeholder="Contoh: Anggaran Gaji Mei">
                    @error('nama') <p class="text-[10px] font-bold text-rose-500 mt-2 uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Kategori</label>
                    <select name="category_id" class="w-full border-0 bg-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 font-bold">
                        <option value="">— Pilih Kategori —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Jumlah Anggaran (Rp) *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-4 flex items-center text-slate-500 text-sm font-bold">Rp</span>
                        <input type="number" name="jumlah_anggaran" value="{{ old('jumlah_anggaran') }}" required min="1"
                            class="w-full border-0 bg-slate-800 rounded-xl pl-11 pr-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 placeholder-slate-600 font-bold"
                            placeholder="0">
                    </div>
                    @error('jumlah_anggaran') <p class="text-[10px] font-bold text-rose-500 mt-2 uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Bulan *</label>
                        <select name="bulan" class="w-full border-0 bg-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 font-bold">
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ (old('bulan', $bulan) == $m) ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Tahun *</label>
                        <select name="tahun" class="w-full border-0 bg-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 font-bold">
                            @for($y = now()->year; $y >= now()->year - 2; $y--)
                                <option value="{{ $y }}" {{ (old('tahun', $tahun) == $y) ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <button type="submit" class="w-full py-4 bg-blue-600 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-blue-500 transition shadow-xl shadow-blue-900/20">
                    Simpan Anggaran
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
