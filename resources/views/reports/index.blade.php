<x-app-layout>
    {{-- Header Laporan --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <div class="flex items-center gap-2 text-blue-400 font-bold text-xs uppercase tracking-widest mb-1">
                <x-lucide-file-bar-chart class="w-4 h-4" />
                Laporan Keuangan
            </div>
            <h1 class="text-3xl font-black text-white tracking-tight">Analisis Bulanan</h1>
            <p class="text-sm text-slate-400 mt-1">Periode: <span class="text-blue-400 font-bold">{{ \Carbon\Carbon::createFromDate(null, (int)$bulan, 1)->translatedFormat('F') }} {{ $tahun }}</span></p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3 bg-slate-900 p-2 rounded-2xl border border-slate-800">
            <form method="GET" action="{{ route('reports.index') }}" class="flex gap-2 items-center">
                <select name="bulan" class="text-xs border-0 bg-slate-800 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 font-bold">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                    @endfor
                </select>
                <select name="tahun" class="text-xs border-0 bg-slate-800 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 font-bold">
                    @for($y = now()->year; $y >= now()->year - 3; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <button type="submit" class="p-2 bg-blue-600 text-white rounded-xl hover:bg-blue-500 transition">
                    <x-lucide-search class="w-4 h-4" />
                </button>
            </form>
            <div class="w-px h-6 bg-slate-800 mx-1"></div>
            <a href="{{ route('reports.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
               class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-500 transition">
                <x-lucide-download class="w-4 h-4 me-2" /> Export PDF
            </a>
        </div>
    </div>

    {{-- Ringkasan Angka --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="p-7 bg-slate-900 border border-slate-800 rounded-3xl shadow-xl">
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Inflow</p>
            <p class="text-2xl font-black text-emerald-400">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
        </div>
        
        <div class="p-7 bg-slate-900 border border-slate-800 rounded-3xl shadow-xl">
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Outflow</p>
            <p class="text-2xl font-black text-rose-400">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        </div>

        <div class="p-7 bg-blue-600 rounded-3xl shadow-xl shadow-blue-900/20">
            <p class="text-[10px] font-black text-blue-200 uppercase tracking-widest mb-2">Net Balance</p>
            <p class="text-2xl font-black text-white">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Detail Table - DARK THEME --}}
    <div class="space-y-8">
        <div class="bg-slate-900 border border-slate-800 rounded-3xl shadow-2xl overflow-hidden" x-data="{ open: true }">
            <div class="px-8 py-6 flex items-center justify-between bg-slate-900 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-emerald-500/10 text-emerald-400 rounded-xl">
                        <x-lucide-arrow-down-left class="w-5 h-5" />
                    </div>
                    <h3 class="font-black text-white tracking-tight">Rincian Pemasukan</h3>
                </div>
                <button @click="open = !open" class="text-slate-500 hover:text-slate-300">
                    <x-lucide-chevron-down class="w-5 h-5 transform transition-transform duration-300" x-bind:class="open ? 'rotate-180' : ''" />
                </button>
            </div>
            <div x-show="open" x-collapse>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left bg-slate-900">
                        <thead class="text-[10px] font-black uppercase tracking-widest text-slate-500 border-b border-slate-800 bg-slate-950/30">
                            <tr>
                                <th class="px-8 py-4">Waktu</th>
                                <th class="px-8 py-4">Deskripsi</th>
                                <th class="px-8 py-4">Kategori</th>
                                <th class="px-8 py-4 text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($pemasukan as $trx)
                            <tr class="hover:bg-slate-800/50 transition-colors">
                                <td class="px-8 py-5 text-xs font-bold text-slate-500">{{ $trx->tanggal->format('d/m/Y') }}</td>
                                <td class="px-8 py-5 font-bold text-white">{{ $trx->deskripsi }}</td>
                                <td class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-tighter">{{ $trx->category?->nama ?? '—' }}</td>
                                <td class="px-8 py-5 text-right font-black text-emerald-400">+ Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-8 py-12 text-center text-slate-400 font-bold uppercase text-[10px]">Data Kosong</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="bg-slate-900 border border-slate-800 rounded-3xl shadow-2xl overflow-hidden" x-data="{ open: true }">
            <div class="px-8 py-6 flex items-center justify-between bg-slate-900 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-rose-500/10 text-rose-400 rounded-xl">
                        <x-lucide-arrow-up-right class="w-5 h-5" />
                    </div>
                    <h3 class="font-black text-white tracking-tight">Rincian Pengeluaran</h3>
                </div>
                <button @click="open = !open" class="text-slate-500 hover:text-slate-300">
                    <x-lucide-chevron-down class="w-5 h-5 transform transition-transform duration-300" x-bind:class="open ? 'rotate-180' : ''" />
                </button>
            </div>
            <div x-show="open" x-collapse>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left bg-slate-900">
                        <thead class="text-[10px] font-black uppercase tracking-widest text-slate-500 border-b border-slate-800 bg-slate-950/30">
                            <tr>
                                <th class="px-8 py-4">Waktu</th>
                                <th class="px-8 py-4">Deskripsi</th>
                                <th class="px-8 py-4">Kategori</th>
                                <th class="px-8 py-4 text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($pengeluaran as $trx)
                            <tr class="hover:bg-slate-800/50 transition-colors">
                                <td class="px-8 py-5 text-xs font-bold text-slate-500">{{ $trx->tanggal->format('d/m/Y') }}</td>
                                <td class="px-8 py-5 font-bold text-white">{{ $trx->deskripsi }}</td>
                                <td class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-tighter">{{ $trx->category?->nama ?? '—' }}</td>
                                <td class="px-8 py-5 text-right font-black text-rose-400">- Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-8 py-12 text-center text-slate-400 font-bold uppercase text-[10px]">Data Kosong</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
