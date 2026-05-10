<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $bulan = (int) $request->get('bulan', now()->month);
        $tahun = (int) $request->get('tahun', now()->year);

        $pemasukan = Transaction::with('category')
            ->where('jenis', 'pemasukan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderByDesc('tanggal')
            ->get();

        $pengeluaran = Transaction::with('category')
            ->where('jenis', 'pengeluaran')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderByDesc('tanggal')
            ->get();

        $totalPemasukan  = $pemasukan->sum('jumlah');
        $totalPengeluaran = $pengeluaran->sum('jumlah');
        $saldo            = $totalPemasukan - $totalPengeluaran;

        // Pemasukan by category
        $pemasukanByCategory = Transaction::selectRaw('category_id, SUM(jumlah) as total')
            ->where('jenis', 'pemasukan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->with('category')
            ->groupBy('category_id')
            ->get();

        $pengeluaranByCategory = Transaction::selectRaw('category_id, SUM(jumlah) as total')
            ->where('jenis', 'pengeluaran')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->with('category')
            ->groupBy('category_id')
            ->get();

        return view('reports.index', compact(
            'bulan', 'tahun',
            'pemasukan', 'pengeluaran',
            'totalPemasukan', 'totalPengeluaran', 'saldo',
            'pemasukanByCategory', 'pengeluaranByCategory'
        ));
    }

    public function exportPdf(Request $request)
    {
        $bulan = (int) $request->get('bulan', now()->month);
        $tahun = (int) $request->get('tahun', now()->year);

        $pemasukan = Transaction::with('category')
            ->where('jenis', 'pemasukan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderByDesc('tanggal')
            ->get();

        $pengeluaran = Transaction::with('category')
            ->where('jenis', 'pengeluaran')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderByDesc('tanggal')
            ->get();

        $totalPemasukan   = $pemasukan->sum('jumlah');
        $totalPengeluaran = $pengeluaran->sum('jumlah');
        $saldo            = $totalPemasukan - $totalPengeluaran;

        $namaBulan = \Carbon\Carbon::createFromDate(null, $bulan, 1)->translatedFormat('F');

        $pdf = Pdf::loadView('reports.pdf', compact(
            'bulan', 'tahun', 'namaBulan',
            'pemasukan', 'pengeluaran',
            'totalPemasukan', 'totalPengeluaran', 'saldo'
        ))->setPaper('A4', 'portrait');

        return $pdf->download("laporan-keuangan-{$namaBulan}-{$tahun}.pdf");
    }
}
