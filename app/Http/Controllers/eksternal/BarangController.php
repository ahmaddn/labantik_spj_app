<?php

namespace App\Http\Controllers\eksternal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Session;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('eksternal.barang.index', compact('barang'));
    }

    public function add()
    {
        return view('eksternal.barang.add');
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'amount' => 'required|integer|min:1',
                'price' => 'required|integer|min:0',
                'unit' => 'required|string',
            ]);

            $total = $request->amount * $request->price;

            Barang::create([
                'name' => $request->input('name'),
                'amount' => $request->input('amount'),
                'price' => $request->input('price'),
                'unit' => $request->input('unit'),
                'total' => $total,
            ]);

            return redirect()->route('eksternal.barang.index')
                             ->with('success', 'Data barang berhasil ditambahkan.');
        }

        return redirect()->back();
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('eksternal.barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            'price' => 'required|integer|min:0',
        ]);

        $total = $request->amount * $request->price;

        $barang = Barang::findOrFail($id);
        $barang->update([
            'name' => $request->input('name'),
            'amount' => $request->input('amount'),
            'price' => $request->input('price'),
            'unit' => $request->input('unit'),
            'total' => $total,
        ]);

        return redirect()->route('eksternal.barang.index')
                         ->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('eksternal.barang.index')
                         ->with('success', 'Data barang berhasil dihapus.');
    }
}
