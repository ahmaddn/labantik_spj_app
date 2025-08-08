<?php

namespace App\Http\Controllers\internal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyedia;
use Illuminate\Support\Facades\Auth;

class PenyediaController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $penyedia = Penyedia::where('userID', $id)->get();
        return view('internal.penyedia.index', compact('penyedia'));
    }

    public function add()
    {
        return view('internal.penyedia.add');
    }

    public function addPenyedia(Request $request)
    {
        if ($request->isMethod('post')) {
            $id = Auth::id();
            $request->validate([
                'company' => 'required|string|max:255',
                'npwp' => 'nullable|regex:/^[A-Za-z0-9 \-]+$/',
                'address' => 'required|string|max:255',
                'post_code' => 'required|numeric',
                'delegation_name' => 'required|string|max:255',
                'delegate_position' => 'required|string|max:100',
                'bank' => 'required|string',
                'account' => 'required|min_digits:10|max_digits:16',
            ]);

            Penyedia::create([
                'company' => $request->input('company'),
                'npwp' => $request->input('npwp'),
                'address' => $request->input('address'),
                'post_code' => $request->input('post_code'),
                'delegation_name' => $request->input('delegation_name'),
                'delegate_position' => $request->input('delegate_position'),
                'bank' => $request->input('bank'),
                'account' => $request->input('account'),
                'userID' => $id
            ]);

            return redirect()->route('internal.penyedia.index')
                ->with('success', 'Data Penyedia berhasil ditambahkan.');
        }

        return redirect()->back();
    }

    public function deletePenyedia($id)
    {
        $penyedia = Penyedia::findOrFail($id);
        $penyedia->delete();

        return redirect()->route('internal.penyedia.index')
            ->with('success', 'Data Penyedia berhasil dihapus.');
    }

    public function edit($id)
    {
        $penyedia = Penyedia::findOrFail($id);
        return view('internal.penyedia.edit', compact('penyedia'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'company' => 'required|string|max:255',
            'npwp' => 'nullable|string|regex:/^[A-Za-z0-9 \-]+$/',
            'address' => 'required|string|max:255',
            'post_code' => 'required|numeric',
            'delegation_name' => 'required|string|max:255',
            'delegate_position' => 'required|string|max:100',
            'bank' => 'required|string',
            'account' => 'required|min_digits:10|max_digits:16',
        ]);

        $penyedia = Penyedia::findOrFail($id);
        $penyedia->update([
            'company' => $request->input('company'),
            'npwp' => $request->input('npwp'),
            'address' => $request->input('address'),
            'post_code' => $request->input('post_code'),
            'delegation_name' => $request->input('delegation_name'),
            'delegate_position' => $request->input('delegate_position'),
            'bank' => $request->input('bank'),
            'account' => $request->input('account'),
        ]);

        return redirect()->route('internal.penyedia.index')
            ->with('success', 'Data Penyedia berhasil diperbarui.');
    }
}
