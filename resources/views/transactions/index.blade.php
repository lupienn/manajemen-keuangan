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
    <div class="bg-slate-900 border border-slate-800 rounded-xl p-4 mb-5 shadow-xl">
        <form method="GET" action="{{ route('transactions.index') }}" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1">Jenis</label>
                <select name="jenis" class="text-xs border-0 bg-slate-800 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-blue-500 font-bold">
                    <option value="">Semua Jenis</option>
                    <option value="pemasukan" {{ request('jenis') === 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="pengeluaran" {{ request('jenis') === 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1">Kategori</label>
                <select name="category_id" class="text-xs border-0 bg-slate-800 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-blue-500 font-bold">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1">Bulan</label>
                <select name="bulan" class="text-xs border-0 bg-slate-800 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-blue-500 font-bold">
                    <option value="">Semua Bulan</option>
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1">Tahun</label>
                <select name="tahun" class="text-xs border-0 bg-slate-800 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-blue-500 font-bold">
                    @for($y = now()->year; $y >= now()->year - 3; $y--)
                        <option value="{{ $y }}" {{ request('tahun', now()->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white text-xs font-black uppercase tracking-widest rounded-lg hover:bg-blue-500 transition shadow-lg shadow-blue-900/20">
                Filter
            </button>
            @if(request()->hasAny(['jenis','category_id','bulan','tahun']))
                <a href="{{ route('transactions.index') }}" class="px-5 py-2.5 text-xs font-black uppercase tracking-widest text-slate-400 border border-slate-800 rounded-lg hover:bg-slate-800 transition">Reset</a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-slate-900 border border-slate-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-400">
                <thead class="text-xs uppercase bg-slate-950/50 text-slate-500 border-b border-slate-800">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Jenis</th>
                        <th class="px-6 py-3 text-right">Nominal</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-slate-400 text-xs">
                            {{ $trx->tanggal->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-white font-medium">{{ $trx->deskripsi }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest text-slate-500 bg-slate-800 border border-slate-700">
                                {{ $trx->category?->nama ?? '—' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($trx->jenis === 'pemasukan')
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Pemasukan</span>
                            @else
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-rose-500/10 text-rose-400 border border-rose-500/20">Pengeluaran</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right font-black {{ $trx->jenis === 'pemasukan' ? 'text-emerald-400' : 'text-rose-400' }}">
                            {{ $trx->jenis === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('transactions.edit', $trx) }}" 
                                   class="p-1.5 text-blue-400 hover:bg-blue-500/10 rounded-lg transition" title="Edit">
                                    <x-lucide-pencil class="w-4 h-4" />
                                </a>
                                <form method="POST" action="{{ route('transactions.destroy', $trx) }}"
                                      onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-rose-400 hover:bg-rose-500/10 rounded-lg transition" title="Hapus">
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
