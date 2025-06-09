<?php

// app/Console/Commands/AutoCloseLaporan.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lapor; // pastikan ini nama model kamu
use Carbon\Carbon;

class AutoCloseLaporan extends Command
{
    protected $signature = 'lapor:auto-close';
    protected $description = 'Tutup otomatis laporan yang tidak aktif lebih dari 5 hari';

    public function handle(): void
    {
        $batas = now()->subDays(5);

        $laporan = Lapor::where('status', 'diproses')
            ->where('updated_at', '<=', $batas)
            ->get();

        foreach ($laporan as $lapor) {
            $lapor->status = 'selesai';
            $lapor->balasan = '[Ditutup otomatis oleh sistem karena tidak ada aktivitas lanjutan]';
            $lapor->save();
        }

        $this->info('Laporan yang tidak aktif sudah ditutup otomatis.');
    }
}

