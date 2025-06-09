<?php

namespace App\Http\Controllers\admin;

use App\Models\Lapor;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use App\Models\KategoriPengaduan;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ServicesRequest;
use Illuminate\Support\Facades\Storage;

class TanggapanController extends Controller
{
    // Method umum untuk menampilkan tanggapan berdasarkan kategori
    private function getTanggapanByKategori($kategoriId)
    {
        // Ambil kategori berdasarkan ID
        $kategori = KategoriPengaduan::findOrFail($kategoriId);

        // Ambil laporan yang sesuai dengan kategori, termasuk sub kategori
        $lapors = Lapor::with(['kategori', 'subKategori', 'lampiranPengaduan', 'tanggapans'])
                       ->where('kategori_id', $kategori->id)
                       ->paginate(3);

        return view('admin.tanggapan.index', compact('lapors', 'kategori'));
    }

    // Method untuk menampilkan semua laporan tanpa filter kategori
   public function index()
{
    $user = Auth::user();

    if ($user->kategori_id) {
        // Admin khusus kategori
        $lapors = Lapor::with(['kategori', 'subKategori', 'lampiranPengaduan', 'tanggapans'])
                       ->where('kategori_id', $user->kategori_id)
                       ->whereIn('status', ['pending', 'diproses'])
                       ->paginate(3);
    } else {
        // Admin pusat
        $lapors = Lapor::with(['kategori', 'subKategori', 'lampiranPengaduan', 'tanggapans'])
                       ->whereIn('status', ['pending', 'diproses'])
                       ->paginate(3);
    }

    return view('admin.tanggapan.index', compact('lapors'));
}


    // Method untuk menampilkan form edit tanggapan
    public function edit($id)
    {
        $tanggapan = Tanggapan::findOrFail($id);
        return view('admin.tanggapan.edit', compact('tanggapan'));
    }

    // Method untuk menyimpan perubahan tanggapan
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggapan' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        $tanggapan = Tanggapan::findOrFail($id);
        
        // Hapus file lama jika ada file baru yang diupload
        if ($request->hasFile('file')) {
            if ($tanggapan->file_path) {
                Storage::disk('public')->delete($tanggapan->file_path);
            }
            $filePath = $request->file('file')->store('tanggapan_files', 'public');
        } else {
            $filePath = $tanggapan->file_path;
        }

        $tanggapan->update([
            'tanggapan' => $request->tanggapan,
            'file_path' => $filePath,
        ]);

        return redirect()->route('admin.tanggapan.byKategori', $tanggapan->lapor->kategori_id)
                         ->with('success', 'Tanggapan berhasil diperbarui!');
    }

    // Method untuk menghapus tanggapan
    public function destroy($id)
    {
        $tanggapan = Tanggapan::findOrFail($id);

        if ($tanggapan->file_path) {
            Storage::disk('public')->delete($tanggapan->file_path);
        }

        $kategoriId = $tanggapan->lapor->kategori_id;
        $tanggapan->delete();

        return redirect()->route('admin.tanggapan.byKategori', $kategoriId)
                         ->with('success', 'Tanggapan berhasil dihapus!');
    }

    // Method untuk menampilkan laporan berdasarkan kategori
 public function byKategori($kategoriId)
{
    try {
        $user = Auth::user();

        // Jika admin khusus kategori dan mencoba akses kategori lain
        if ($user->kategori_id && $user->kategori_id != $kategoriId) {
            abort(403, 'Anda tidak memiliki akses ke kategori ini.');
        }

        $kategori = KategoriPengaduan::findOrFail($kategoriId);

        $lapors = Lapor::with(['kategori', 'subKategori', 'lampiranPengaduan', 'tanggapans'])
            ->where('kategori_id', $kategori->id)
            ->paginate(3);

        return view('admin.tanggapan.index', compact('lapors', 'kategori'));
    } catch (\Throwable $e) {
        Log::error('Error di byKategori: '.$e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json([
            'error' => true,
            'message' => $e->getMessage()
        ], 500);
    }
}


    public function store(Request $request, $laporId)
    {
        $lapor = Lapor::findOrFail($laporId);

        if ($lapor->status === 'ditutup') {
            return redirect()->back()->with('error', 'Laporan ini sudah ditutup dan tidak bisa ditanggapi lagi.');
        }

        $existingTanggapan = $lapor->tanggapans()->first();

        if ($existingTanggapan && $existingTanggapan->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Laporan ini sudah ditanggapi oleh admin lain.');
        }

        if ($existingTanggapan && $existingTanggapan->user_id === Auth::id()) {
            return redirect()->back()->with('info', 'Anda sudah memberikan tanggapan pada laporan ini.');
        }

        $request->validate([
            'tanggapan' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        // Simpan tanggapan dan simpan ke variabel
        $tanggapan = Tanggapan::create([
            'lapor_id' => $laporId,
            'user_id' => Auth::id(),
            'tanggapan' => $request->tanggapan,
            'file_path' => $request->hasFile('file') ? $request->file('file')->store('tanggapan_files', 'public') : null,
        ]);

        if ($lapor->status === 'pending') {
            $lapor->update(['status' => 'diproses']);
        }

        // Kirim notifikasi ke user yang membuat laporan
        $user = $lapor->user;
        $user->notify(new ServicesRequest($tanggapan, 'pengaduan', 'tanggapan'));

        return redirect()->back()->with('success', 'Tanggapan berhasil dikirim!');
    }

}