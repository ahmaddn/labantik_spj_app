<?php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    //
    public function index()
    {
        $pengeluaran = Expenditure::all();
        return view('pengeluaran.index', compact('pengeluaran'));
    }

    public function create()
    {
        return view('pengeluaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'type' => 'required|string|max:255',
            'qty' => 'required|numeric',
            'nominal' => 'required|numeric',
            'pic' => 'required|string',
        ]);

        Expenditure::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'type' => $request->type,
            'qty' => $request->qty,
            'nominal' => $request->nominal,
            'pic' => $request->pic,
        ]);

        return redirect()->route('pengeluaran.index')->with('success', 'Data Pengeluaran Berhasil Ditambahkan!');
    }

    public function edit($id)
    {
        $pengeluaran = Expenditure::findOrFail($id);
        return view('pengeluaran.edit', compact('pengeluaran'));
    }

    public function update(Request $request, $id)
    {
        $pengeluaran = Expenditure::findOrFail($id);
        $data = $request->validate([
            'date' => 'required|date',
            'type' => 'required|string|max:255',
            'qty' => 'required|numeric',
            'nominal' => 'required|numeric',
            'pic' => 'required|string',
        ]);

        $pengeluaran->update($data);

        return redirect()->route('pengeluaran.index')->with('success', 'Data Pengeluaran Berhasil Diupdate!');
    }

    public function destroy($id)
    {
        $pengeluaran = Expenditure::findOrFail($id);
        $pengeluaran->delete();

        return redirect()->route('pengeluaran.index')->with('success', 'Data Pengeluaran Berhasil Dihapus!');
    }
}
