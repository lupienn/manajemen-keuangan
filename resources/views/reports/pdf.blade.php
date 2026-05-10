<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - {{ $namaBulan }} {{ $tahun }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; color: #1f2937; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 3px solid #1e3a8a; padding-bottom: 16px; margin-bottom: 24px; }
        .header h1 { font-size: 20px; font-weight: 800; color: #1e3a8a; margin: 0 0 4px; }
        .header p { color: #6b7280; margin: 2px 0; font-size: 11px; }
        .summary { display: flex; gap: 16px; margin-bottom: 24px; }
        .summary-card { flex: 1; padding: 12px 16px; border-radius: 8px; }
        .summary-card.income { background: #ecfdf5; border-left: 4px solid #10b981; }
        .summary-card.expense { background: #fff1f2; border-left: 4px solid #f43f5e; }
        .summary-card.balance { background: #eff6ff; border-left: 4px solid #1e3a8a; }
        .summary-card .label { font-size: 10px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; }
        .summary-card .value { font-size: 16px; font-weight: 800; margin-top: 4px; }
        .summary-card.income .value { color: #059669; }
        .summary-card.expense .value { color: #e11d48; }
        .summary-card.balance .value { color: #1e3a8a; }
        .section-title { font-size: 13px; font-weight: 700; margin-bottom: 8px; padding: 6px 10px; border-radius: 4px; }
        .section-title.income { background: #ecfdf5; color: #065f46; }
        .section-title.expense { background: #fff1f2; color: #9f1239; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        thead th { background-color: #f8fafc; text-align: left; padding: 8px 10px; font-size: 10px; text-transform: uppercase; color: #6b7280; border-bottom: 1px solid #e2e8f0; }
        tbody td { padding: 8px 10px; border-bottom: 1px solid #f1f5f9; font-size: 11px; }
        tbody tr:last-child td { border-bottom: none; }
        tfoot td { padding: 8px 10px; font-weight: 700; background: #f8fafc; }
        .amount-income { color: #059669; font-weight: 700; text-align: right; }
        .amount-expense { color: #e11d48; font-weight: 700; text-align: right; }
        .footer { margin-top: 32px; text-align: center; font-size: 10px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Keuangan Perusahaan</h1>
        <p>Periode: {{ $namaBulan }} {{ $tahun }}</p>
        <p>Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }}</p>
    </div>

    <div class="summary">
        <div class="summary-card income">
            <div class="label">Total Pemasukan</div>
            <div class="value">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card expense">
            <div class="label">Total Pengeluaran</div>
            <div class="value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card balance">
            <div class="label">Saldo Bersih</div>
            <div class="value">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="section-title income">📈 Rincian Pemasukan</div>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Kategori</th>
                <th style="text-align:right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pemasukan as $trx)
            <tr>
                <td>{{ $trx->tanggal->format('d/m/Y') }}</td>
                <td>{{ $trx->deskripsi }}</td>
                <td>{{ $trx->category?->nama ?? '—' }}</td>
                <td class="amount-income">Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;color:#9ca3af;padding:16px">Tidak ada data pemasukan.</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Total Pemasukan</td>
                <td class="amount-income">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="section-title expense">📉 Rincian Pengeluaran</div>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Kategori</th>
                <th style="text-align:right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengeluaran as $trx)
            <tr>
                <td>{{ $trx->tanggal->format('d/m/Y') }}</td>
                <td>{{ $trx->deskripsi }}</td>
                <td>{{ $trx->category?->nama ?? '—' }}</td>
                <td class="amount-expense">Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;color:#9ca3af;padding:16px">Tidak ada data pengeluaran.</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Total Pengeluaran</td>
                <td class="amount-expense">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Manajemen Keuangan — Laporan ini digenerate secara otomatis oleh sistem.</p>
    </div>
</body>
</html>
