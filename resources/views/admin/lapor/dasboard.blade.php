@extends('main-admin')

@section('title', 'Dashboard Lapor/Pengaduan')

@section('content')
<div class="content">
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold mb-0 text-white">Dashboard Pengaduan</h3>
      <div class="text-muted">Update terakhir: {{ now()->format('d M Y H:i') }}</div>
    </div>

    <!-- Statistik Utama -->
    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card shadow-sm border-start border-primary border-3">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h5 class="card-title text-muted">Total Pengaduan</h5>
                <p class="card-text display-6 fw-bold">{{ $totalPengaduan ?? 0 }}</p>
              </div>
              <div class="bg-primary bg-opacity-10 p-3 rounded">
                <i class="fas fa-file-alt text-primary" style="font-size: 1.5rem;"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm border-start border-secondary border-3">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h5 class="card-title text-muted">Pending</h5>
                <p class="card-text display-6 fw-bold">{{ $pengaduanPending ?? 0 }}</p>
              </div>
              <div class="bg-secondary bg-opacity-10 p-3 rounded">
                <i class="fas fa-clock text-warning" style="font-size: 1.5rem;"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm border-start border-success border-3">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h5 class="card-title text-muted">Selesai</h5>
                <p class="card-text display-6 fw-bold">{{ $pengaduanSelesai ?? 0 }}</p>
              </div>
              <div class="bg-success bg-opacity-10 p-3 rounded">
                <i class="fas fa-check-circle text-success" style="font-size: 1.5rem;"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Grafik dan Kategori -->
    <div class="row">
      <!-- Grafik Pengaduan Per Bulan -->
      <div class="col-lg-8 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="card-title mb-0">Trend Pengaduan Per Bulan</h5>
              <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary">
                  Tahun {{ now()->year }}
                </button>
              </div>
            </div>
            @if(!empty($pengaduanPerBulan) && count($pengaduanPerBulan) > 0)
              <div class="chart-container" style="position: relative; height: 300px;">
                <canvas id="pengaduanPerBulanChart"></canvas>
              </div>
            @else
              <div class="text-center py-4">
                <i class="fas fa-chart-line fa-2x text-muted mb-2"></i>
                <p class="text-muted">Tidak ada data pengaduan untuk ditampilkan</p>
              </div>
            @endif
          </div>
        </div>
      </div>

      <!-- Kategori Pengaduan -->
      <div class="col-lg-4 mb-4">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h5 class="card-title mb-3">Distribusi Kategori Pengaduan</h5>
            @if(!empty($kategoriPengaduan) && $kategoriPengaduan->count() > 0)
              <div class="chart-container mb-4" style="position: relative; height: 200px;">
                <canvas id="kategoriPengaduanChart"></canvas>
              </div>
              <div class="table-responsive">
                <table class="table table-sm table-borderless">
                  <tbody>
                    @foreach ($kategoriPengaduan as $kategori)
                      <tr>
                        <td class="align-middle">
                          <span class="badge" style="background-color: {{ $colors[$loop->index % count($colors)] }}; width: 12px; height: 12px; display: inline-block;"></span>
                          <span class="ms-2">{{ $kategori->nama_kategori }}</span>
                        </td>
                        <td class="text-end fw-bold">{{ $kategori->lapors_count ?? 0 }}</td>
                        <td class="text-end text-muted">
                          @if($totalPengaduan > 0)
                            {{ round(($kategori->lapors_count / $totalPengaduan) * 100, 1) }}%
                          @else
                            0%
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <div class="text-center py-4">
                <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                <p class="text-muted">Data kategori pengaduan tidak tersedia</p>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Tabel Pengaduan Terbaru -->
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="card-title mb-0">Pengaduan Terbaru</h5>
              <a href="{{ route('admin.lapor.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Pelapor</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse(($pengaduanTerbaru ?? []) as $pengaduan)
                    <tr>
                      <td>#{{ $pengaduan->id }}</td>
                      <td>{{ $pengaduan->created_at->format('d M Y') }}</td>
                      <td>{{ $pengaduan->kategori->nama_kategori ?? '-' }}</td>
                      <td>{{ $pengaduan->user->name ?? 'Anonim' }}</td>
                      <td>
                        @if($pengaduan->status == 'selesai')
                          <span class="badge bg-success">Selesai</span>
                        @elseif($pengaduan->status == 'diproses')
                          <span class="badge bg-warning text-dark">Diproses</span>
                        @else
                          <span class="badge bg-secondary">Pending</span>
                        @endif
                      </td>
                      <td>
                        @if(isset($pengaduan->kategori))
                          <a href="{{ route('admin.lapor.kategori', $pengaduan->kategori->id) }}?highlight={{ $pengaduan->id }}#pengaduan-{{ $pengaduan->id }}" class="btn btn-sm btn-outline-primary">
                            Detail
                          </a>
                        @else
                          <a href="{{ route('admin.lapor.index') }}" class="btn btn-sm btn-outline-primary">
                            Detail
                          </a>
                        @endif
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="text-center">Tidak ada pengaduan terbaru</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Warna untuk chart
  const colors = [
    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', 
    '#858796', '#5a5c69', '#3a3b45', '#2e59d9', '#17a673'
  ];

  // Data untuk chart pengaduan per bulan
  @if(!empty($pengaduanPerBulan) && count($pengaduanPerBulan) > 0)
    const pengaduanPerBulanData = @json($pengaduanPerBulan);
    
    // Siapkan data untuk chart bulanan
    const labels = [];
    const data = [];
    pengaduanPerBulanData.forEach(item => {
      const bulan = new Date(2023, item.bulan - 1).toLocaleString('default', { month: 'short' });
      labels.push(bulan);
      data.push(item.total);
    });

    // Buat chart pengaduan per bulan
    const bulanChartCtx = document.getElementById('pengaduanPerBulanChart').getContext('2d');
    new Chart(bulanChartCtx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Jumlah Pengaduan',
          data: data,
          backgroundColor: 'rgba(78, 115, 223, 0.05)',
          borderColor: '#4e73df',
          borderWidth: 2,
          pointBackgroundColor: '#4e73df',
          pointBorderColor: '#fff',
          pointRadius: 4,
          pointHoverRadius: 6,
          tension: 0.3,
          fill: true
        }]
      },
      options: {
        maintainAspectRatio: false,
        plugins: {
          tooltip: {
            backgroundColor: '#172b4d',
            titleFont: { size: 14, weight: 'bold' },
            bodyFont: { size: 12 },
            padding: 12,
            displayColors: false,
            callbacks: {
              label: function(context) {
                return `${context.parsed.y} pengaduan`;
              }
            }
          },
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              color: 'rgba(0, 0, 0, 0.05)'
            },
            ticks: {
              stepSize: Math.ceil(Math.max(...data) / 5)
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        }
      }
    });
  @endif

  // Data untuk chart kategori pengaduan
  @if(!empty($kategoriPengaduan) && $kategoriPengaduan->count() > 0)
    const kategoriLabels = @json($kategoriPengaduan->pluck('nama_kategori'));
    const kategoriData = @json($kategoriPengaduan->pluck('lapors_count'));
    
    // Buat chart kategori pengaduan
    const kategoriChartCtx = document.getElementById('kategoriPengaduanChart').getContext('2d');
    new Chart(kategoriChartCtx, {
      type: 'doughnut',
      data: {
        labels: kategoriLabels,
        datasets: [{
          data: kategoriData,
          backgroundColor: colors,
          hoverBackgroundColor: colors.map(c => c + 'CC'),
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }]
      },
      options: {
        maintainAspectRatio: false,
        plugins: {
          tooltip: {
            backgroundColor: '#172b4d',
            titleFont: { size: 14, weight: 'bold' },
            bodyFont: { size: 12 },
            padding: 12,
            displayColors: true,
            callbacks: {
              label: function(context) {
                const label = context.label || '';
                const value = context.raw || 0;
                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                const percentage = Math.round((value / total) * 100);
                return `${label}: ${value} (${percentage}%)`;
              }
            }
          },
          legend: {
            display: false
          }
        },
        cutout: '70%'
      }
    });
  @endif
</script>
@endsection