<x-app-layout>
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Keuangan</h1>
            <p class="text-sm text-gray-500 mt-1">Selamat datang, <span class="font-semibold text-corporate">{{ Auth::user()->name }}</span>. Berikut ringkasan keuangan {{ now()->translatedFormat('F Y') }}.</p>
        </div>
        <a href="{{ route('transactions.create') }}"
           class="inline-flex items-center px-4 py-2 bg-corporate text-white font-semibold rounded-lg hover:bg-blue-800 transition shadow">
            <x-lucide-plus class="w-4 h-4 me-2" />
            Tambah Transaksi
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Saldo --}}
        <div class="p-6 bg-corporate rounded-xl shadow text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="p-2 bg-white/20 rounded-lg">
                    <x-lucide-wallet class="w-6 h-6" />
                </div>
                <span class="text-xs font-semibold uppercase tracking-wider text-blue-100">Saldo Bulan Ini</span>
            </div>
            <h3 class="text-2xl font-bold">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
            <p class="mt-1 text-sm text-blue-200">
                {{ $saldo >= 0 ? 'Surplus' : 'Defisit' }} periode ini
            </p>
        </div>

        {{-- Pemasukan --}}
        <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-3">
                <div class="p-2 bg-emerald-50 rounded-lg">
                    <x-lucide-trending-up class="w-6 h-6 text-emerald-500" />
                </div>
                <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Pemasukan</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
            <p class="mt-1 text-sm text-gray-500">{{ $jumlahPemasukan }} transaksi bulan ini</p>
        </div>

        {{-- Pengeluaran --}}
        <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-3">
                <div class="p-2 bg-rose-50 rounded-lg">
                    <x-lucide-trending-down class="w-6 h-6 text-rose-500" />
                </div>
                <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Pengeluaran</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
            <p class="mt-1 text-sm text-gray-500">{{ $jumlahPengeluaran }} transaksi bulan ini</p>
        </div>

        {{-- Anggaran --}}
        <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-3">
                <div class="p-2 bg-blue-50 rounded-lg">
                    <x-lucide-pie-chart class="w-6 h-6 text-primary-700" />
                </div>
                <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Anggaran Aktif</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $anggaran->count() }}</h3>
            <p class="mt-1 text-sm text-gray-500">item anggaran bulan ini</p>
        </div>
    </div>

    {{-- Chart & Table --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        {{-- Chart --}}
        <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl shadow-sm p-6 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Tren Keuangan (6 Bulan Terakhir)</h3>
                <div class="flex items-center gap-4 text-xs text-gray-500">
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span> Pemasukan</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-rose-500 inline-block"></span> Pengeluaran</span>
                </div>
            </div>
            <canvas id="financeChart" height="120"></canvas>
        </div>

        {{-- Budget Progress --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Status Anggaran</h3>
                <a href="{{ route('budgets.index') }}" class="text-xs text-corporate hover:underline">Kelola</a>
            </div>
            @forelse($anggaran as $budget)
                @php $persen = $budget->persentase; @endphp
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700 dark:text-gray-300 font-medium">{{ $budget->nama }}</span>
                        <span class="text-gray-500 text-xs">{{ $persen }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                        <div class="h-2 rounded-full transition-all duration-500 {{ $persen >= 90 ? 'bg-rose-500' : ($persen >= 70 ? 'bg-amber-400' : 'bg-emerald-500') }}"
                             style="width: {{ $persen }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-400 mt-0.5">
                        <span>Rp {{ number_format($budget->realisasi, 0, ',', '.') }}</span>
                        <span>/ Rp {{ number_format($budget->jumlah_anggaran, 0, ',', '.') }}</span>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 text-sm py-8">
                    <x-lucide-pie-chart class="w-10 h-10 mx-auto mb-2 opacity-30" />
                    Belum ada anggaran bulan ini.
                    <a href="{{ route('budgets.index') }}" class="block mt-1 text-corporate hover:underline text-xs">Tambah Anggaran</a>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Transaksi Terakhir</h3>
            <a href="{{ route('transactions.index') }}" class="text-sm font-medium text-corporate hover:underline flex items-center">
                Lihat Semua <x-lucide-arrow-right class="w-4 h-4 ms-1" />
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs uppercase bg-gray-50 text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Jenis</th>
                        <th class="px-6 py-3 text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($transaksiTerakhir as $trx)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">
                            {{ $trx->tanggal->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white font-medium">{{ $trx->deskripsi }}</td>
                        <td class="px-6 py-4">
                            <span class="text-xs px-2 py-1 rounded-full font-medium text-gray-600 bg-gray-100">
                                {{ $trx->category?->nama ?? '—' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($trx->jenis === 'pemasukan')
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Pemasukan</span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">Pengeluaran</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right font-bold {{ $trx->jenis === 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $trx->jenis === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                            <x-lucide-inbox class="w-10 h-10 mx-auto mb-2 opacity-30" />
                            Belum ada transaksi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('financeChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: @json($chartPemasukan),
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderRadius: 6,
                    },
                    {
                        label: 'Pengeluaran',
                        data: @json($chartPengeluaran),
                        backgroundColor: 'rgba(244, 63, 94, 0.7)',
                        borderRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        ticks: {
                            callback: (value) => 'Rp ' + Intl.NumberFormat('id-ID').format(value)
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>