<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\IzinPenelitian;
use Barryvdh\DomPDF\Facade\PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class IzinPenelitianController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $entriesPerPage = $request->get('entries_per_page', 10); // Default to 10 if not provided
        $sortBy = $request->get('sort_by', 'nama'); // Default sort by 'nama'
        $sortOrder = $request->get('sort_order', 'asc'); // Default order ascending
    
        $query = IzinPenelitian::query();

        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('no_hp', 'like', '%' . $search . '%');
            });
        }
    
        // Apply sorting if needed
        $query->orderBy($sortBy, $sortOrder);
    
        // Apply pagination based on selected entries per page
        $izin_penelitian = $query->paginate($entriesPerPage);
    
    
        return view('admin.izin_penelitian.index', compact('izin_penelitian', 'search', 'sortBy', 'sortOrder', 'entriesPerPage'));
    }
    
    

    public function create()
    {
        return view('admin.izin_penelitian.create');
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

        IzinPenelitian::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'sr_kesbangpol' => $path_sr_kesbangpol.$filename_sr_kesbangpol,
            'sip_kampus_lembaga' => $path_sip_kampus_lembaga.$filename_sip_kampus_lembaga,
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('admin.izin_penelitian')->with('status', 'Data Pengaduan berhasil ditambahkan!');
    }

    public function show(int $id)
    {
        $izin_penelitian = IzinPenelitian::findOrFail($id);
        return view('admin.izin_penelitian.show', compact('izin_penelitian'));
    }

    public function edit(int $id)
    {
        $izin_penelitian = IzinPenelitian::findOrFail($id);
        return view('admin.izin_penelitian.edit', compact('izin_penelitian'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'nama' => 'required|max:100|string',
            'no_hp' => 'required|numeric|regex:/^08[1-9][0-9]{8,9}$/',
            'email' => 'required|email',
            'sr_kesbangpol' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'sip_kampus_lembaga' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'output' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'status' => 'nullable|in:Diterima,Sedang Diproses,Ditindaklanjuti,Selesai',
        ], [
            'nama.required' => 'Nama Tidak Boleh Kosong',
            'nama.max' => 'Nama Tidak Boleh Lebih dari 100 karakter',
            'no_hp.required' => 'Nomor HP Tidak Boleh Kosong',
            'no_hp.numeric' => 'Nomor HP harus berupa Angka',
            'no_hp.regex' => 'Nomor HP tidak valid. Harus diawali dengan 08 dan diikuti dengan 11-12 digit angka.',
            'email.required' => 'E-mail Tidak Boleh Kosong',
            'email.email' => 'Format E-mail tidak valid.',
            'sr_kesbangpol.file' => 'File harus berupa file yang valid.',
            'sr_kesbangpol.mimes' => 'File harus berupa pdf, jpg, jpeg, png, doc, atau docx.',
            'sr_kesbangpol.max' => 'Ukuran file tidak boleh lebih dari 10 MB.',
            'sip_kampus_lembaga.file' => 'File harus berupa file yang valid.',
            'sip_kampus_lembaga.mimes' => 'File harus berupa pdf, jpg, jpeg, png, doc, atau docx.',
            'sip_kampus_lembaga.max' => 'Ukuran file tidak boleh lebih dari 10 MB.',
            'output.file' => 'File harus berupa file yang valid.',
            'output.mimes' => 'File harus berupa pdf, jpg, jpeg, png, doc, atau docx.',
            'output.max' => 'Ukuran file tidak boleh lebih dari 10 MB.',
        ]);

        $izin_penelitian = IzinPenelitian::findOrFail($id);
        
        if ($request->hasFile('sr_kesbangpol')) {
            $file_sr_kesbangpol = $request->file('sr_kesbangpol');
            $extension_sr_kesbangpol = $file_sr_kesbangpol->getClientOriginalExtension();
            
            $filename_sr_kesbangpol = time() . '_sr_kesbangpol.' . $extension_sr_kesbangpol;
            $path_sr_kesbangpol = 'uploads/izin_penelitian/sr_kesbangpol/';
            $file_sr_kesbangpol->move($path_sr_kesbangpol, $filename_sr_kesbangpol);

            if(File::exists($izin_penelitian->sr_kesbangpol	)){
                File::delete($izin_penelitian->sr_kesbangpol	);
            }

            $izin_penelitian->sr_kesbangpol	 = $path_sr_kesbangpol	 . $filename_sr_kesbangpol	;
        }
        
        if ($request->hasFile('sip_kampus_lembaga')) {
            $file_sip_kampus_lembaga = $request->file('sip_kampus_lembaga');
            $extension_sip_kampus_lembaga = $file_sip_kampus_lembaga->getClientOriginalExtension();
            
            $filename_sip_kampus_lembaga = time() . '_sip_kampus_lembaga.' . $extension_sip_kampus_lembaga;
            $path_sip_kampus_lembaga = 'uploads/izin_penelitian/sip_kampus_lembaga/';
            $file_sip_kampus_lembaga->move($path_sip_kampus_lembaga, $filename_sip_kampus_lembaga);

            if(File::exists($izin_penelitian->sip_kampus_lembaga)){
                File::delete($izin_penelitian->sip_kampus_lembaga);
            }

            $izin_penelitian->sip_kampus_lembaga = $path_sip_kampus_lembaga . $filename_sip_kampus_lembaga;
        }

      if ($request->hasFile('output')) {
    // Hapus file lama jika ada
    if ($izin_penelitian->output && Storage::disk('public')->exists($izin_penelitian->output)) {
        Storage::disk('public')->delete($izin_penelitian->output);
    }

    // Simpan file baru ke disk 'public'
    $file_output = $request->file('output');
    $extension_output = $file_output->getClientOriginalExtension();
    $filename_output = time() . '_output.' . $extension_output;

    $path_output = 'uploads/izin_penelitian/output'; // folder dalam storage/app/public
    $stored_path = $file_output->storeAs($path_output, $filename_output, 'public');

    // Simpan path relatif di kolom 'output'
    $izin_penelitian->output = $stored_path;
    }

        $izin_penelitian->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'sr_kesbangpol' => $izin_penelitian->sr_kesbangpol ?? $izin_penelitian->getOriginal('sr_kesbangpol'),
            'sip_kampus_lembaga' => $izin_penelitian->sip_kampus_lembaga ?? $izin_penelitian->getOriginal('sip_kampus_lembaga'),
            'output' => $izin_penelitian->output ?? $izin_penelitian->getOriginal('output'),
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.izin_penelitian')->with('status', 'Data Izin Penelitian berhasil diperbaharui!');
    }

    public function destroy(string $id)
    {
        $izin_penelitian = IzinPenelitian::findOrFail($id);
        if(File::exists($izin_penelitian->sr_kesbangpol)){
            File::delete($izin_penelitian->sr_kesbangpol);
        }
        if(File::exists($izin_penelitian->sip_kampus_lembaga)){
            File::delete($izin_penelitian->sip_kampus_lembaga);
        }
        if(File::exists($izin_penelitian->output)){
            File::delete($izin_penelitian->output);
        }

        $izin_penelitian -> delete();
        return redirect()->back()->with('status', 'Data Pengaduan berhasil dihapus!');
    }

    public function generatePDF()
    {
        $izin_penelitian = IzinPenelitian::get();
        $data = [
            'title' => 'Daftar Data Pengajuan Izin Penelitian',
            'date' => date('d/m/Y'),
            'izin_penelitian' => $izin_penelitian
        ];

        $pdf = PDF::loadView('admin/izin_penelitian.pdf', $data);
        return $pdf->download('Izin Penelitian.pdf');
    }
    
    public function filter(Request $request)
    {
        // Get the selected statuses from the request
        $statuses = $request->input('statuses');
    
        // Query to filter by status
        $query = IzinPenelitian::query();
    
        if (!empty($statuses)) {
            $query->whereIn('status', $statuses); // Filter records based on selected statuses
        }
    
        $filteredStatuses = $query->get();
    
        // Return filtered data as JSON for the AJAX call
        return response()->json(['statuses' => $filteredStatuses]);
    }

    public function export()
    {
        // Ambil data dari tabel izin_penelitian
        $izinPenelitian = IzinPenelitian::all();

        // Buat Spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tambahkan header kolom
        $sheet->setCellValue('A1', 'Nama');
        $sheet->setCellValue('B1', 'Email');
        $sheet->setCellValue('C1', 'No HP');
        $sheet->setCellValue('D1', 'Status');

        // Tambahkan data ke dalam sheet
        $row = 2; // Mulai dari baris kedua
        foreach ($izinPenelitian as $data) {
            $sheet->setCellValue('A' . $row, $data->nama);
            $sheet->setCellValue('B' . $row, $data->email);
            $sheet->setCellValue('C' . $row, $data->no_hp);
            $sheet->setCellValue('D' . $row, $data->status);
            $row++;
        }

        // Simpan file sebagai Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'izin_penelitian.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        // Unduh file
        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }
}
