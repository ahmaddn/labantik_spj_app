<?php

namespace App\Http\Controllers\internal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penerima;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class PenerimaController extends Controller
{
    public function index()
    {
        $penerima = Penerima::all();
        return view('internal.penerima.index', compact('penerima'));
    }

    public function add()
    {
        $data['user'] = User::find(Session::get('userid'));
        return view('internal.penerima.add', $data);
    }

    public function addPenerima(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|unique:penerima,name',
                'nip' => 'required|numeric|unique:penerima,nip',
                'school' => 'required|numeric|',
            ]);

            Penerima::create([
                'name' => $request->input('name'),
                'nip' => $request->input('nip'),
                'school' => $request->input('school'),
            ]);

            return redirect()->route('internal.penerima.index')
                             ->with('success', 'Data Penerima berhasil ditambahkan.');
        }

        return redirect()->back();
    }

    public function deletePenerima($id)
    {
        $penerima = Penerima::findOrFail($id);
        $penerima->delete();

        return redirect()->route('internal.penerima.index')
                         ->with('success', 'Data Penerima berhasil dihapus.');
    }

    public function edit($id)
    {
        $penerima = Penerima::findOrFail($id);
        $user = auth()->user();

        return view('internal.penerima.edit', [
            'penerima' => $penerima,
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:penerima,name,' . $id,
            'nip' => 'required|numeric|unique:penerima,nip,' . $id,
            'school' => 'required|numeric',
        ]);

        $penerima = Penerima::findOrFail($id);
        $penerima->update([
            'name' => $request->input('name'),
            'nip' => $request->input('nip'),
            'school' => $request->input('school'),
        ]);

        return redirect()->route('internal.penerima.index')
                         ->with('success', 'Data Penerima berhasil diperbarui.');
    }
}
