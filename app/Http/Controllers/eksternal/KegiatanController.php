<?php

namespace App\Http\Controllers\eksternal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kegiatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class KegiatanController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $kegiatan = Kegiatan::where('userID', $id)->get();
        return view('eksternal.kegiatan.index', compact('kegiatan'));
    }

    public function add()
    {
        return view('eksternal.kegiatan.add');
    }

    public function addKegiatan(Request $request)
    {
        if ($request->isMethod('post')) {
            $id = Auth::id();
            $request->validate([
                'name' => 'required|string|max:255',
                'order' => 'required|date',
                'deadline' => 'required|date|after_or_equal:' . $request->order,
                'info' => 'nullable|string|max:255',
            ]);
            Kegiatan::create([
                'name' => $request->input('name'),
                'order' => $request->input('order'),
                'deadline' => $request->input('deadline'),
                'info' => $request->input('info'),
                'userID' => $id
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
            'deadline' => 'required|date|after_or_equal:' . $request->order,
            'info' => 'nullable|string|max:255',
        ]);

        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->update([
            'name' => $request->input('name'),
            'order' => $request->input('order'),
            'deadline' => $request->input('deadline'),
            'info' => $request->input('info'),
        ]);

        return redirect()->route('eksternal.kegiatan.index')
            ->with('success', 'Data Kegiatan berhasil diperbarui.');
    }
}
