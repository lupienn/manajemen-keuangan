<x-app-layout>
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Dashboard Keuangan</h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Selamat datang, <span class="text-blue-600 font-bold">{{ Auth::user()->name }}</span>. Berikut ringkasan bulan ini.</p>
        </div>
        <a href="{{ route('transactions.create') }}"
           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-sm font-black uppercase tracking-widest rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-200">
            <x-lucide-plus class="w-4 h-4 me-2" />
            Tambah Data
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
        {{-- Saldo --}}
        <div class="p-7 bg-white border border-slate-200 rounded-3xl shadow-sm transform transition-all duration-500 hover:-translate-y-1"
             x-show="loaded" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl">
                    <x-lucide-wallet class="w-6 h-6" />
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total Saldo</span>
            </div>
            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
            <p class="text-[10px] font-bold text-blue-500 uppercase mt-1 tracking-widest">{{ $saldo >= 0 ? 'Surplus Aktif' : 'Defisit Anggaran' }}</p>
        </div>

        {{-- Pemasukan --}}
        <div class="p-7 bg-white border border-slate-200 rounded-3xl shadow-sm transform transition-all duration-500 hover:-translate-y-1"
             x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-100" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                    <x-lucide-trending-up class="w-6 h-6" />
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Inflow</span>
            </div>
            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
            <p class="text-[10px] font-bold text-slate-400 uppercase mt-1 tracking-widest">{{ $jumlahPemasukan }} Transaksi</p>
        </div>

        {{-- Pengeluaran --}}
        <div class="p-7 bg-white border border-slate-200 rounded-3xl shadow-sm transform transition-all duration-500 hover:-translate-y-1"
             x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl">
                    <x-lucide-trending-down class="w-6 h-6" />
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Outflow</span>
            </div>
            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
            <p class="text-[10px] font-bold text-slate-400 uppercase mt-1 tracking-widest">{{ $jumlahPengeluaran }} Transaksi</p>
        </div>

        {{-- Anggaran --}}
        <div class="p-7 bg-white border border-slate-200 rounded-3xl shadow-sm transform transition-all duration-500 hover:-translate-y-1"
             x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-slate-100 text-slate-600 rounded-2xl">
                    <x-lucide-pie-chart class="w-6 h-6" />
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Budget</span>
            </div>
            <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ $anggaran->count() }}</h3>
            <p class="text-[10px] font-bold text-slate-400 uppercase mt-1 tracking-widest">Pos Anggaran Aktif</p>
        </div>
    </div>

    {{-- Analysis Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-3xl shadow-sm p-8">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-lg font-black text-slate-900 tracking-tight">Analisis Tren</h3>
                <div class="flex gap-4">
                    <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Pemasukan
                    </div>
                    <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span> Pengeluaran
                    </div>
                </div>
            </div>
            <div class="h-[320px]">
                <canvas id="financeChart"></canvas>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-8">
            <h3 class="text-lg font-black text-slate-900 tracking-tight mb-8">Status Anggaran</h3>
            <div class="space-y-6">
                @forelse($anggaran as $budget)
                    @php $persen = $budget->persentase; @endphp
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-xs font-black text-slate-700 uppercase tracking-tight">{{ $budget->nama }}</span>
                            <span class="text-[10px] font-black {{ $persen >= 90 ? 'text-rose-600' : ($persen >= 70 ? 'text-amber-500' : 'text-emerald-600') }}">{{ $persen }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="h-2 rounded-full transition-all duration-1000 {{ $persen >= 90 ? 'bg-rose-500' : ($persen >= 70 ? 'bg-amber-500' : 'bg-emerald-500') }}"
                                 style="width: 0%;" x-init="setTimeout(() => $el.style.width = '{{ $persen }}%', 500)"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <x-lucide-pie-chart class="w-12 h-12 mx-auto mb-3 text-slate-200" />
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Belum Ada Anggaran</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Activity Table --}}
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-lg font-black text-slate-900 tracking-tight">Riwayat Aktivitas</h3>
            <a href="{{ route('transactions.index') }}" class="text-xs font-black text-blue-600 uppercase tracking-widest hover:text-blue-800 transition">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-[10px] font-black uppercase tracking-widest text-slate-400 bg-white border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5">Tanggal</th>
                        <th class="px-8 py-5">Deskripsi</th>
                        <th class="px-8 py-5">Kategori</th>
                        <th class="px-8 py-5 text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($transaksiTerakhir as $trx)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-8 py-5 text-xs font-bold text-slate-500">{{ $trx->tanggal->format('d/m/Y') }}</td>
                        <td class="px-8 py-5 font-bold text-slate-900">{{ $trx->deskripsi }}</td>
                        <td class="px-8 py-5">
                            <span class="text-[10px] font-black uppercase tracking-tighter text-slate-400 bg-slate-100 px-2 py-1 rounded-md">{{ $trx->category?->nama ?? 'Umum' }}</span>
                        </td>
                        <td class="px-8 py-5 text-right font-black {{ $trx->jenis === 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $trx->jenis === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-8 py-12 text-center text-slate-400 font-bold uppercase text-[10px] tracking-widest">Data Kosong</td></tr>
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
                        label: 'Inflow',
                        data: @json($chartPemasukan),
                        borderColor: '#10b981',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: false,
                        pointRadius: 0,
                    },
                    {
                        label: 'Outflow',
                        data: @json($chartPengeluaran),
                        borderColor: '#f43f5e',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: false,
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
                        grid: { color: '#f1f5f9' },
                        ticks: { font: { size: 10, weight: 'bold' }, color: '#94a3b8' }
                    },
                    x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold' }, color: '#94a3b8' } }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>