<x-app-layout>
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan Keuangan</h1>
            <p class="text-sm text-gray-500 mt-1">Ringkasan keuangan periode {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}</p>
        </div>
        <div class="flex gap-2">
            <form method="GET" action="{{ route('reports.index') }}" class="flex gap-2 items-center">
                <select name="bulan" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-corporate focus:border-corporate">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                    @endfor
                </select>
                <select name="tahun" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-corporate focus:border-corporate">
                    @for($y = now()->year; $y >= now()->year - 3; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <button type="submit" class="px-3 py-2 bg-corporate text-white text-sm rounded-lg hover:bg-blue-800 transition">Tampilkan</button>
            </form>
            <a href="{{ route('reports.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
               class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-lg hover:bg-emerald-700 transition shadow">
                <x-lucide-download class="w-4 h-4 me-1.5" /> Unduh PDF
            </a>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Total Pemasukan</p>
            <p class="text-2xl font-bold text-emerald-600">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $pemasukan->count() }} transaksi</p>
        </div>
        <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Total Pengeluaran</p>
            <p class="text-2xl font-bold text-rose-600">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $pengeluaran->count() }} transaksi</p>
        </div>
        <div class="p-5 {{ $saldo >= 0 ? 'bg-corporate' : 'bg-rose-600' }} rounded-xl shadow text-white">
            <p class="text-xs text-blue-100 uppercase tracking-wider mb-1">Selisih / Saldo</p>
            <p class="text-2xl font-bold">Rp {{ number_format(abs($saldo), 0, ',', '.') }}</p>
            <p class="text-xs text-blue-200 mt-1">{{ $saldo >= 0 ? '✅ Surplus' : '⚠️ Defisit' }}</p>
        </div>
    </div>

    {{-- By Category Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Income by Category --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 dark:bg-gray-800 dark:border-gray-700">
            <h3 class="font-bold text-gray-900 dark:text-white mb-4 text-sm">Pemasukan per Kategori</h3>
            @forelse($pemasukanByCategory as $item)
                @php $persen = $totalPemasukan > 0 ? round(($item->total / $totalPemasukan) * 100, 1) : 0; @endphp
                <div class="mb-3">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700 dark:text-gray-300">{{ $item->category?->nama ?? 'Lainnya' }}</span>
                        <span class="text-gray-500 text-xs">{{ $persen }}% &middot; Rp {{ number_format($item->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $persen }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-400 py-4 text-center">Tidak ada data pemasukan.</p>
            @endforelse
        </div>

        {{-- Expense by Category --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 dark:bg-gray-800 dark:border-gray-700">
            <h3 class="font-bold text-gray-900 dark:text-white mb-4 text-sm">Pengeluaran per Kategori</h3>
            @forelse($pengeluaranByCategory as $item)
                @php $persen = $totalPengeluaran > 0 ? round(($item->total / $totalPengeluaran) * 100, 1) : 0; @endphp
                <div class="mb-3">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700 dark:text-gray-300">{{ $item->category?->nama ?? 'Lainnya' }}</span>
                        <span class="text-gray-500 text-xs">{{ $persen }}% &middot; Rp {{ number_format($item->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="h-2 rounded-full bg-rose-500" style="width: {{ $persen }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-400 py-4 text-center">Tidak ada data pengeluaran.</p>
            @endforelse
        </div>
    </div>

    {{-- Full Transaction Tables --}}
    <div class="space-y-6">
        {{-- Pemasukan --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 bg-emerald-50 dark:bg-emerald-900/20 dark:border-gray-700">
                <h3 class="font-bold text-emerald-700 flex items-center gap-2">
                    <x-lucide-trending-up class="w-5 h-5" /> Rincian Pemasukan
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs uppercase bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-5 py-3">Tanggal</th>
                            <th class="px-5 py-3">Deskripsi</th>
                            <th class="px-5 py-3">Kategori</th>
                            <th class="px-5 py-3 text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($pemasukan as $trx)
                        <tr>
                            <td class="px-5 py-3 whitespace-nowrap text-xs">{{ $trx->tanggal->translatedFormat('d M Y') }}</td>
                            <td class="px-5 py-3 text-gray-900 font-medium">{{ $trx->deskripsi }}</td>
                            <td class="px-5 py-3 text-xs text-gray-500">{{ $trx->category?->nama ?? '—' }}</td>
                            <td class="px-5 py-3 text-right font-bold text-emerald-600">+ Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-5 py-8 text-center text-gray-400">Tidak ada data pemasukan.</td></tr>
                        @endforelse
                    </tbody>
                    @if($pemasukan->count() > 0)
                    <tfoot class="bg-emerald-50">
                        <tr>
                            <td colspan="3" class="px-5 py-3 font-bold text-gray-700">Total Pemasukan</td>
                            <td class="px-5 py-3 text-right font-bold text-emerald-700">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>

        {{-- Pengeluaran --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 bg-rose-50 dark:bg-rose-900/20 dark:border-gray-700">
                <h3 class="font-bold text-rose-700 flex items-center gap-2">
                    <x-lucide-trending-down class="w-5 h-5" /> Rincian Pengeluaran
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs uppercase bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-5 py-3">Tanggal</th>
                            <th class="px-5 py-3">Deskripsi</th>
                            <th class="px-5 py-3">Kategori</th>
                            <th class="px-5 py-3 text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($pengeluaran as $trx)
                        <tr>
                            <td class="px-5 py-3 whitespace-nowrap text-xs">{{ $trx->tanggal->translatedFormat('d M Y') }}</td>
                            <td class="px-5 py-3 text-gray-900 font-medium">{{ $trx->deskripsi }}</td>
                            <td class="px-5 py-3 text-xs text-gray-500">{{ $trx->category?->nama ?? '—' }}</td>
                            <td class="px-5 py-3 text-right font-bold text-rose-600">- Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-5 py-8 text-center text-gray-400">Tidak ada data pengeluaran.</td></tr>
                        @endforelse
                    </tbody>
                    @if($pengeluaran->count() > 0)
                    <tfoot class="bg-rose-50">
                        <tr>
                            <td colspan="3" class="px-5 py-3 font-bold text-gray-700">Total Pengeluaran</td>
                            <td class="px-5 py-3 text-right font-bold text-rose-700">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
