<?php

namespace App\Http\Controllers\eksternal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kegiatan;
use Illuminate\Support\Facades\Session;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::all();
        return view('eksternal.kegiatan.index', compact('kegiatan'));
    }

    public function add()
    {
        return view('eksternal.kegiatan.add');
    }

    public function addKegiatan(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'order' => 'required|date',
                'accepted' => 'required|date|after_or_equal:order',
                'completed' => 'required'    ,
                'info' => 'nullable|string|max:255',
            ]);
     Kegiatan::create([
                'name' => $request->input('name'),
                'order' => $request->input('order'),
                'accepted' => $request->input('accepted'),
                'completed' => $request->input('completed'),
                'info' => $request->input('info'),
            ]);

            return redirect()->route('eksternal.kegiatan.index')
                             ->with('success', 'Data Kegiatan berhasil ditambahkan.');
        }

        return redirect()->back();
    }

    public function deleteKegiatan($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->delete();

        return redirect()->route('eksternal.kegiatan.index')
                         ->with('success', 'Data Kegiatan berhasil dihapus.');
    }

    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        return view('eksternal.kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|date',
            'accepted' => 'required|date|after_or_equal:order',
            'completed' => 'required|date_format:H:i:s',
            'info' => 'nullable|string|max:255',
        ]);

        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->update([
            'name' => $request->input('name'),
            'order' => $request->input('order'),
            'accepted' => $request->input('accepted'),
            'completed' => $request->input('completed'),
            'info' => $request->input('info'),
        ]);

        return redirect()->route('eksternal.kegiatan.index')
                         ->with('success', 'Data Kegiatan berhasil diperbarui.');
    }
}
