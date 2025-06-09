<h1>{{ $title }}</h1>
<p>Tanggal: {{ $date }}</p>
<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>No.</th>
            <th>Judul</th>
            <th>Lokasi Kejadian</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lapors as $lapor)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $lapor->judul }}</td>
                <td>{{ $lapor->lokasi_kejadian }}</td>
                <td>{{ $lapor->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>