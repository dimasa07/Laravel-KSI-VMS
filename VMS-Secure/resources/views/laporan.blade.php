<!DOCTYPE html>
<html>

<head>
    <title>Laporan Tamu {{ $tipe }} - {{ $waktu }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        table{
            border:1px solid black;
        }
        th{
            font-size: 12px;
            text-align: center;
        }
        td{
            font-size: 12px;
        }
    </style>
</head>

<body>
    <h3>Laporan Tamu {{ $tipe }}</h3>
    <p>{{ $waktu }}</p>
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Tamu</th>
            <th>NIK</th>
            <th>Pegawai Dituju</th>
            <th>Keperluan</th>
            <th>Check-in</th>
            <th>Check-out</th>
        </tr>
        @foreach($semua as $no => $data)
        <tr>
            <td>{{ $no+1 }}</td>
            <td>{{ $data->permintaan_bertamu->tamu->nama }}</td>
            <td>{{ $data->permintaan_bertamu->tamu->nik }}</td>
            <td>{{ $data->permintaan_bertamu->pegawai->nama }}</td>
            <td>{{ $data->permintaan_bertamu->keperluan }}</td>
            <td>{{ $data->check_in }}</td>
            <td>{{ $data->check_out }}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>