<?php

namespace App\Http\Controllers\internal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bendahara;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BendaharaController extends Controller
{
    public function index()
    {
        $bendahara = Bendahara::all();
        return view('internal.bendahara.index', compact('bendahara'));
    }

    public function add()
    {
        return view('internal.bendahara.add');
    }

    public function addBendahara(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|unique:bendahara,name',
                'jenis' => 'required|in:BOS,BODP,',
                'nip' => 'required|digits:18|unique:bendahara,nip',
                'school' => 'required|numeric',
            ]);

            Bendahara::create([
                'name' => $request->input('name'),
                'type' => $request->input('jenis'),
                'nip' => $request->input('nip'),
                'school' => $request->input('school'),
            ]);

            return redirect()->route('internal.bendahara.index')
                             ->with('success', 'Data Bendahara berhasil ditambahkan.');
        }

        $data['user'] = User::find(Session::get('userid'));
        return view('internal.bendahara.add', $data);
    }

    public function deleteBendahara($id)
    {
        $bendahara = Bendahara::findOrFail($id);
        $bendahara->delete();

        return redirect()->route('internal.bendahara.index')
                         ->with('success', 'Data Bendahara berhasil dihapus.');
    }

    public function edit($id)
    {
        $bendahara = Bendahara::findOrFail($id);
        $user = Auth::user();

        return view('internal.bendahara.edit', [
            'bendahara' => $bendahara,
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:bendahara,name,' . $id,
            'jenis' => 'required|in:BOS,BODP,',
            'nip' => 'required|digits:18|unique:bendahara,nip,' . $id,
            'school' => 'required|numeric',
        ]);

        $bendahara = Bendahara::findOrFail($id);
        $bendahara->update([
            'name' => $request->input('name'),
            'nip' => $request->input('nip'),
            'school' => $request->input('school'),
            ]);

        return redirect()->route('internal.bendahara.index')
                         ->with('success', 'Data Bendahara berhasil diperbarui.');
    }
}
