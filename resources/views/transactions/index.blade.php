<x-app-layout>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                @if(request('jenis') === 'pemasukan') Pemasukan
                @elseif(request('jenis') === 'pengeluaran') Pengeluaran
                @else Semua Transaksi
                @endif
            </h1>
            <p class="text-sm text-gray-500 mt-1">{{ $transactions->total() }} transaksi ditemukan</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('transactions.create', ['jenis' => 'pemasukan']) }}"
               class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-lg hover:bg-emerald-700 transition shadow">
                <x-lucide-plus class="w-4 h-4 me-1.5" /> Pemasukan
            </a>
            <a href="{{ route('transactions.create', ['jenis' => 'pengeluaran']) }}"
               class="inline-flex items-center px-4 py-2 bg-rose-600 text-white text-sm font-semibold rounded-lg hover:bg-rose-700 transition shadow">
                <x-lucide-plus class="w-4 h-4 me-1.5" /> Pengeluaran
            </a>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white border border-gray-200 rounded-xl p-4 mb-5 dark:bg-gray-800 dark:border-gray-700">
        <form method="GET" action="{{ route('transactions.index') }}" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Jenis</label>
                <select name="jenis" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-corporate focus:border-corporate">
                    <option value="">Semua Jenis</option>
                    <option value="pemasukan" {{ request('jenis') === 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="pengeluaran" {{ request('jenis') === 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Kategori</label>
                <select name="category_id" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-corporate focus:border-corporate">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Bulan</label>
                <select name="bulan" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-corporate focus:border-corporate">
                    <option value="">Semua Bulan</option>
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Tahun</label>
                <select name="tahun" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-corporate focus:border-corporate">
                    @for($y = now()->year; $y >= now()->year - 3; $y--)
                        <option value="{{ $y }}" {{ request('tahun', now()->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-corporate text-white text-sm font-semibold rounded-lg hover:bg-blue-800 transition">
                Filter
            </button>
            @if(request()->hasAny(['jenis','category_id','bulan','tahun']))
                <a href="{{ route('transactions.index') }}" class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100 transition">Reset</a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs uppercase bg-gray-50 text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Jenis</th>
                        <th class="px-6 py-3 text-right">Nominal</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300 text-xs">
                            {{ $trx->tanggal->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white font-medium">{{ $trx->deskripsi }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs text-gray-600 bg-gray-100">
                                {{ $trx->category?->nama ?? '—' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($trx->jenis === 'pemasukan')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Pemasukan</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">Pengeluaran</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right font-bold {{ $trx->jenis === 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $trx->jenis === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('transactions.edit', $trx) }}" 
                                   class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                    <x-lucide-pencil class="w-4 h-4" />
                                </a>
                                <form method="POST" action="{{ route('transactions.destroy', $trx) }}"
                                      onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                        <x-lucide-trash-2 class="w-4 h-4" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                            <x-lucide-inbox class="w-12 h-12 mx-auto mb-3 opacity-30" />
                            <p>Belum ada transaksi yang sesuai filter.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
