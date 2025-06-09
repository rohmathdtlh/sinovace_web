<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lapor;
use App\Models\Komentar;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ServicesRequest;
use Illuminate\Support\Facades\Storage;

class KomentarController extends Controller
{
    public function store(Request $request, $tanggapan_id)
{
    // Validasi input
    $request->validate([
        'komentar' => 'required|string',
        'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        'parent_id' => 'nullable|exists:komentar,id', // Untuk balasan
    ]);

    // Ambil data tanggapan untuk mendapatkan lapor_id
    $tanggapan = Tanggapan::findOrFail($tanggapan_id);

    // Simpan komentar baru
    $komentar = new Komentar();
    $komentar->tanggapan_id = $tanggapan_id;
    $komentar->lapor_id = $tanggapan->lapor_id; // Isi lapor_id dari tanggapan
    $komentar->user_id = Auth::id();
    $komentar->komentar = $request->komentar;
    $komentar->parent_id = $request->parent_id; // Untuk balasan

    // Upload lampiran jika ada
    if ($request->hasFile('lampiran')) {
        $path = $request->file('lampiran')->store('lampiran_komentar', 'public');
        $komentar->file_path = $path; // <-- Ubah di sini
    }    

    $komentar->save();

    $lapor = Lapor::findOrFail($tanggapan->lapor_id);
    $user = $lapor->user;
    $user->notify(new ServicesRequest($komentar, 'pengaduan', 'komentar'));


    return redirect()->back()->with('success', 'Komentar berhasil dikirim!');
}
public function edit($id)
{
    // Ambil data komentar berdasarkan ID
    $komentar = Komentar::findOrFail($id);

    // Tampilkan view edit komentar dengan data komentar
    return view('admin.komentar.edit', compact('komentar'));
}

/**
 * Mengupdate komentar.
 */
public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'komentar' => 'required|string|max:1000',
        'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
    ]);

    // Ambil data komentar berdasarkan ID
    $komentar = Komentar::findOrFail($id);

    // Update data komentar
    $komentar->komentar = $request->komentar;

    // Jika ada file lampiran baru, hapus lampiran lama dan simpan yang baru
    if ($request->hasFile('lampiran')) {
        // Hapus lampiran lama jika ada
        if ($komentar->lampiran) {
            Storage::delete($komentar->lampiran);
        }

        // Simpan lampiran baru
        $path = $request->file('lampiran')->store('public/lampiran_komentar');
        $komentar->lampiran = $path;
    }

    // Simpan perubahan
    $komentar->save();

    // Redirect dengan pesan sukses
    return redirect()->route('admin.pengaduan.index')->with('success', 'Komentar berhasil diperbarui.');
}

/**
 * Menghapus komentar.
 */
public function destroy($id)
{
    // Ambil data komentar berdasarkan ID
    $komentar = Komentar::findOrFail($id);

    // Hapus lampiran jika ada
    if ($komentar->lampiran) {
        Storage::delete($komentar->lampiran);
    }

    // Hapus komentar
    $komentar->delete();

    // Redirect dengan pesan sukses
    return redirect()->route('admin.pengaduan.index')->with('success', 'Komentar berhasil dihapus.');
}
}
