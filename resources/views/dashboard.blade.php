<x-app-layout>
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight">Dashboard Keuangan</h1>
            <p class="text-sm text-slate-400 mt-1 font-medium">Selamat datang, <span class="text-blue-400 font-bold">{{ Auth::user()->name }}</span> (<span class="text-slate-500">@</span>{{ Auth::user()->username }}). Berikut ringkasan bulan ini.</p>
        </div>
        <a href="{{ route('transactions.create') }}"
           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-sm font-black uppercase tracking-widest rounded-xl hover:bg-blue-500 transition shadow-lg shadow-blue-900/20">
            <x-lucide-plus class="w-4 h-4 me-2" />
            Tambah Data
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Saldo --}}
        <div class="p-7 bg-slate-900 border border-slate-800 rounded-3xl shadow-xl transition-all duration-300 hover:border-blue-500/50">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-500/10 text-blue-400 rounded-2xl">
                    <x-lucide-wallet class="w-6 h-6" />
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Saldo</span>
            </div>
            <h3 class="text-2xl font-black text-white tracking-tight">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
            <p class="text-[10px] font-bold text-blue-400 uppercase mt-1 tracking-widest">{{ $saldo >= 0 ? 'Surplus Aktif' : 'Defisit Anggaran' }}</p>
        </div>

        {{-- Pemasukan --}}
        <div class="p-7 bg-slate-900 border border-slate-800 rounded-3xl shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-500/10 text-emerald-400 rounded-2xl">
                    <x-lucide-trending-up class="w-6 h-6" />
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Inflow</span>
            </div>
            <h3 class="text-2xl font-black text-white tracking-tight">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
            <p class="text-[10px] font-bold text-slate-500 uppercase mt-1 tracking-widest">{{ $jumlahPemasukan }} Transaksi</p>
        </div>

        {{-- Pengeluaran --}}
        <div class="p-7 bg-slate-900 border border-slate-800 rounded-3xl shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-rose-500/10 text-rose-400 rounded-2xl">
                    <x-lucide-trending-down class="w-6 h-6" />
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Outflow</span>
            </div>
            <h3 class="text-2xl font-black text-white tracking-tight">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
            <p class="text-[10px] font-bold text-slate-500 uppercase mt-1 tracking-widest">{{ $jumlahPengeluaran }} Transaksi</p>
        </div>

        {{-- Anggaran --}}
        <div class="p-7 bg-slate-900 border border-slate-800 rounded-3xl shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-slate-800 text-slate-400 rounded-2xl">
                    <x-lucide-pie-chart class="w-6 h-6" />
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Budget</span>
            </div>
            <h3 class="text-2xl font-black text-white tracking-tight">{{ $anggaran->count() }}</h3>
            <p class="text-[10px] font-bold text-slate-500 uppercase mt-1 tracking-widest">Pos Anggaran Aktif</p>
        </div>
    </div>

    {{-- Analysis & Budget --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <div class="lg:col-span-2 bg-slate-900 border border-slate-800 rounded-3xl p-8">
            <h3 class="text-lg font-black text-white tracking-tight mb-8">Analisis Tren</h3>
            <div class="h-[320px]">
                <canvas id="financeChart"></canvas>
            </div>
        </div>

        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8">
            <h3 class="text-lg font-black text-white tracking-tight mb-8">Status Anggaran</h3>
            <div class="space-y-6">
                @forelse($anggaran as $budget)
                    @php $persen = $budget->persentase; @endphp
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-xs font-black text-slate-300 uppercase tracking-tight">{{ $budget->nama }}</span>
                            <span class="text-[10px] font-black {{ $persen >= 90 ? 'text-rose-400' : ($persen >= 70 ? 'text-amber-400' : 'text-emerald-400') }}">{{ $persen }}%</span>
                        </div>
                        <div class="w-full bg-slate-800 rounded-full h-2 overflow-hidden">
                            <div class="h-2 rounded-full transition-all duration-1000 {{ $persen >= 90 ? 'bg-rose-500' : ($persen >= 70 ? 'bg-amber-500' : 'bg-emerald-500') }}"
                                 style="width: 0%;" x-init="setTimeout(() => $el.style.width = '{{ $persen }}%', 500)"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <x-lucide-pie-chart class="w-12 h-12 mx-auto mb-3 text-slate-800" />
                        <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Belum Ada Anggaran</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Activity Table - DARK THEME --}}
    <div class="bg-slate-900 border border-slate-800 rounded-3xl shadow-2xl overflow-hidden">
        <div class="p-8 border-b border-slate-800 flex items-center justify-between bg-slate-900/50">
            <div>
                <h3 class="text-lg font-black text-white tracking-tight">Riwayat Aktivitas</h3>
                <p class="text-xs text-slate-500 font-medium">Transaksi terbaru di dalam sistem</p>
            </div>
            <a href="{{ route('transactions.index') }}" class="text-xs font-black text-blue-600 uppercase tracking-widest hover:text-blue-800 transition px-4 py-2 bg-blue-50 rounded-xl">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-[10px] font-black uppercase tracking-widest text-slate-500 bg-slate-950/50 border-b border-slate-800">
                    <tr>
                        <th class="px-8 py-5">Identitas Waktu</th>
                        <th class="px-8 py-5">Deskripsi Transaksi</th>
                        <th class="px-8 py-5">Kategori</th>
                        <th class="px-8 py-5 text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 bg-slate-900">
                    @forelse($transaksiTerakhir as $trx)
                    <tr class="hover:bg-slate-800/50 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-[10px] font-black text-slate-400">
                                    {{ $trx->tanggal->format('d') }}
                                </div>
                                <span class="text-xs font-bold text-slate-400">{{ $trx->tanggal->translatedFormat('M Y') }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-sm font-bold text-white">{{ $trx->deskripsi }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 bg-slate-800 border border-slate-700 px-3 py-1 rounded-lg">{{ $trx->category?->nama ?? 'Umum' }}</span>
                        </td>
                        <td class="px-8 py-5 text-right font-black {{ $trx->jenis === 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $trx->jenis === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-8 py-16 text-center text-slate-400 font-bold uppercase text-[10px] tracking-widest">Data Kosong</td></tr>
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
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [
                    {
                        label: 'In',
                        data: @json($chartPemasukan),
                        borderColor: '#10b981',
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        backgroundColor: 'rgba(16, 185, 129, 0.05)',
                        pointRadius: 0,
                    },
                    {
                        label: 'Out',
                        data: @json($chartPengeluaran),
                        borderColor: '#f43f5e',
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        backgroundColor: 'rgba(244, 63, 94, 0.05)',
                        pointRadius: 0,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        grid: { color: 'rgba(255, 255, 255, 0.03)' },
                        ticks: { font: { size: 10, weight: 'bold' }, color: '#64748b' }
                    },
                    x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold' }, color: '#64748b' } }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>