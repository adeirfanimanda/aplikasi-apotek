<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // jumlah data yang ditampilkan per paginasi halaman
        $pagination = 10;

        if ($request->search) {
            // menampilkan pencarian data
            $categories = Category::select('id', 'name')
                ->where('name', 'LIKE', '%' . $request->search . '%')
                ->paginate($pagination)
                ->withQueryString();
        } else {
            // menampilkan semua data
            $categories = Category::select('id', 'name')
                ->latest()
                ->paginate($pagination);
        }

        // tampilkan data ke view
        return view('categories.index', compact('categories'))->with('i', ($request->input('page', 1) - 1) * $pagination);
    }

    public function create()
    {
        // tampilkan form add data
        return view('categories.create');
    }

    public function store(Request $request)
    {
        // validasi form
        $request->validate([
            'name' => 'required|unique:categories'
        ]);

        // create data
        Category::create([
            'name' => $request->name
        ]);

        // redirect ke halaman index dan tampilkan pesan berhasil simpan data
        return redirect()->route('categories.index')->with(['success' => 'The new category has been saved.']);
    }


    public function edit(string $id)
    {
        // get data by ID
        $category = Category::findOrFail($id);

        // tampilkan form edit data
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        // validasi form
        $request->validate([
            'name' => 'required|unique:categories,name,' . $id
        ]);

        // get data by ID
        $category = Category::findOrFail($id);

        // update data
        $category->update([
            'name' => $request->name
        ]);

        // redirect ke halaman index dan tampilkan pesan berhasil ubah data
        return redirect()->route('categories.index')->with(['success' => 'The category has been updated.']);
    }

    public function destroy($id)
    {
        // get data by ID
        $category = Category::findOrFail($id);

        // delete data
        $category->delete();

        // redirect ke halaman index dan tampilkan pesan berhasil hapus data
        return redirect()->route('categories.index')->with(['success' => 'The category has been deleted!']);
    }
}
