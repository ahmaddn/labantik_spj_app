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
        $id = Auth::id();
        $bendahara = Bendahara::where('userID', $id)->get();
        return view('internal.bendahara.index', compact('bendahara'));
    }

    public function add()
    {
        return view('internal.bendahara.add');
    }

    public function addBendahara(Request $request)
    {
        if ($request->isMethod('post')) {
            $id = Auth::id();

            $request->validate([
                'received_from' => 'required|string',
                'name' => 'required|string',
                'jenis' => 'required|string',
                'other' => 'required_if:jenis,Other',
                'nip' => 'nullable|regex:/^[A-Za-z0-9 \-]+$/',
            ]);
            $jenis = $request->jenis === 'Other' ? $request->other : $request->jenis;

            Bendahara::create([
                'received_from' => $request->input('received_from'),
                'name' => $request->input('name'),
                'type' => $jenis,
                'nip' => $request->input('nip'),
                'userID' => $id

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
            'received_from' => 'required|string',
            'name' => 'required|string',
            'jenis' => 'required|string',
            'other' => 'required_if:jenis,Other',
            'nip' => 'nullable|regex:/^[A-Za-z0-9 \-]+$/',
        ]);
        $jenis = $request->jenis === 'Other' ? $request->other : $request->jenis;

        $bendahara = Bendahara::findOrFail($id);
        $bendahara->update([
            'received_from' => $request->input('received_from'),
            'name' => $request->input('name'),
            'nip' => $request->input('nip'),
            'type' => $jenis,
        ]);

        return redirect()->route('internal.bendahara.index')
            ->with('success', 'Data Bendahara berhasil diperbarui.');
    }
}
