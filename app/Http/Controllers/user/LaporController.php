<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use App\Models\Lapor;
use Illuminate\Http\Request;
use App\Models\KategoriPengaduan;
use App\Models\LampiranPengaduan;
use App\Http\Controllers\Controller;
use App\Models\SubKategoriPengaduan;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ServicesRequest;
use Illuminate\Support\Facades\Storage;

class LaporController extends Controller
{
    public function index(Request $request)
    {
        // Pastikan hanya user yang login bisa akses
        if (!auth('user')->check()) {
            return redirect()->route('login');
        }
    
        $kategoriPengaduan = KategoriPengaduan::with('subKategori')->get();
        
        $lapors = Lapor::where('user_id', auth('user')->id())
            ->when($request->cari, function($query) use ($request) {
                return $query->where('judul', 'like', '%'.$request->cari.'%');
            })
            ->with(['tanggapans' => function($query) {
                $query->with(['komentars', 'user']);
            }, 'ratings'])
            ->orderBy('created_at', 'desc')
            ->paginate(3);
    
        return view('user.pengaduan.index', compact('kategoriPengaduan', 'lapors'));
    }

    public function getSubKategori($kategori_id)
    {
        $subKategori = SubKategoriPengaduan::where('kategori_id', $kategori_id)->get();
        return response()->json($subKategori);
    }

    public function store(Request $request)
    {
        if (!Auth::guard('user')->check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk mengirim pengaduan.');
        }
    
        // Validasi input
        $request->validate([
            'kategori_or_subkategori_id' => 'required',
            'judul' => 'required|string|max:255',
            'lokasi_kejadian' => 'required|string|max:255',
            'tanggal_kejadian' => 'required|date',
            'deskripsi' => 'required|string',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        // Pisahkan kategori_id dan subkategori_id dari input
        $kategoriData = explode('-', $request->kategori_or_subkategori_id);
        $kategoriType = $kategoriData[0]; // 'kategori' atau 'sub'
        $kategoriId = $kategoriData[1]; // ID kategori atau subkategori

        // Jika yang dipilih adalah sub kategori, ambil kategori_id dari sub kategori
        if ($kategoriType == 'sub') {
            $subKategori = SubKategoriPengaduan::find($kategoriId);
            $kategoriId = $subKategori->kategori_id; // Ambil kategori_id dari sub kategori
        }

        // Simpan data ke tabel `lapors`
        $lapor = Lapor::create([
            'user_id' => Auth::id(),
            'kategori_id' => $kategoriId, // Kategori ID yang sesuai
            'sub_kategori_id' => $kategoriType == 'sub' ? $kategoriData[1] : null, // Sub kategori ID jika ada
            'judul' => $request->judul,
            'lokasi_kejadian' => $request->lokasi_kejadian,
            'tanggal_kejadian' => $request->tanggal_kejadian,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending',
        ]);

        // Jika ada lampiran, simpan ke tabel `lampiran_pengaduan`
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran_pengaduan', 'public');

            LampiranPengaduan::create([
                'lapor_id' => $lapor->id,
                'file_path' => $lampiranPath,
            ]);
        }

        $user = Auth::user();  // Ambil user yang sedang login

        $data = [
            'nama' => $user->name,
            'judul' => $request->judul,
            'isi' => $request->isi,
        ];
      

        // Kirim notifikasi ke semua admin
        // $admins = User::where('role', 'admin')
        //     ->whereNull('kategori_id') // hanya admin utama
        //     ->get();

        // foreach ($admins as $admin) {
        //     $admin->notify(new ServicesRequest($data, 'pengaduan'));
        // }

        return redirect()->route('user.pengaduan.index')->with('success', 'Pengaduan berhasil dikirim!');
    }

    public function show($id)
    {
        $kategoriPengaduan = KategoriPengaduan::with('subKategori')->get();
    
        // Jika belum login sebagai user, redirect ke login
        if (!auth('user')->check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat detail pengaduan Anda.');
        }
    
        $pengaduan = Lapor::with(['tanggapans.user', 'ratings.admin', 'lampiranPengaduan'])
            ->where('id', $id)
            ->where('user_id', auth('user')->id())
            ->firstOrFail();
    
        $lapors = Lapor::where('user_id', auth('user')->id())
            ->with(['tanggapans' => function ($query) {
                $query->with(['komentars', 'user']);
            }, 'ratings'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // $lapor = Lapor::with('tanggapans')->findOrFail($id);
        // return view('view_name', [
        //     'lapor' => $lapor,
        //     'isClosed' => $lapor->status === 'closed' // Contoh: Sesuaikan dengan logika status Anda
        // ]);

        return view('user.pengaduan.index', compact('kategoriPengaduan', 'pengaduan', 'lapors'));
    }


   // Menampilkan form edit pengaduan
   public function edit($id)
   {
       $pengaduan = Lapor::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
       $kategoriPengaduan = KategoriPengaduan::with('subKategori')->get();
       return view('user.pengaduan.edit', compact('pengaduan', 'kategoriPengaduan'));
   }

   // Menyimpan perubahan pengaduan
   public function update(Request $request, $id)
   {
       $request->validate([
           'judul' => 'required|string|max:255',
           'lokasi_kejadian' => 'required|string|max:255',
           'tanggal_kejadian' => 'required|date',
           'deskripsi' => 'required|string',
           'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
       ]);

       $pengaduan = Lapor::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

       $pengaduan->update([
           'judul' => $request->judul,
           'lokasi_kejadian' => $request->lokasi_kejadian,
           'tanggal_kejadian' => $request->tanggal_kejadian,
           'deskripsi' => $request->deskripsi,
       ]);

       if ($request->hasFile('lampiran')) {
        // Hapus lampiran lama jika ada
        $lampiranLama = $pengaduan->lampiranPengaduan()->first();
        if ($lampiranLama) {
            Storage::disk('public')->delete($lampiranLama->file_path);
            $lampiranLama->delete();
        }
    
        // Simpan lampiran baru
        $lampiranPath = $request->file('lampiran')->store('lampiran_pengaduan', 'public');
        $pengaduan->lampiranPengaduan()->create([
            'file_path' => $lampiranPath,
        ]);
    }
    

       return redirect()->route('user.pengaduan.index')->with('success', 'Pengaduan berhasil diperbarui.');
   }

   // Menampilkan form konfirmasi hapus pengaduan
   public function delete($id)
   {
       $pengaduan = Lapor::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
       return view('user.pengaduan.delete', compact('pengaduan'));
   }

   // Menghapus pengaduan
   public function destroy($id)
   {
       $pengaduan = Lapor::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

       if ($pengaduan->lampiran) {
           Storage::disk('public')->delete($pengaduan->lampiran);
       }

       $pengaduan->delete();
       return redirect()->route('user.pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
   }
   public function tutup($id)
    {
        $pengaduan = Lapor::where('user_id', Auth::id())
            ->where('id', $id)
            ->whereNotIn('status', ['ditutup', 'selesai'])
            ->firstOrFail();

        $pengaduan->update(['status' => 'selesai']);

        return redirect()
        ->back()
        ->with('success', 'Pengaduan berhasil ditutup. Silakan beri penilaian untuk pelayanan kami.');    
    }
}