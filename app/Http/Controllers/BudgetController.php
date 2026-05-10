<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $budgets = Budget::with('category')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        $categories = Category::where('jenis', 'pengeluaran')->orderBy('nama')->get();

        return view('budgets.index', compact('budgets', 'categories', 'bulan', 'tahun'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'    => ['nullable', 'exists:categories,id'],
            'nama'           => ['required', 'string', 'max:255'],
            'jumlah_anggaran'=> ['required', 'numeric', 'min:1'],
            'bulan'          => ['required', 'integer', 'min:1', 'max:12'],
            'tahun'          => ['required', 'integer', 'min:2000'],
            'keterangan'     => ['nullable', 'string'],
        ]);

        $validated['user_id'] = Auth::id();

        Budget::create($validated);

        return back()->with('success', 'Anggaran berhasil ditambahkan.');
    }

    public function update(Request $request, Budget $budget)
    {
        $validated = $request->validate([
            'category_id'    => ['nullable', 'exists:categories,id'],
            'nama'           => ['required', 'string', 'max:255'],
            'jumlah_anggaran'=> ['required', 'numeric', 'min:1'],
            'keterangan'     => ['nullable', 'string'],
        ]);

        $budget->update($validated);

        return back()->with('success', 'Anggaran berhasil diperbarui.');
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();
        return back()->with('success', 'Anggaran berhasil dihapus.');
    }
}
