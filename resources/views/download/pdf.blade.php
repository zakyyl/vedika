<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { 
            font-family: Arial, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 0;
        }
        
        h4 {
            text-align: center;
            margin: 0 0 5px 0;
            font-size: 14px;
            font-weight: bold;
        }
        
        .filter-info {
            text-align: center;
            margin: 0 0 15px 0;
            padding: 8px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .filter-info p {
            margin: 3px 0;
            font-size: 10px;
            color: #333;
        }
        
        .filter-info strong {
            color: #000;
            font-weight: bold;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse;
        }
        
        th, td { 
            border: 1px solid #333; 
            padding: 3px 4px;
            text-align: left;
            vertical-align: top;
        }
        
        th { 
            background-color: #e0e0e0;
            font-weight: bold;
            font-size: 9px;
        }
        
        td {
            font-size: 8px;
        }
        
        /* Kolom khusus */
        .col-no { width: 3%; text-align: center; }
        .col-tgl { width: 8%; }
        .col-rm { width: 7%; }
        .col-rawat { width: 10%; }
        .col-sep { width: 12%; }
        .col-jenis { width: 8%; }
        .col-dokter { width: 15%; }
        .col-poli { width: 12%; }
        .col-peserta { width: 10%; }
        
        .no-data {
            text-align: center;
            padding: 20px;
            font-style: italic;
        }
    </style>
</head>
<body>

<h4>LAPORAN PENGAJUAN VEDIKA</h4>

<div >
    @php
        $periodeText = 'Semua Periode';
        if (!empty($filterData['tanggal_awal']) && !empty($filterData['tanggal_akhir'])) {
            $tglAwal = \Carbon\Carbon::parse($filterData['tanggal_awal'])->format('Y-m-d');
            $tglAkhir = \Carbon\Carbon::parse($filterData['tanggal_akhir'])->format('Y-m-d');
            $periodeText = $tglAwal . ' s/d ' . $tglAkhir;
        }
        
        $jenisText = 'Semua Jenis';
        if (!empty($filterData['jenis'])) {
            $jenisText = $filterData['jenis'] === 'ranap' ? 'Rawat Inap' : 'Rawat Jalan';
        }
    @endphp
    
    <p><strong>Rentang Tanggal:</strong> {{ $periodeText }} | <strong>Jenis:</strong> {{ $jenisText }}</p>
</div>

<table>
    <thead>
        <tr>
            <th class="col-no">No</th>
            <th class="col-tgl">Tgl Pengajuan</th>
            <th class="col-tgl">Tgl Registrasi</th>
            <th class="col-rm">No RM</th>
            <th class="col-rawat">No Rawat</th>
            <th class="col-sep">No SEP</th>
            <th class="col-jenis">Jenis</th>
            <th class="col-dokter">Dokter</th>
            <th class="col-poli">Poli</th>
            <th class="col-peserta">No Peserta</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $i => $row)
        <tr>
            <td class="col-no">{{ $i+1 }}</td>
            <td class="col-tgl">{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
            <td class="col-tgl">{{ \Carbon\Carbon::parse($row->tgl_registrasi)->format('d/m/Y') }}</td>
            <td class="col-rm">{{ $row->no_rkm_medis }}</td>
            <td class="col-rawat">{{ $row->no_rawat }}</td>
            <td class="col-sep">{{ $row->nosep }}</td>
            <td class="col-jenis">{{ in_array($row->jenis,['ranap','1']) ? 'Ranap' : 'Ralan' }}</td>
            <td class="col-dokter">{{ $row->nm_dokter }}</td>
            <td class="col-poli">{{ $row->nm_poli }}</td>
            <td class="col-peserta">{{ $row->no_peserta }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="10" class="no-data">
                Tidak ada data
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>