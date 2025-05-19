<?php

namespace App\Http\Controllers\eksternal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyedia;

class PenyediaController extends Controller
{
    public function index()
    {
        $penyedia = Penyedia::all();
        return view('eksternal.penyedia.index', compact('penyedia'));
    }

    public function add()
    {
        return view('eksternal.penyedia.add');
    }

    public function addPenyedia(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'company' => 'required|string|max:255',
                'npwp' => 'required|string|max:50',
                'address' => 'required|string|max:255',
                'delegation_name' => 'required|string|max:255',
                'delegate_position' => 'required|string|max:100',
                'account' => 'required|string|max:100',
            ]);

            Penyedia::create([
                'company' => $request->input('company'),
                'npwp' => $request->input('npwp'),
                'address' => $request->input('address'),
                'delegation_name' => $request->input('delegation_name'),
                'delegate_position' => $request->input('delegate_position'),
                'account' => $request->input('account'),
            ]);

            return redirect()->route('eksternal.penyedia.index')
                             ->with('success', 'Data Penyedia berhasil ditambahkan.');
        }

        return redirect()->back();
    }

    public function deletePenyedia($id)
    {
        $penyedia = Penyedia::findOrFail($id);
        $penyedia->delete();

        return redirect()->route('eksternal.penyedia.index')
                         ->with('success', 'Data Penyedia berhasil dihapus.');
    }

    public function edit($id)
    {
        $penyedia = Penyedia::findOrFail($id);
        return view('eksternal.penyedia.edit', compact('penyedia'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'company' => 'required|string|max:255',
            'npwp' => 'required|string|max:50',
            'address' => 'required|string|max:255',
            'delegation_name' => 'required|string|max:255',
            'delegate_position' => 'required|string|max:100',
            'account' => 'required|string|max:100',
        ]);

        $penyedia = Penyedia::findOrFail($id);
        $penyedia->update([
            'company' => $request->input('company'),
            'npwp' => $request->input('npwp'),
            'address' => $request->input('address'),
            'delegation_name' => $request->input('delegation_name'),
            'delegate_position' => $request->input('delegate_position'),
            'account' => $request->input('account'),
        ]);

        return redirect()->route('eksternal.penyedia.index')
                         ->with('success', 'Data Penyedia berhasil diperbarui.');
    }
}
