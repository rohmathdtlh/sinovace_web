<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use App\Models\Lapor;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\KategoriPengaduan;
use App\Models\LampiranPengaduan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporController extends Controller
{
    public function index(Request $request)
{
    $search = $request->query('search');
    $sortBy = $request->query('sort_by', 'id');
    $sortOrder = $request->query('sort_order', 'asc');
    $entriesPerPage = $request->query('entries_per_page', 10);

    $query = Lapor::query();

    if ($search) {
        $query->where('judul', 'like', '%' . $search . '%')
              ->orWhere('lokasi_kejadian', 'like', '%' . $search . '%');
    }

    $query->orderBy($sortBy, $sortOrder);

    $lapors = $query->paginate($entriesPerPage);

    return view('admin.lapor.index', compact('lapors', 'search', 'sortBy', 'sortOrder', 'entriesPerPage'));
}

public function filter(Request $request)
{
    // Ambil status yang dipilih dari request
    $statuses = $request->input('statuses');

    // Query untuk filter berdasarkan status
    $query = Lapor::query();

    if (!empty($statuses)) {
        $query->whereIn('status', $statuses); // Filter data berdasarkan status yang dipilih
    }

    // Ambil data yang sudah difilter
    $filteredStatuses = $query->get();

    // Kembalikan data dalam format JSON untuk AJAX
    return response()->json(['statuses' => $filteredStatuses]);
}

// public function generatePDF()
// {
//     // Ambil semua data dari tabel lapor
//     $lapors = Lapor::get();

//     // Data yang akan dikirim ke view PDF
//     $data = [
//         'title' => 'Daftar Data Laporan Pengaduan',
//         'date' => date('d/m/Y'), // Tanggal saat ini
//         'lapors' => $lapors // Data laporan
//     ];

//     // Load view PDF dan kirim data
//     $pdf = Pdf::loadView('admin.lapor.pdf', $data);

//     // Download file PDF
//     return $pdf->download('Laporan Pengaduan.pdf');
// }
// public function exportExcel()
// {
//     // Ambil semua data dari tabel lapor
//     $lapors = Lapor::all();

//     // Buat Spreadsheet baru
//     $spreadsheet = new Spreadsheet();
//     $sheet = $spreadsheet->getActiveSheet();

//     // Tambahkan header kolom
//     $sheet->setCellValue('A1', 'No.');
//     $sheet->setCellValue('B1', 'Judul');
//     $sheet->setCellValue('C1', 'Lokasi Kejadian');
//     $sheet->setCellValue('D1', 'Status');

//     // Tambahkan data ke dalam sheet
//     $row = 2; // Mulai dari baris kedua
//     foreach ($lapors as $lapor) {
//         $sheet->setCellValue('A' . $row, $lapor->iteration);
//         $sheet->setCellValue('B' . $row, $lapor->judul);
//         $sheet->setCellValue('C' . $row, $lapor->lokasi_kejadian);
//         $sheet->setCellValue('D' . $row, $lapor->status);
//         $row++;
//     }

//     // Simpan file sebagai Excel
//     $writer = new Xlsx($spreadsheet);
//     $fileName = 'laporan_pengaduan.xlsx';
//     $temp_file = tempnam(sys_get_temp_dir(), $fileName); // Buat file sementara
//     $writer->save($temp_file);

//     // Unduh file
//     return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
// }

public function dashboard()
{
    // Hitung total pengaduan
    $totalPengaduan = Lapor::count();

    // Hitung pengaduan berdasarkan status
    $pengaduanPending = Lapor::where('status', 'pending')->count();
    $pengaduanDiproses = Lapor::where('status', 'diproses')->count();
    $pengaduanSelesai = Lapor::where('status', 'selesai')->count();

    // Ambil 5 pengaduan terbaru
    $pengaduanTerbaru = Lapor::with(['kategori', 'user'])
        ->latest()
        ->take(5)
        ->get();

    // Data untuk grafik pengaduan per bulan (tahun berjalan)
    $pengaduanPerBulan = Lapor::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
        ->whereYear('created_at', now()->year)
        ->groupByRaw('MONTH(created_at)')
        ->orderByRaw('MONTH(created_at)')
        ->get();

    // Data kategori dan jumlah pengaduan per kategori
    $kategoriPengaduan = KategoriPengaduan::withCount('lapors')->get();

    // Warna untuk grafik pie
    $colors = [
        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
        '#858796', '#5a5c69', '#3a3b45', '#2e59d9', '#17a673'
    ];

    return view('admin.lapor.dasboard', compact(
        'totalPengaduan',
        'pengaduanPending',
        'pengaduanDiproses',
        'pengaduanSelesai',
        'pengaduanTerbaru',
        'pengaduanPerBulan',
        'kategoriPengaduan',
        'colors'
    ));
}

    public function destroy($id)
    {
        $pengaduan = Lapor::findOrFail($id);

        // Hapus lampiran jika ada
        if ($pengaduan->lampiran) {
            Storage::disk('public')->delete($pengaduan->lampiran);
        }

        // Hapus pengaduan
        $pengaduan->delete();

        return redirect()->route('admin.lapor.index')->with('success', 'Pengaduan berhasil dihapus.');
    }
    public function tanggapanByKategori($kategori_id, Request $request)
    {
        $kategori = KategoriPengaduan::findOrFail($kategori_id);
        $highlight = $request->query('highlight'); // ID pengaduan yang ingin di-highlight

        $lapors = $kategori->lapor()
                        ->with(['lampiranPengaduan', 'tanggapans.komentars.user'])
                        ->paginate(10);

        return view('admin.tanggapan.index', compact('kategori', 'lapors', 'highlight'));
    }

    public function edit($id)
    {
        $lapor = Lapor::findOrFail($id);
        return view('admin.lapor.edit', compact('lapor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditutup'
        ]);

        $lapor = Lapor::findOrFail($id);
        $lapor->update([
            'status' => $request->status
        ]);

        if ($request->from === 'edit') {
            return redirect()->route('admin.lapor.index')->with('success', 'Status berhasil diperbarui');
        }

        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }

    public function laporByKategori($id)
    {
        $kategori = KategoriPengaduan::findOrFail($id);
        $lapors = Lapor::where('kategori_id', $id)->latest()->paginate(10);

        return view('admin.tanggapan.index', compact('kategori', 'lapors'));
    }

}