<?php

namespace App\Http\Controllers\internal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kepsek;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class KepsekController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $kepsek = Kepsek::where('userID', $id)->get(); // Ambil semua data kepala sekolah dari database
        return view('internal.kepsek.index', compact('kepsek'));
    }

    public function add()
    {
        return view('internal.kepsek.add');
    }
    public function addKepsek(Request $request)
    {
        if ($request->isMethod('post')) {
            // Validasi input
            $id = Auth::id();
            $request->validate([
                'name' => 'required',
                'nip' => 'nullable|unique:kepsek,nip|regex:/^[A-Za-z0-9 \-]+$/',
                'year' => 'required',
                'school' => 'required|string',
                'address' => 'required|string',
            ]);

            // Menyimpan data ke database
            Kepsek::create([
                'name' => $request->input('name'),
                'nip' => $request->input('nip'),
                'year' => $request->input('year'),
                'school' => $request->input('school'),
                'address' => $request->input('address'),
                'userID' => $id
            ]);

            // Redirect ke halaman index
            return redirect()->route('internal.kepsek.index')
                ->with('success', 'Data Kepsek berhasil ditambahkan.');
        }

        // Menyiapkan data untuk halaman form input
        $data['user'] = User::find(Session::get('userid'));

        return view('internal.kepsek.formkepsek', $data); // ✅ arahkan ke form
    }



    public function deleteKepsek($id)
    {
        $kepsek = Kepsek::findOrFail($id);
        $kepsek->delete();

        return redirect()->route('internal.kepsek.index')->with('success', 'Data Kepsek berhasil dihapus.');
    }


    public function edit($id)
    {
        $kepsek = Kepsek::findOrFail($id);
        $user = Auth::user(); // atau sesuaikan jika pakai session

        return view('internal.kepsek.edit', [
            'kepsek' => $kepsek,
            'user' => $user,
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'nip' => 'required|regex:/^[A-Za-z0-9 \-]+$/',
            'school' => 'nullable|numeric',
            'address' => 'required',
        ]);

        $kepsek = Kepsek::findOrFail($id);
        $kepsek->update([
            'name' => $request->input('name'),
            'nip' => $request->input('nip'),
            'school' => $request->input('school'),
            'address' => $request->input('address'),
        ]);

        return redirect()->route('internal.kepsek.index')
            ->with('success', 'Data Kepsek berhasil diperbarui.');
    }
}
