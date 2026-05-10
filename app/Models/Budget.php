<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'nama', 'jumlah_anggaran', 'bulan', 'tahun', 'keterangan'
    ];

    protected function casts(): array
    {
        return [
            'jumlah_anggaran' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get actual spending for this budget (based on category & month/year)
     */
    public function getRealisasiAttribute(): float
    {
        return Transaction::where('category_id', $this->category_id)
            ->where('jenis', 'pengeluaran')
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->sum('jumlah');
    }

    /**
     * Get percentage of budget used
     */
    public function getPersentaseAttribute(): float
    {
        if ($this->jumlah_anggaran <= 0) return 0;
        return min(100, round(($this->realisasi / $this->jumlah_anggaran) * 100, 1));
    }
}
