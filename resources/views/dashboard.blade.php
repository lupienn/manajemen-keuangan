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
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
        {{-- Saldo --}}
        <div class="p-6 bg-gradient-to-br from-corporate to-blue-700 rounded-2xl shadow-lg text-white transform transition-all duration-500 hover:scale-[1.03] hover:shadow-2xl"
             x-show="loaded" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2.5 bg-white/20 backdrop-blur-md rounded-xl">
                    <x-lucide-wallet class="w-6 h-6 text-white" />
                </div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-blue-100/80">Saldo Utama</span>
            </div>
            <div class="space-y-1">
                <h3 class="text-2xl font-black tracking-tight">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                <div class="flex items-center gap-1.5 text-xs text-blue-200">
                    <div class="w-1.5 h-1.5 rounded-full {{ $saldo >= 0 ? 'bg-emerald-400' : 'bg-rose-400 animate-pulse' }}"></div>
                    {{ $saldo >= 0 ? 'Status Surplus' : 'Status Defisit' }}
                </div>
            </div>
        </div>

        {{-- Pemasukan --}}
        <div class="p-6 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm transform transition-all duration-500 hover:scale-[1.03] hover:shadow-xl group"
             x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-100" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2.5 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl group-hover:bg-emerald-100 transition-colors">
                    <x-lucide-trending-up class="w-6 h-6 text-emerald-500" />
                </div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Total Pemasukan</span>
            </div>
            <div class="space-y-1">
                <h3 class="text-2xl font-black tracking-tight text-gray-900 dark:text-white">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
                <p class="text-xs text-gray-500 font-medium">{{ $jumlahPemasukan }} Transaksi Terdata</p>
            </div>
        </div>

        {{-- Pengeluaran --}}
        <div class="p-6 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm transform transition-all duration-500 hover:scale-[1.03] hover:shadow-xl group"
             x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2.5 bg-rose-50 dark:bg-rose-900/20 rounded-xl group-hover:bg-rose-100 transition-colors">
                    <x-lucide-trending-down class="w-6 h-6 text-rose-500" />
                </div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Total Pengeluaran</span>
            </div>
            <div class="space-y-1">
                <h3 class="text-2xl font-black tracking-tight text-gray-900 dark:text-white">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
                <p class="text-xs text-gray-500 font-medium">{{ $jumlahPengeluaran }} Transaksi Terdata</p>
            </div>
        </div>

        {{-- Anggaran --}}
        <div class="p-6 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm transform transition-all duration-500 hover:scale-[1.03] hover:shadow-xl group"
             x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2.5 bg-blue-50 dark:bg-blue-900/20 rounded-xl group-hover:bg-blue-100 transition-colors">
                    <x-lucide-pie-chart class="w-6 h-6 text-corporate dark:text-blue-400" />
                </div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Anggaran Aktif</span>
            </div>
            <div class="space-y-1">
                <h3 class="text-2xl font-black tracking-tight text-gray-900 dark:text-white">{{ $anggaran->count() }}</h3>
                <p class="text-xs text-gray-500 font-medium">Item Perencanaan</p>
            </div>
        </div>
    </div>

    {{-- Chart & Table --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 400)">
        {{-- Chart --}}
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm p-8 transition-all duration-700"
             x-show="loaded" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-black text-gray-900 dark:text-white tracking-tight">Analisis Keuangan</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Tren pemasukan & pengeluaran 6 bulan terakhir</p>
                </div>
                <div class="flex items-center gap-4 bg-gray-50 dark:bg-gray-900/50 p-2 rounded-xl border border-gray-100 dark:border-gray-700">
                    <span class="flex items-center gap-2 text-[10px] font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span> In
                    </span>
                    <span class="flex items-center gap-2 text-[10px] font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">
                        <span class="w-2 h-2 rounded-full bg-rose-500 shadow-[0_0_8px_rgba(244,63,94,0.5)]"></span> Out
                    </span>
                </div>
            </div>
            <div class="h-[300px]">
                <canvas id="financeChart"></canvas>
            </div>
        </div>

        {{-- Budget Progress --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm p-8 transition-all duration-700 delay-100"
             x-show="loaded" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-black text-gray-900 dark:text-white tracking-tight">Monitor Anggaran</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Pantau realisasi setiap pos</p>
                </div>
                <a href="{{ route('budgets.index') }}" class="p-2 bg-blue-50 text-corporate rounded-xl hover:bg-corporate hover:text-white transition-all duration-300">
                    <x-lucide-external-link class="w-4 h-4" />
                </a>
            </div>
            <div class="space-y-6">
                @forelse($anggaran as $budget)
                    @php $persen = $budget->persentase; @endphp
                    <div class="group">
                        <div class="flex justify-between items-end mb-2">
                            <div>
                                <span class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-corporate transition-colors">{{ $budget->nama }}</span>
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">{{ $budget->category?->nama }}</p>
                            </div>
                            <span class="text-xs font-black {{ $persen >= 90 ? 'text-rose-600' : ($persen >= 70 ? 'text-amber-500' : 'text-emerald-600') }}">{{ $persen }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden">
                            <div class="h-2.5 rounded-full transition-all duration-1000 ease-out {{ $persen >= 90 ? 'bg-gradient-to-r from-rose-500 to-rose-400' : ($persen >= 70 ? 'bg-gradient-to-r from-amber-500 to-amber-400' : 'bg-gradient-to-r from-emerald-500 to-emerald-400') }}"
                                 style="width: 0%;" x-init="setTimeout(() => $el.style.width = '{{ $persen }}%', 800)"></div>
                        </div>
                        <div class="flex justify-between text-[10px] font-bold text-gray-400 mt-1.5 uppercase tracking-tighter">
                            <span>Rp {{ number_format($budget->realisasi, 0, ',', '.') }}</span>
                            <span>Limit Rp {{ number_format($budget->jumlah_anggaran, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                        <x-lucide-pie-chart class="w-12 h-12 mx-auto mb-3 text-gray-300 opacity-50" />
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">Belum Ada Anggaran</p>
                        <a href="{{ route('budgets.index') }}" class="inline-block mt-4 px-4 py-2 bg-corporate text-white text-[10px] font-black uppercase tracking-widest rounded-lg hover:bg-blue-800 transition shadow-md">Buat Sekarang</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden transition-all duration-700 delay-200"
         x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 600)"
         x-show="loaded" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="flex items-center justify-between p-8 border-b border-gray-50 dark:border-gray-700">
            <div>
                <h3 class="text-lg font-black text-gray-900 dark:text-white tracking-tight">Riwayat Aktivitas</h3>
                <p class="text-xs text-gray-500 mt-0.5">Arsip transaksi terbaru Anda</p>
            </div>
            <a href="{{ route('transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-xs font-black uppercase tracking-widest rounded-xl hover:bg-corporate hover:text-white transition-all duration-300">
                Data Lengkap <x-lucide-arrow-right class="w-4 h-4 ms-2" />
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-[10px] font-black uppercase tracking-widest bg-gray-50/50 dark:bg-gray-900/50 text-gray-400 dark:text-gray-500">
                    <tr>
                        <th class="px-8 py-5">Identitas Waktu</th>
                        <th class="px-8 py-5">Deskripsi Transaksi</th>
                        <th class="px-8 py-5">Kategori</th>
                        <th class="px-8 py-5">Sifat</th>
                        <th class="px-8 py-5 text-right">Valuasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                    @forelse($transaksiTerakhir as $trx)
                    <tr class="hover:bg-blue-50/30 dark:hover:bg-blue-900/10 transition-colors group">
                        <td class="px-8 py-5 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-[10px] font-black text-gray-500">
                                    {{ $trx->tanggal->format('d') }}
                                </div>
                                <div class="text-xs font-bold text-gray-600 dark:text-gray-400">
                                    {{ $trx->tanggal->translatedFormat('M Y') }}
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-corporate transition-colors">{{ $trx->deskripsi }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-[10px] px-3 py-1.5 rounded-lg font-black uppercase tracking-widest text-gray-500 bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                {{ $trx->category?->nama ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            @if($trx->jenis === 'pemasukan')
                                <div class="flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-black text-[10px] uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Inflow
                                </div>
                            @else
                                <div class="flex items-center gap-2 text-rose-600 dark:text-rose-400 font-black text-[10px] uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Outflow
                                </div>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-right">
                            <span class="text-sm font-black {{ $trx->jenis === 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $trx->jenis === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-16 text-center">
                            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-2xl p-8 border border-dashed border-gray-200 dark:border-gray-700">
                                <x-lucide-inbox class="w-12 h-12 mx-auto mb-3 text-gray-300 opacity-50" />
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">Belum Ada Aktivitas Terdeteksi</p>
                            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('financeChart').getContext('2d');
        
        // Custom Gradient for Chart
        const incomeGradient = ctx.createLinearGradient(0, 0, 0, 400);
        incomeGradient.addColorStop(0, 'rgba(16, 185, 129, 0.6)');
        incomeGradient.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

        const expenseGradient = ctx.createLinearGradient(0, 0, 0, 400);
        expenseGradient.addColorStop(0, 'rgba(244, 63, 94, 0.6)');
        expenseGradient.addColorStop(1, 'rgba(244, 63, 94, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: @json($chartPemasukan),
                        borderColor: '#10b981',
                        backgroundColor: incomeGradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#10b981',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Pengeluaran',
                        data: @json($chartPengeluaran),
                        borderColor: '#f43f5e',
                        backgroundColor: expenseGradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#f43f5e',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e3a8a',
                        titleFont: { size: 12, weight: 'bold' },
                        bodyFont: { size: 11 },
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false,
                        },
                        ticks: {
                            font: { size: 10, weight: 'bold' },
                            color: '#94a3b8',
                            callback: (value) => 'Rp ' + Intl.NumberFormat('id-ID').format(value / 1000) + 'k'
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 10, weight: 'bold' },
                            color: '#94a3b8'
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>