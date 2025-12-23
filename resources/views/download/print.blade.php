<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Vedika</title>
    <style>
        @media print {
            @page {
                size: A4 landscape;
                margin: 10mm;
            }
        }

        body {
            font-size: 10px;
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 3px;
            white-space: nowrap;
        }

        th {
            background: #eee;
        }

        .no-print {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="no-print">
    <button onclick="window.print()">Print / Save PDF</button>
</div>

<h4>Data Vedika</h4>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tgl Pengajuan</th>
            <th>Tgl Registrasi</th>
            <th>No RM</th>
            <th>No Rawat</th>
            <th>No SEP</th>
            <th>Jenis</th>
            <th>Dokter</th>
            <th>Poli</th>
            <th>No Peserta</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $row)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $row->tanggal }}</td>
            <td>{{ $row->tgl_registrasi }}</td>
            <td>{{ $row->no_rkm_medis }}</td>
            <td>{{ $row->no_rawat }}</td>
            <td>{{ $row->nosep }}</td>
            <td>{{ in_array($row->jenis,['ranap','1']) ? 'Rawat Inap' : 'Rawat Jalan' }}</td>
            <td>{{ $row->nm_dokter }}</td>
            <td>{{ $row->nm_poli }}</td>
            <td>{{ $row->no_peserta }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
