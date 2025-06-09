<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lapor;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Menampilkan form rating
     */
    public function create($id)
    {
        $pengaduan = Lapor::with(['tanggapans.user', 'ratings'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['selesai', 'ditutup']) // ✅ ini diperbaiki
            ->firstOrFail();

        // Cek apakah sudah pernah rating
        if ($pengaduan->ratings->where('user_id', Auth::id())->count() > 0) {
            return redirect()
                ->route('user.pengaduan.show', $id)
                ->with('info', 'Anda sudah memberikan rating untuk pengaduan ini.');
        }

        // Ambil admin yang menangani (dari tanggapan pertama)
        $admin = $pengaduan->tanggapans->first()->user ?? null;

        return view('user.pengaduan.rating', [
            'pengaduan' => $pengaduan,
            'admin' => $admin
        ]);
    }

    /**
     * Menyimpan rating
     */
    public function store(Request $request, $id)
    {

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'admin_id' => 'required|exists:users,id',
        ]);

        $pengaduan = Lapor::where('id', $id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['selesai', 'ditutup']) // ✅ ini juga diperbaiki
            ->firstOrFail();

        if (Rating::where('lapor_id', $id)->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Anda sudah memberikan rating untuk pengaduan ini.');
        }

        Rating::create([
            'lapor_id' => $pengaduan->id,
            'user_id' => Auth::id(),
            'admin_id' => $request->admin_id,
            'rating' => $request->rating,
            'komentar' => $request->komentar, // opsional kalau kamu pakai komentar
        ]);

        return redirect()->route('user.pengaduan.index')
            ->with('success', 'Terima kasih atas penilaian Anda!');
    }
}
