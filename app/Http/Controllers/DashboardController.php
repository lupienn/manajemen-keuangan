<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $now     = now();
        $bulan   = $now->month;
        $tahun   = $now->year;

        // Monthly income & expense summaries
        $totalPemasukan = Transaction::where('jenis', 'pemasukan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');

        $totalPengeluaran = Transaction::where('jenis', 'pengeluaran')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');

        $saldo = $totalPemasukan - $totalPengeluaran;

        $jumlahPemasukan  = Transaction::where('jenis', 'pemasukan')
            ->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->count();
        $jumlahPengeluaran = Transaction::where('jenis', 'pengeluaran')
            ->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->count();

        // Last 5 transactions
        $transaksiTerakhir = Transaction::with('category')
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        // Budgets for this month with realisasi
        $anggaran = Budget::with('category')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        // Chart data: last 6 months income vs expense
        $chartLabels   = [];
        $chartPemasukan = [];
        $chartPengeluaran = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $chartLabels[] = $date->translatedFormat('M Y');
            $chartPemasukan[] = Transaction::where('jenis', 'pemasukan')
                ->whereMonth('tanggal', $date->month)
                ->whereYear('tanggal', $date->year)
                ->sum('jumlah');
            $chartPengeluaran[] = Transaction::where('jenis', 'pengeluaran')
                ->whereMonth('tanggal', $date->month)
                ->whereYear('tanggal', $date->year)
                ->sum('jumlah');
        }

        return view('dashboard', compact(
            'totalPemasukan', 'totalPengeluaran', 'saldo',
            'jumlahPemasukan', 'jumlahPengeluaran',
            'transaksiTerakhir', 'anggaran',
            'chartLabels', 'chartPemasukan', 'chartPengeluaran'
        ));
    }
}
