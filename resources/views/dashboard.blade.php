<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-corporate dark:text-white">Dashboard Keuangan</h1>
        <p class="text-gray-600 dark:text-gray-400">Selamat datang kembali, {{ Auth::user()->name }}. Berikut ringkasan keuangan hari ini.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Total Saldo -->
        <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-blue-50 rounded-lg dark:bg-blue-900/20">
                    <x-lucide-wallet class="w-6 h-6 text-corporate" />
                </div>
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Saldo</span>
            </div>
            <div class="flex items-baseline">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Rp 25.000.000</h3>
            </div>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                <span class="text-income font-medium">+2.5%</span> dari bulan lalu
            </p>
        </div>

        <!-- Pemasukan -->
        <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-emerald-50 rounded-lg dark:bg-emerald-900/20">
                    <x-lucide-trending-up class="w-6 h-6 text-income" />
                </div>
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Pemasukan (Mei)</span>
            </div>
            <div class="flex items-baseline">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Rp 12.450.000</h3>
            </div>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Total 14 transaksi
            </p>
        </div>

        <!-- Pengeluaran -->
        <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-rose-50 rounded-lg dark:bg-rose-900/20">
                    <x-lucide-trending-down class="w-6 h-6 text-expense" />
                </div>
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Pengeluaran (Mei)</span>
            </div>
            <div class="flex items-baseline">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Rp 8.120.000</h3>
            </div>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Total 28 transaksi
            </p>
        </div>

        <!-- Anggaran Sisa -->
        <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-gray-50 rounded-lg dark:bg-gray-700">
                    <x-lucide-pie-chart class="w-6 h-6 text-gray-600 dark:text-gray-400" />
                </div>
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa Anggaran</span>
            </div>
            <div class="flex items-baseline">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">65%</h3>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-3 dark:bg-gray-700">
                <div class="bg-corporate h-1.5 rounded-full" style="width: 65%"></div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Chart Placeholder -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Table -->
        <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Transaksi Terakhir</h3>
            </div>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Kategori</th>
                            <th class="px-6 py-3">Deskripsi</th>
                            <th class="px-6 py-3 text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">10 Mei 2026</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Pemasukan</span>
                            </td>
                            <td class="px-6 py-4">Pembayaran Klien A</td>
                            <td class="px-6 py-4 text-right font-bold text-income">+ Rp 5.000.000</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">09 Mei 2026</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">Pengeluaran</span>
                            </td>
                            <td class="px-6 py-4">Sewa Kantor</td>
                            <td class="px-6 py-4 text-right font-bold text-expense">- Rp 2.500.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700 text-center">
                <a href="#" class="text-sm font-medium text-corporate hover:underline">Lihat Semua Transaksi</a>
            </div>
        </div>

        <!-- Sidebar Widget -->
        <div class="space-y-6">
            <div class="p-6 bg-corporate rounded-xl shadow-sm text-white">
                <h3 class="text-lg font-bold mb-2">Ringkasan Laporan</h3>
                <p class="text-blue-100 text-sm mb-6">Unduh laporan bulanan Anda dalam format PDF untuk audit.</p>
                <button class="w-full py-2.5 px-5 bg-white text-corporate font-bold rounded-lg hover:bg-gray-100 transition-colors flex items-center justify-center">
                    <x-lucide-download class="w-4 h-4 me-2" />
                    Unduh PDF
                </button>
            </div>

            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Peringatan Anggaran</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="p-2 bg-rose-50 rounded-lg me-3">
                            <x-lucide-alert-circle class="w-4 h-4 text-expense" />
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Operasional Kantor</p>
                            <p class="text-xs text-gray-500">Mencapai 90% dari batas bulanan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>