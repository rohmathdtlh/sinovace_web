<?php

namespace App\Http\Controllers\User;

use App\Models\Ppid;

use App\Models\IzinPenelitian;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();  // Ambil data pengguna yang sedang login
        
        // Ambil data izin penelitian berdasarkan user_id yang sedang login
        $izin_penelitian = IzinPenelitian::where('email', $user->email)->get();
        $ppid = Ppid::where('email', $user->email)->get();
        

        // Kembalikan ke view dengan membawa data user dan izin_penelitian$izin_penelitian
        return view('user.profil', compact('user', 'izin_penelitian', 'ppid'));
    }
}





