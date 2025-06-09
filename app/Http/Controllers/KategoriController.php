<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengaduan;
use App\Models\SubKategoriPengaduan;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Menampilkan halaman utama (index)
    public function index()
    {
        $kategoris = KategoriPengaduan::with('subKategori')->get();
        return view('kategori.index', compact('kategoris'));
    }

    // Menampilkan form tambah kategori
    public function create()
    {
        return view('kategori.create', ['mode' => 'kategori']);
    }

    // Menampilkan form tambah sub kategori
    public function createSub()
    {
        $kategoris = KategoriPengaduan::all();
        return view('kategori.create', ['mode' => 'sub', 'kategoris' => $kategoris]);
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        KategoriPengaduan::create($request->only('nama_kategori'));

        return redirect()->route('kategori.index')->with('status', 'Kategori berhasil ditambahkan!');
    }

    // Menyimpan sub kategori baru
    public function storeSub(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_pengaduan,id',
            'nama_sub_kategori' => 'nullable|string|max:255',
        ]);
        
        if ($request->filled('nama_sub_kategori')) {
            SubKategoriPengaduan::create($request->only('kategori_id', 'nama_sub_kategori'));
        }
        

        SubKategoriPengaduan::create($request->only('kategori_id', 'nama_sub_kategori'));

        return redirect()->route('kategori.index')->with('success', 'Sub Kategori berhasil ditambahkan.');
    }

    // Menampilkan form edit kategori
    public function edit(KategoriPengaduan $kategori)
{
    $kategori->load('subKategori'); // ambil sub kategorinya juga
    return view('kategori.edit', ['kategori' => $kategori]);
}

public function updateGabungan(Request $request, KategoriPengaduan $kategori)
{
    $request->validate([
        'nama_kategori' => 'required|string|max:255',
        'sub_ids' => 'nullable|array',
        'sub_nama' => 'nullable|array',
    ]);

    // Update kategori utama
    $kategori->update(['nama_kategori' => $request->nama_kategori]);

    // Cek jika sub_ids dikirim dan merupakan array
    foreach ($request->sub_ids ?? [] as $index => $id) {
        $sub = SubKategoriPengaduan::find($id);

        if ($sub && isset($request->sub_nama[$index]) && filled($request->sub_nama[$index])) {
            $sub->update([
                'nama_sub_kategori' => $request->sub_nama[$index]
            ]);
        }
    }

    return redirect()->route('kategori.index')->with('success', 'Kategori dan sub kategori berhasil diperbarui.');
}


public function editSub(SubKategoriPengaduan $subKategori)
{
    $kategoris = KategoriPengaduan::all();
    return view('kategori.edit', ['mode' => 'sub', 'data' => $subKategori, 'kategoris' => $kategoris]);
}

    // Mengupdate kategori
    public function update(Request $request, KategoriPengaduan $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori->update($request->only('nama_kategori'));

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    // Mengupdate sub kategori
    public function updateSub(Request $request, SubKategoriPengaduan $subKategori)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_pengaduan,id',
            'nama_sub_kategori' => 'nullable|string|max:255',
        ]);
        
        $subKategori->update($request->only('kategori_id', 'nama_sub_kategori'));
        

        $subKategori->update($request->only('kategori_id', 'nama_sub_kategori'));

        return redirect()->route('kategori.index')->with('success', 'Sub Kategori berhasil diperbarui.');
    }

    // Menghapus kategori
    public function destroy(KategoriPengaduan $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

    // Menghapus sub kategori
    public function destroySub(SubKategoriPengaduan $subKategori)
{
    $subKategori->delete();
    return redirect()->route('kategori.edit', $subKategori->kategori_id)->with('success', 'Sub Kategori berhasil dihapus.');
}

}