<?php

namespace App\Http\Controllers;

use App\Models\CashTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        
        $transactions = CashTransaction::where('user_id', $id)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $totalPemasukan = $transactions->where('type', 'pemasukan')->sum(function($item) {
            return $item->nominal * $item->qty;
        });
        
        $totalPengeluaran = $transactions->where('type', 'pengeluaran')->sum(function($item) {
            return $item->nominal * $item->qty;
        });
        
        $saldoKas = $totalPemasukan - $totalPengeluaran;
        
        return view('kas.index', compact('transactions', 'totalPemasukan', 'totalPengeluaran', 'saldoKas'));
    }

    public function create()
    {
        return view('kas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:pemasukan,pengeluaran',
            'date' => 'required|date',
            'category' => 'required|string|max:255',
            'qty' => 'required|numeric|min:1',
            'nominal' => 'required|numeric|min:0',
            'pic' => 'required|string|max:255',
        ]);

        CashTransaction::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'date' => $request->date,
            'category' => $request->category,
            'qty' => $request->qty,
            'nominal' => $request->nominal,
            'pic' => $request->pic,
        ]);

        $message = $request->type === 'pemasukan' 
            ? 'Data Pemasukan Kas Berhasil Ditambahkan!' 
            : 'Data Pengeluaran Kas Berhasil Ditambahkan!';

        return redirect()->route('kas.index')->with('success', $message);
    }

    public function edit($id)
    {
        $transaction = CashTransaction::where('user_id', Auth::id())->findOrFail($id);
        return view('kas.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $transaction = CashTransaction::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'type' => 'required|in:pemasukan,pengeluaran',
            'date' => 'required|date',
            'category' => 'required|string|max:255',
            'qty' => 'required|numeric|min:1',
            'nominal' => 'required|numeric|min:0',
            'pic' => 'required|string|max:255',
        ]);

        $transaction->update([
            'type' => $request->type,
            'date' => $request->date,
            'category' => $request->category,
            'qty' => $request->qty,
            'nominal' => $request->nominal,
            'pic' => $request->pic,
        ]);

        return redirect()->route('kas.index')->with('success', 'Transaksi Kas Berhasil Diperbarui!');
    }

    public function destroy($id)
    {
        $transaction = CashTransaction::where('user_id', Auth::id())->findOrFail($id);
        $transaction->delete();

        return redirect()->route('kas.index')->with('success', 'Transaksi Kas Berhasil Dihapus!');
    }
}
