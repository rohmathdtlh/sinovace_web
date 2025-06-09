<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\KategoriPengaduan; // <- Tambahkan ini
use Illuminate\Http\Request;
use App\Models\IzinPenelitian;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Sebelumnya:
        // $akun_admin = User::whereIn('role', ['admin', 'operator'])
        
        // Setelah dihilangkan operator:
        $akun_admin = User::where('role', 'admin')
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->paginate(10);

        return view('admin.akun_admin.index', compact('akun_admin'));
    }


    public function adminregist()
    {
        // Ambil semua data kategori pengaduan dan kirim ke view
        $kategoriList = KategoriPengaduan::all();
        return view('auth.admin-registration', compact('kategoriList'));
    }

public function adminregistProcess(Request $request)
{
    try {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'kategori_id' => 'nullable|exists:kategori_pengaduan,id',
        ], [
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['role'] = 'admin';

        if ($request->kategori_id) {
            $data['kategori_id'] = $request->kategori_id;
        }

        $user = User::create($data);

        return redirect()->route('admin.akun_admin')->with('success', 'Admin berhasil ditambahkan.');
    } catch (\Throwable $e) {
        return back()->withErrors(['error' => $e->getMessage()]);
    }
}

    public function showNotifications()
    {
        $user = Auth::guard('admin')->user();
        $notifications = $user->notifications;
        return view('admin.notifications', compact('notifications'));
    }

    public function markAsRead()
    {
        foreach (Auth::user()->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        return back()->with('success', 'Semua notifikasi ditandai sebagai dibaca.');
    }

    public function deleteRead()
    {
        Auth::user()->readNotifications->each->delete();
        return redirect()->back()->with('success', 'Notifikasi yang sudah dibaca berhasil dihapus.');
    }

 public function destroy($id)
{
    $user = User::findOrFail($id);

    // Cegah operator menghapus akun siapa pun
    if (Auth::user()->kategori_id !== null) {
        return back()->with('error', 'Operator tidak diizinkan menghapus akun.');
    }

    // Cegah admin menghapus dirinya sendiri
    if (Auth::user()->id == $id) {
        return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
    }

    $user->delete();
    return back()->with('success', 'Akun berhasil dihapus.');
}

    public function akunUser()
    {
        $akun_user = User::where('role', 'user')->paginate(10);
        return view('admin.akun_user.index', compact('akun_user'));
    }
    public function hapusUser($id)
{
    $user = User::findOrFail($id);

    if (Auth::id() === $user->id) {
        return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
    }

    if ($user->role !== 'user') {
        return redirect()->back()->with('error', 'Anda hanya dapat menghapus akun dengan role user.');
    }

    // Hapus izin penelitian yang emailnya sama dengan user email
    \App\Models\IzinPenelitian::where('email', $user->email)->delete();

    // Hapus pengaduan yang user_id nya sama
    \App\Models\Lapor::where('user_id', $user->id)->delete();

    // Hapus user
    $user->delete();

    return redirect()->route('admin.akun_user')->with('success', 'Akun user dan data terkait berhasil dihapus.');
}

}
