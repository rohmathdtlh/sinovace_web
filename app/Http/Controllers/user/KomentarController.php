<?php

namespace App\Http\Controllers\user;

use App\Models\Lapor;
use App\Models\Komentar;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KomentarController extends Controller
{
     // Menyimpan balasan user
     public function store(Request $request, $tanggapan_id)
    {
        // Validasi input
        $request->validate([
            'komentar' => 'required|string',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
            'parent_id' => 'nullable|exists:komentars,id', // Untuk balasan
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
            $komentar->file_path = $path;
        }

        $komentar->save();

        return redirect()->back()->with('success', 'Komentar berhasil dikirim!');
    }
}
