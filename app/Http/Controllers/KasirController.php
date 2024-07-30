<?php

namespace App\Http\Controllers;

use App\Models\Kasir;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index(Request $request)
    {
        // jumlah data yang ditampilkan per paginasi halaman
        $pagination = 10;

        if ($request->search) {
            // menampilkan pencarian data
            $kasirs = Kasir::select('id', 'name', 'address', 'phone')
                ->whereAny(['name', 'address', 'phone'], 'LIKE', '%' . $request->search . '%')
                ->paginate($pagination)
                ->withQueryString();
        } else {
            // menampilkan semua data
            $kasirs = Kasir::select('id', 'name', 'address', 'phone')
                ->latest()
                ->paginate($pagination);
        }

        // tampilkan data ke view
        return view('kasirs.index', compact('kasirs'))->with('i', ($request->input('page', 1) - 1) * $pagination);
    }

    public function create()
    {
        // tampilkan form add data
        return view('kasirs.create');
    }

    public function store(Request $request)
    {
        // validasi form
        $request->validate([
            'name'    => 'required',
            'address' => 'required',
            'phone'   => 'required|max:13|unique:kasirs'
        ]);

        // create data
        Kasir::create([
            'name'    => $request->name,
            'address' => $request->address,
            'phone'   => $request->phone
        ]);

        // redirect ke halaman index dan tampilkan pesan berhasil simpan data
        return redirect()->route('kasirs.index')->with(['success' => 'The new kasir has been saved.']);
    }

    public function edit(string $id)
    {
        // get data by ID
        $kasir = Kasir::findOrFail($id);

        // tampilkan form edit data
        return view('kasirs.edit', compact('kasir'));
    }

    public function update(Request $request, $id)
    {
        // validasi form
        $request->validate([
            'name'    => 'required',
            'address' => 'required',
            'phone'   => 'required|max:13|unique:kasirs,phone,' . $id
        ]);

        // get data by ID
        $kasir = Kasir::findOrFail($id);

        // update data
        $kasir->update([
            'name'    => $request->name,
            'address' => $request->address,
            'phone'   => $request->phone
        ]);

        // redirect ke halaman index dan tampilkan pesan berhasil ubah data
        return redirect()->route('kasirs.index')->with(['success' => 'The kasir has been updated.']);
    }

    public function destroy($id)
    {
        // get data by ID
        $kasir = Kasir::findOrFail($id);

        // delete data
        $kasir->delete();

        // redirect ke halaman index dan tampilkan pesan berhasil hapus data
        return redirect()->route('kasirs.index')->with(['success' => 'The kasir has been deleted!']);
    }
}
