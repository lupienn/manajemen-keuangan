<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\Budget;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@keuangan.test'],
            ['name' => 'Administrator Keuangan', 'password' => Hash::make('password')]
        );

        // Seed categories
        $categories = [
            // Pemasukan
            ['nama' => 'Penjualan Produk',    'jenis' => 'pemasukan',  'warna' => '#10b981'],
            ['nama' => 'Jasa Layanan',         'jenis' => 'pemasukan',  'warna' => '#06b6d4'],
            ['nama' => 'Investasi',            'jenis' => 'pemasukan',  'warna' => '#8b5cf6'],
            ['nama' => 'Pendapatan Lainnya',   'jenis' => 'pemasukan',  'warna' => '#f59e0b'],
            // Pengeluaran
            ['nama' => 'Gaji & Tunjangan',    'jenis' => 'pengeluaran', 'warna' => '#f43f5e'],
            ['nama' => 'Operasional Kantor',   'jenis' => 'pengeluaran', 'warna' => '#ef4444'],
            ['nama' => 'Pembelian Aset',       'jenis' => 'pengeluaran', 'warna' => '#f97316'],
            ['nama' => 'Pemasaran',            'jenis' => 'pengeluaran', 'warna' => '#ec4899'],
            ['nama' => 'Transportasi',         'jenis' => 'pengeluaran', 'warna' => '#d97706'],
            ['nama' => 'Biaya Lainnya',        'jenis' => 'pengeluaran', 'warna' => '#6b7280'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['nama' => $cat['nama'], 'jenis' => $cat['jenis']], $cat);
        }

        $now = now();
        $catPenjualan  = Category::where('nama', 'Penjualan Produk')->first();
        $catJasa       = Category::where('nama', 'Jasa Layanan')->first();
        $catGaji       = Category::where('nama', 'Gaji & Tunjangan')->first();
        $catOpsional   = Category::where('nama', 'Operasional Kantor')->first();
        $catPemasaran  = Category::where('nama', 'Pemasaran')->first();

        // Seed sample transactions for current month
        $sampleTransactions = [
            ['jenis' => 'pemasukan',  'category_id' => $catPenjualan->id,  'deskripsi' => 'Pembayaran Klien PT. Maju Jaya',  'jumlah' => 15000000, 'tanggal' => $now->copy()->subDays(2)],
            ['jenis' => 'pemasukan',  'category_id' => $catJasa->id,       'deskripsi' => 'Jasa Konsultasi Keuangan',        'jumlah' => 5000000,  'tanggal' => $now->copy()->subDays(5)],
            ['jenis' => 'pemasukan',  'category_id' => $catPenjualan->id,  'deskripsi' => 'Penjualan Produk Batch Q2',       'jumlah' => 8500000,  'tanggal' => $now->copy()->subDays(7)],
            ['jenis' => 'pengeluaran','category_id' => $catGaji->id,       'deskripsi' => 'Penggajian Karyawan Mei 2026',    'jumlah' => 12000000, 'tanggal' => $now->copy()->subDays(1)],
            ['jenis' => 'pengeluaran','category_id' => $catOpsional->id,   'deskripsi' => 'Sewa Gedung Kantor',              'jumlah' => 4500000,  'tanggal' => $now->copy()->subDays(3)],
            ['jenis' => 'pengeluaran','category_id' => $catPemasaran->id,  'deskripsi' => 'Iklan Digital Google Ads',        'jumlah' => 2000000,  'tanggal' => $now->copy()->subDays(6)],
            ['jenis' => 'pengeluaran','category_id' => $catOpsional->id,   'deskripsi' => 'Tagihan Listrik & Internet',      'jumlah' => 1200000,  'tanggal' => $now->copy()->subDays(8)],
        ];

        if (Transaction::count() === 0) {
            foreach ($sampleTransactions as $trx) {
                Transaction::create(array_merge($trx, ['user_id' => $admin->id]));
            }
        }

        // Seed sample budgets for current month
        if (Budget::count() === 0) {
            $sampleBudgets = [
                ['category_id' => $catGaji->id,      'nama' => 'Anggaran Gaji Mei',       'jumlah_anggaran' => 15000000],
                ['category_id' => $catOpsional->id,  'nama' => 'Anggaran Operasional Mei','jumlah_anggaran' => 6000000],
                ['category_id' => $catPemasaran->id, 'nama' => 'Anggaran Pemasaran Mei',  'jumlah_anggaran' => 3000000],
            ];
            foreach ($sampleBudgets as $budget) {
                Budget::create(array_merge($budget, [
                    'user_id' => $admin->id,
                    'bulan'   => $now->month,
                    'tahun'   => $now->year,
                ]));
            }
        }
    }
}
