<?php

namespace App\Http\Controllers;

use App\Models\buku;
use App\Models\kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class bukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check if a specific category is selected
    $kategoriId = $request->input('kategoriFilter');
    $query = buku::query();

    if (auth()->user()->isAdmin == 1) {
        // If the user is an admin, get all books or filter by selected category
        if (!empty($kategoriId)) {
            $query->where('kategoriId', $kategoriId);
        }
        $bukus = $query->with('kategoris')->get();
    } else {
        // If the user is not an admin, get books filtered by user ID and selected category
        $query->where('userId', auth()->user()->id);
        if (!empty($kategoriId)) {
            $query->where('kategoriId', $kategoriId);
        }
        $bukus = $query->with('kategoris')->get();
    }

    $kategoris = kategori::all();

    return view('dashboardPage.buku', [
        'page' => 'Buku'
    ])->with(compact('kategoris', 'bukus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'kategoriId' => 'required',
            'deskripsi' => 'required',
            'jumlah' => 'required',
            'file' => 'required|mimes:pdf',
            'thumnail' => 'required|image|mimes:jpeg,jpg,png'
        ]);

        $validatedData['userId'] = auth()->user()->id;

        if ($request->file('thumnail')) {
            $validatedData['thumnail'] = $request->file('thumnail')->store('thumnail-buku');
        }

        if ($request->file('file')) {
            $validatedData['file'] = $request->file('file')->store('file-buku');
        }

        $validatedData['jumlah'] = intval($request->jumlah);

        buku::create($validatedData);

        return redirect('/')->with('success', 'Buku berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'judul' => 'required|max:255',
            'kategoriId' => 'required',
            'deskripsi' => 'required',
            'jumlah' => 'required',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('file')) {
            if ($request->oldFile) {
                Storage::delete($request->oldFile);
            }
            $validatedData['file'] = $request->file('file')->store('file-buku');
        }

        if ($request->file('thumnail')) {
            if ($request->oldThumnail) {
                Storage::delete($request->oldThumnail);
            }
            $validatedData['thumnail'] = $request->file('thumnail')->store('thumnail-buku');
        }

        buku::where('id', $id)->update($validatedData);
        return redirect('/')->with('success', 'Buku berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = buku::whereId($id)->first();
        if ($buku->thumnail) {
            Storage::delete($buku->thumnail);
        }
        if ($buku->file) {
            Storage::delete($buku->file);
        }
        buku::destroy($id);
        return redirect('/')->with('success', "buku $buku->name berhasil dihapus!");
    }
}
