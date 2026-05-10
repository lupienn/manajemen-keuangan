<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('category')->orderByDesc('tanggal')->orderByDesc('id');

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $transactions = $query->paginate(15)->withQueryString();
        $categories   = Category::orderBy('jenis')->orderBy('nama')->get();

        return view('transactions.index', compact('transactions', 'categories'));
    }

    public function create(Request $request)
    {
        $jenis      = $request->get('jenis', 'pemasukan');
        $categories = Category::where('jenis', $jenis)->orderBy('nama')->get();
        return view('transactions.create', compact('jenis', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis'       => ['required', 'in:pemasukan,pengeluaran'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'deskripsi'   => ['required', 'string', 'max:255'],
            'jumlah'      => ['required', 'numeric', 'min:1'],
            'tanggal'     => ['required', 'date'],
            'catatan'     => ['nullable', 'string'],
        ]);

        $validated['user_id'] = Auth::id();

        Transaction::create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(Transaction $transaction)
    {
        $categories = Category::where('jenis', $transaction->jenis)->orderBy('nama')->get();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'deskripsi'   => ['required', 'string', 'max:255'],
            'jumlah'      => ['required', 'numeric', 'min:1'],
            'tanggal'     => ['required', 'date'],
            'catatan'     => ['nullable', 'string'],
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return back()->with('success', 'Transaksi berhasil dihapus.');
    }
}
