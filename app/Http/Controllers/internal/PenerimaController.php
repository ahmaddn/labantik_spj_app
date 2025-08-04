<?php

namespace App\Http\Controllers\internal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penerima;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PenerimaController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $penerima = Penerima::where('userID', $id)->get();
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
            $id = Auth::id();
            $request->validate([
                'name' => 'required|unique:penerima,name',
                'nip' => 'required|regex:/^[A-Za-z0-9 \-]+$/|unique:penerima,nip',
                'position' => 'required|string',
            ]);

            Penerima::create([
                'name' => $request->input('name'),
                'nip' => $request->input('nip'),
                'position' => $request->input('position'),
                'userID' => $id
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
        $user = Auth::user();

        return view('internal.penerima.edit', [
            'penerima' => $penerima,
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|',
            'nip' => 'required|regex:/^[A-Za-z0-9 \-]+$/|unique:penerima,nip,' . $id,
            'position' => 'required|string',
        ]);

        $penerima = Penerima::findOrFail($id);
        $penerima->update([
            'name' => $request->input('name'),
            'nip' => $request->input('nip'),
            'position' => $request->input('position'),
        ]);

        return redirect()->route('internal.penerima.index')
            ->with('success', 'Data Penerima berhasil diperbarui.');
    }
}
