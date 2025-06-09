<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use App\Models\Ppid;
use Illuminate\Http\Request;
use App\Mail\NotificationMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ServicesRequest;

class PpidController extends Controller
{
    public function create(Request $request)
    {
        $jenis = $request->query('jenis', 'permohonan');
        return view('user.form-ppid', compact('jenis'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
    $request->validate([
        'jenis' => 'required|in:permohonan,keberatan',
        'nama' => 'required|string|max:255',
        'no_hp' => 'required|numeric|regex:/^08[1-9][0-9]{8,9}$/',
        'email' => 'required|email', // tambahkan validasi email
        'alamat' => 'required|string|max:500',
        'file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
    ], [
        // ...pesan error...
        'email.required' => 'Email tidak boleh kosong.',
        'email.email' => 'Format email tidak valid.',
    ]);

    $filename = null;
    $path = 'uploads/ppid/';

    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filename = time() . '_ppid.' . $file->getClientOriginalExtension();
        $file->move(public_path($path), $filename);
    }

    $ppid = Ppid::create([
        'jenis' => $request->jenis,
        'nama' => $request->nama,
        'no_hp' => $request->no_hp,
        'email' => Auth::guard('user')->user()->email,
        'alamat' => $request->alamat,
        'file_upload' => $filename ? $path . $filename : null,
        'status' => $request->status,
    ]);

        // Kirim email notifikasi ke admin dan user
        $adminEmail = 'sinovacedisdik@gmail.com';
        Mail::to($adminEmail)->send(new NotificationMail($ppid));
        Mail::to($request->email)->send(new NotificationMail($ppid));

        // Kirim notifikasi ke semua admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new ServicesRequest($ppid, 'ppid'));
        }

        return redirect()->route('user.ppid.create')->with('success', 'Pengajuan PPID berhasil dikirim!');
    }
}
