<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\NotificationMail;
use App\Models\IzinPenelitian;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Notifications\ServicesRequest;

class IzinPenelitianController extends Controller
{
    public function create()
    {
        return view('user.form-izin-penelitian');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|numeric|regex:/^08[1-9][0-9]{8,9}$/',
            'sr_kesbangpol' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'sip_kampus_lembaga' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ], [
            'nama.required' => 'Nama Tidak Boleh Kosong',
            'nama.max' => 'Nama Tidak Boleh Lebih dari 100 karakter',
            'no_hp.required' => 'Nomor HP Tidak Boleh Kosong',
            'no_hp.numeric' => 'Nomor HP harus berupa Angka',
            'no_hp.regex' => 'Nomor HP tidak valid. Harus diawali dengan 08 dan diikuti dengan 11-12 digit angka.',
            'email.required' => 'E-mail Tidak Boleh Kosong',
            'email.email' => 'Format E-mail tidak valid.',
            'sr_kesbangpol.required' => 'File Tidak Boleh Kosong',
            'sr_kesbangpol.file' => 'File harus berupa file yang valid.',
            'sr_kesbangpol.mimes' => 'File harus berupa pdf, jpg, jpeg, png, doc, atau docx.',
            'sr_kesbangpol.max' => 'Ukuran file tidak boleh lebih dari 10 MB.',
            'sip_kampus_lembaga.required' => 'File Tidak Boleh Kosong',
            'sip_kampus_lembaga.file' => 'File harus berupa file yang valid.',
            'sip_kampus_lembaga.mimes' => 'File harus berupa pdf, jpg, jpeg, png, doc, atau docx.',
            'sip_kampus_lembaga.max' => 'Ukuran file tidak boleh lebih dari 10 MB.',
        ]);

        $filename_sr_kesbangpol = NULL;
        $path_sr_kesbangpol = NULL;

        $filename_sip_kampus_lembaga = NULL;
        $path_sip_kampus_lembaga = NULL;

        if ($request->hasFile('sr_kesbangpol')) {
            $file_sr_kesbangpol = $request->file('sr_kesbangpol');
            $extension_sr_kesbangpol = $file_sr_kesbangpol->getClientOriginalExtension();
            
            $filename_sr_kesbangpol = time() . '_sr_kesbangpol.' . $extension_sr_kesbangpol;
            $path_sr_kesbangpol = 'uploads/izin_penelitian/sr_kesbangpol/';
            $file_sr_kesbangpol->move($path_sr_kesbangpol, $filename_sr_kesbangpol);
        }

        if ($request->hasFile('sip_kampus_lembaga')) {
            $file_sip_kampus_lembaga = $request->file('sip_kampus_lembaga');
            $extension_sip_kampus_lembaga = $file_sip_kampus_lembaga->getClientOriginalExtension();
            
            $filename_sip_kampus_lembaga = time() . '_sip_kampus_lembaga.' . $extension_sip_kampus_lembaga;
            $path_sip_kampus_lembaga = 'uploads/izin_penelitian/sip_kampus_lembaga/';
            $file_sip_kampus_lembaga->move($path_sip_kampus_lembaga, $filename_sip_kampus_lembaga);
        }

        $izinPenelitian = IzinPenelitian::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'email' => Auth::guard('user')->user()->email,
            'sr_kesbangpol' => $path_sr_kesbangpol.$filename_sr_kesbangpol,
            'sip_kampus_lembaga' => $path_sip_kampus_lembaga.$filename_sip_kampus_lembaga,
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Mengirim email notifikasi ke admin
        $adminEmail = 'sinovacedisdik@gmail.com';  // Ganti dengan email admin yang sesuai
        Mail::to($adminEmail)->send(new NotificationMail($izinPenelitian));
        // Mengirim email konfirmasi ke pengguna
        Mail::to($request->email)->send(new NotificationMail($izinPenelitian));

        // Tentukan jenis formulir
        if ($request->has('surat_lama')) {
            $formType = 'mutasi';
        } elseif ($request->has('piagam_penghargaan_asli')) {
            $formType = 'legalisir_piagam';
        } elseif ($request->has('sr_kesbangpol')) {
            $formType = 'izin_penelitian';
        } else {
            $formType = 'pengaduan';
        }  // Contoh logika
        // Kirim notifikasi ke admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new ServicesRequest($izinPenelitian, $formType));
        }
        // Cek apakah notifikasi berhasil dikirim
        // dd('Notifikasi dikirim!');

        return redirect()->route('user.izin_penelitian.create')->with('success', 'Pengajuan Izin Penelitian berhasil dikirim!');
    }

    
    
}
