<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Pendaftaran Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f6f9;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .header {
            text-align: center;
            background: rgba(31, 49, 111, 0.95);
            color: white;
            padding: 15px 0;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
            color: #000000;
        }
        .content h3 {
            margin-top: 0;
        }
        .details ul {
            list-style-type: none;
            padding: 0;
        }
        .details ul li {
            background: #f9f9f9;
            margin: 5px 0;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .footer {
            text-align: center;
            padding: 10px 0;
            background: rgba(31, 49, 111, 0.95);
            color: white;
            border-radius: 0 0 8px 8px;
            font-size: 14px;
        }
        .footer a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>SINOVACE</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <h1>Halo!</h1>
            <p>Terima kasih telah menggunakan layanan kami. Pengajuan Anda sedang kami proses. Mohon menunggu konfirmasi lebih lanjut dari kami. Terima kasih.</p>
            <p><strong>Detail Pengajuan:</strong></p>
            <div class="details">
                <ul>
                    <li><strong>Nama:</strong> {{ $data->nama }}</li>
                    <li><strong>Tanggal Pengajuan:</strong> {{ $data->created_at }}</li>
                </ul>
            </div>
            <p>Regards <br> SINOVACE DISDIK DEPOK</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} SINOVACE. <a href="{{ url('/') }}">Kunjungi Situs Kami</a></p>
        </div>
    </div>
</body>
</html>

