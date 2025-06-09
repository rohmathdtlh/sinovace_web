<!DOCTYPE html>
<html>
<head>
    <title>Daftar Izin Penelitian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        table {
            width: 100%; /* Agar tabel memenuhi lebar halaman */
            border-collapse: collapse; /* Menghindari garis ganda antara sel */
            margin-bottom: 20px; /* Jarak antara tabel dan elemen lain */
        }
    
        td {
            padding: 10px; /* Jarak dalam sel */
            border: 1px solid #000; /* Garis border hitam */
            text-align: left; /* Rata kiri untuk teks */
        }
        th {
            padding: 10px; /* Jarak dalam sel */
            border: 1px solid #000; /* Garis border hitam */
            text-align: center; /* Rata kiri untuk teks */
        }
    
        th {
            background-color: #1F316F; /* Warna latar belakang untuk header */
            color: white;
            font-weight: bold; /* Teks header tebal */
        }
    </style>
</head>
<body>

    <h3 style="text-align: center">{{ $title }}</h3>
    <p>Tanggal : {{ $date }}</p>
    <div class="table-responsive text-nowrap">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>No. HP/WA</th>
                <th>E-mail</th>
                <th>Status</th>
              </tr>
        </thead>
        <tbody>                         
            @foreach($izin_penelitian as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->no_hp }}</td>
                <td>{{ $item->email }}</td>
                <td>
                  @php
                      $badgeClass = '';
                      switch ($item->status) {
                        case 'Diterima':
                            $badgeClass = 'bg-label-success'; // Hijau untuk aktif
                            break;
                        case 'Sedang Diproses':
                            $badgeClass = 'bg-label-info'; // Kuning untuk pending
                            break;
                        case 'Ditindaklanjuti':
                            $badgeClass = 'bg-label-warning'; // Merah untuk non-aktif
                            break;
                        case 'Selesai':
                            $badgeClass = 'bg-label-secondary'; // Merah untuk non-aktif
                            break;
                        default:
                            $badgeClass = 'bg-label-success'; // Warna default
                            break;
                      }
                  @endphp
                  <span class="badge {{ $badgeClass }} me-1">{{ $item->status }}</span>
                </td>
              </tr>
            @endforeach
          </tbody>
    </table>
    </div>
</body>
</html>