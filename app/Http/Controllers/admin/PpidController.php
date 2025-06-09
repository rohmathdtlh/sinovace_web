<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ppid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PpidController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $entriesPerPage = $request->get('entries_per_page', 10);
        $sortBy = $request->get('sort_by', 'nama');
        $sortOrder = $request->get('sort_order', 'asc');
        $jenis = $request->get('jenis', 'permohonan'); // default permohonan

        $query = Ppid::where('jenis', $jenis); // filter berdasarkan jenis

        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('no_hp', 'like', '%' . $search . '%');
            });
        }

        $query->orderBy($sortBy, $sortOrder);
        $ppid = $query->paginate($entriesPerPage);

        return view('admin.ppid.index', compact('ppid', 'search', 'sortBy', 'sortOrder', 'entriesPerPage', 'jenis'));
    }

    public function create(Request $request)
    {
        $jenis = $request->query('jenis', 'permohonan');
        return view('admin.ppid.create', compact('jenis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|numeric|regex:/^08[1-9][0-9]{8,9}$/',
            'email' => 'required|email',
            'alamat' => 'required|string|max:255',
            'file_upload' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'jenis' => 'required|in:permohonan,keberatan',
        ]);

        $filename_file_upload = null;
        $path_file_upload = null;

        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $filename_file_upload = time() . '_file_upload.' . $file->getClientOriginalExtension();
            $path_file_upload = 'uploads/ppid/file_upload/';
            $file->move(public_path($path_file_upload), $filename_file_upload);
        }

        Ppid::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'file_upload' => $path_file_upload . $filename_file_upload,
            'status' => 'Sedang Diproses',
            'jenis' => $request->jenis,
        ]);
        return redirect()->route('admin.ppid.index')->with('status', 'Data PPID berhasil ditambahkan!');
    }

    public function show(int $id)
    {
        $ppid = Ppid::findOrFail($id);
        return view('admin.ppid.show', compact('ppid'));
    }

    public function edit(int $id)
    {
        $ppid = Ppid::findOrFail($id);
        return view('admin.ppid.edit', compact('ppid'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|numeric|regex:/^08[1-9][0-9]{8,9}$/',
            'alamat' => 'required|string|max:255',
            'file_upload' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'output' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'status' => 'nullable|in:Diterima,Sedang Diproses,Ditindaklanjuti,Selesai',
        ]);

        $ppid = Ppid::findOrFail($id);

        // Handle file_upload update
        if ($request->hasFile('file_upload')) {
            if (File::exists(public_path($ppid->file_upload))) {
                File::delete(public_path($ppid->file_upload));
            }
            $file = $request->file('file_upload');
            $filename = time() . '_file_upload.' . $file->getClientOriginalExtension();
            $path = 'uploads/ppid/file_upload/';
            $file->move(public_path($path), $filename);
            $ppid->file_upload = $path . $filename;
        }

        // Handle output file update
        if ($request->hasFile('output')) {
            if ($ppid->output && Storage::disk('public')->exists($ppid->output)) {
                Storage::disk('public')->delete($ppid->output);
            }
            $outputFile = $request->file('output');
            $outputFilename = time() . '_output.' . $outputFile->getClientOriginalExtension();
            $path_output = 'uploads/ppid/output';
            $stored_path = $outputFile->storeAs($path_output, $outputFilename, 'public');
            $ppid->output = $stored_path;
        }

        $ppid->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'status' => $request->status,
        ]);

       return redirect()->route('admin.ppid.index')->with('status', 'Data PPID berhasil diupdate!');
    }

    public function filter(Request $request)
    {
        // Ambil status yang dipilih dari request
        $statuses = $request->input('statuses');

        // Query untuk filter berdasarkan status
        $query = Ppid::query();

        if (!empty($statuses)) {
            $query->whereIn('status', $statuses);
        }

        $filteredStatuses = $query->get();

        // Return data terfilter sebagai JSON untuk AJAX
        return response()->json(['statuses' => $filteredStatuses]);
    }

    public function destroy(string $id)
    {
        $ppid = Ppid::findOrFail($id);
        if (File::exists(public_path($ppid->file_upload))) {
            File::delete(public_path($ppid->file_upload));
        }
        if ($ppid->output && Storage::disk('public')->exists($ppid->output)) {
            Storage::disk('public')->delete($ppid->output);
        }

        $ppid->delete();
        return redirect()->back()->with('status', 'Data PPID berhasil dihapus!');
    }

    public function generatePDF()
    {
        $ppid = Ppid::all();
        $data = [
            'title' => 'Daftar Data Layanan PPID',
            'date' => date('d/m/Y'),
            'ppid' => $ppid
        ];

        $pdf = PDF::loadView('admin.ppid.pdf', $data);
        return $pdf->download('Data_PPID.pdf');
    }

    public function export()
    {
        $ppid = Ppid::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Nama');
        $sheet->setCellValue('B1', 'No HP');
        $sheet->setCellValue('C1', 'Alamat');
        $sheet->setCellValue('D1', 'Status');

        $row = 2;
        foreach ($ppid as $data) {
            $sheet->setCellValue('A' . $row, $data->nama);
            $sheet->setCellValue('B' . $row, $data->no_hp);
            $sheet->setCellValue('C' . $row, $data->alamat);
            $sheet->setCellValue('D' . $row, $data->status);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'data_ppid.xlsx';

        $tempFilePath = storage_path('app/public/' . $filename);
        $writer->save($tempFilePath);

        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }
}
