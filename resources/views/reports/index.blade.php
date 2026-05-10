<x-app-layout>
    {{-- Header Laporan --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <div class="flex items-center gap-2 text-corporate font-bold text-xs uppercase tracking-widest mb-1">
                <x-lucide-file-text class="w-4 h-4" />
                Laporan Keuangan
            </div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Analisis Bulanan</h1>
            <p class="text-sm text-slate-500 mt-1">Periode: <span class="text-corporate font-bold">{{ \Carbon\Carbon::createFromDate(null, (int)$bulan, 1)->translatedFormat('F') }} {{ $tahun }}</span></p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3 bg-white p-2 rounded-2xl shadow-sm border border-slate-100">
            <form method="GET" action="{{ route('reports.index') }}" class="flex gap-2 items-center">
                <select name="bulan" class="text-sm border-0 bg-slate-50 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-corporate font-bold text-slate-700">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                    @endfor
                </select>
                <select name="tahun" class="text-sm border-0 bg-slate-50 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-corporate font-bold text-slate-700">
                    @for($y = now()->year; $y >= now()->year - 3; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <button type="submit" class="p-2.5 bg-slate-900 text-white rounded-xl hover:bg-slate-800 transition shadow-lg shadow-slate-200">
                    <x-lucide-search class="w-5 h-5" />
                </button>
            </form>
            <div class="w-px h-8 bg-slate-100 mx-1"></div>
            <a href="{{ route('reports.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
               class="inline-flex items-center px-5 py-2.5 bg-emerald-600 text-white text-sm font-black uppercase tracking-widest rounded-xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
                <x-lucide-download class="w-4 h-4 me-2" /> Export PDF
            </a>
        </div>
    </div>

    {{-- Ringkasan Angka --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="p-7 bg-white border border-slate-100 rounded-3xl shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:scale-110 transition-transform duration-500">
                <x-lucide-trending-up class="w-24 h-24 text-emerald-600" />
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Inflow</p>
            <p class="text-3xl font-black text-emerald-600">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
            <div class="mt-4 flex items-center gap-2">
                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[10px] font-bold rounded-full">{{ $pemasukan->count() }} Transaksi</span>
            </div>
        </div>
        
        <div class="p-7 bg-white border border-slate-100 rounded-3xl shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:scale-110 transition-transform duration-500">
                <x-lucide-trending-down class="w-24 h-24 text-rose-600" />
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Outflow</p>
            <p class="text-3xl font-black text-rose-600">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
            <div class="mt-4 flex items-center gap-2">
                <span class="px-2 py-0.5 bg-rose-50 text-rose-600 text-[10px] font-bold rounded-full">{{ $pengeluaran->count() }} Transaksi</span>
            </div>
        </div>

        <div class="p-7 bg-slate-900 rounded-3xl shadow-xl shadow-slate-200 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:scale-110 transition-transform duration-500">
                <x-lucide-wallet class="w-24 h-24 text-white" />
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Net Balance</p>
            <p class="text-3xl font-black text-white">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
            <div class="mt-4 flex items-center gap-2">
                <span class="px-2 py-0.5 {{ $saldo >= 0 ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400' }} text-[10px] font-bold rounded-full">
                    {{ $saldo >= 0 ? 'Surplus Aktif' : 'Defisit Anggaran' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Detail Table --}}
    <div class="space-y-8">
        {{-- Pemasukan Table --}}
        <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden" x-data="{ open: true }">
            <div class="px-8 py-6 flex items-center justify-between bg-slate-50/50 border-b border-slate-50">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-emerald-100 text-emerald-600 rounded-xl">
                        <x-lucide-arrow-down-left class="w-5 h-5" />
                    </div>
                    <h3 class="font-black text-slate-900 tracking-tight">Rincian Pemasukan</h3>
                </div>
                <button @click="open = !open" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <x-lucide-chevron-down class="w-5 h-5 transform transition-transform duration-300" x-bind:class="open ? 'rotate-180' : ''" />
                </button>
            </div>
            <div x-show="open" x-collapse>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50">
                            <tr>
                                <th class="px-8 py-4">Waktu</th>
                                <th class="px-8 py-4">Deskripsi</th>
                                <th class="px-8 py-4">Kategori</th>
                                <th class="px-8 py-4 text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($pemasukan as $trx)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-8 py-5 text-xs font-bold text-slate-500">{{ $trx->tanggal->format('d/m/Y') }}</td>
                                <td class="px-8 py-5 font-bold text-slate-900">{{ $trx->deskripsi }}</td>
                                <td class="px-8 py-5">
                                    <span class="text-[10px] font-black uppercase tracking-tighter text-slate-400 bg-slate-100 px-2 py-1 rounded-md">{{ $trx->category?->nama ?? '—' }}</span>
                                </td>
                                <td class="px-8 py-5 text-right font-black text-emerald-600">+ Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-8 py-12 text-center text-slate-400 font-bold uppercase text-[10px] tracking-widest">Data Kosong</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-8 py-5 bg-emerald-50/30 border-t border-emerald-50 flex justify-between items-center">
                    <span class="text-xs font-black text-emerald-800 uppercase tracking-widest">Total Pemasukan Periode Ini</span>
                    <span class="text-lg font-black text-emerald-700">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- Pengeluaran Table --}}
        <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden" x-data="{ open: true }">
            <div class="px-8 py-6 flex items-center justify-between bg-slate-50/50 border-b border-slate-50">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-rose-100 text-rose-600 rounded-xl">
                        <x-lucide-arrow-up-right class="w-5 h-5" />
                    </div>
                    <h3 class="font-black text-slate-900 tracking-tight">Rincian Pengeluaran</h3>
                </div>
                <button @click="open = !open" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <x-lucide-chevron-down class="w-5 h-5 transform transition-transform duration-300" x-bind:class="open ? 'rotate-180' : ''" />
                </button>
            </div>
            <div x-show="open" x-collapse>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50">
                            <tr>
                                <th class="px-8 py-4">Waktu</th>
                                <th class="px-8 py-4">Deskripsi</th>
                                <th class="px-8 py-4">Kategori</th>
                                <th class="px-8 py-4 text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($pengeluaran as $trx)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-8 py-5 text-xs font-bold text-slate-500">{{ $trx->tanggal->format('d/m/Y') }}</td>
                                <td class="px-8 py-5 font-bold text-slate-900">{{ $trx->deskripsi }}</td>
                                <td class="px-8 py-5">
                                    <span class="text-[10px] font-black uppercase tracking-tighter text-slate-400 bg-slate-100 px-2 py-1 rounded-md">{{ $trx->category?->nama ?? '—' }}</span>
                                </td>
                                <td class="px-8 py-5 text-right font-black text-rose-600">- Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-8 py-12 text-center text-slate-400 font-bold uppercase text-[10px] tracking-widest">Data Kosong</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-8 py-5 bg-rose-50/30 border-t border-rose-50 flex justify-between items-center">
                    <span class="text-xs font-black text-rose-800 uppercase tracking-widest">Total Pengeluaran Periode Ini</span>
                    <span class="text-lg font-black text-rose-700">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
