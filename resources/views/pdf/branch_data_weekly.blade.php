<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Cabang Mingguan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9px; /* Smaller font to fit all columns */
        }
        h2 {
            text-align: center;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 8px;
            text-transform: uppercase;
        }
        .text-right {
            text-align: right;
        }
        .bg-reguler {
            background-color: #fde047; /* Yellow */
        }
        .bg-asuransi {
            background-color: #f87171; /* Red */
        }
        .bg-internal {
            background-color: #4ade80; /* Green */
        }
        .summary-row {
            background-color: #ffffff;
            font-weight: bold;
        }
        .summary-label {
            text-align: right;
        }
    </style>
</head>
<body>

    <h2 style="text-align: left; font-size: 16px; margin-bottom: 2px;">Rekapitulasi Piutang</h2>
    <p style="text-align: left; font-size: 10px; margin-top: 0; margin-bottom: 15px;">Kelola data saldo awal, mutasi, rekonsiliasi GL, dan saldo akhir konsumen secara instan.</p>

    @foreach($branchData as $branch => $data)
        <h3 style="margin-bottom: 5px; font-size: 12px;">Cabang: {{ strtoupper($branch ?: 'Tidak Diketahui') }}</h3>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">NO</th>
                    <th rowspan="2">NAMA KONSUMEN</th>
                    <th rowspan="2">TGL. BUKTI</th>
                    <th rowspan="2">NO. BUKTI</th>
                    <th rowspan="2">SALDO AWAL</th>
                    <th colspan="2">MUTASI</th>
                    <th rowspan="2">TGL. BUKTI</th>
                    <th rowspan="2">NO. BUKTI</th>
                    <th rowspan="2">SALDO AKHIR</th>
                    <th rowspan="2">KETERANGAN</th>
                    <th rowspan="2">NO POLISI</th>
                    <th rowspan="2">NO POLIS</th>
                    <th rowspan="2">KATEGORI SPK</th>
                </tr>
                <tr>
                    <th>DEBET</th>
                    <th>KREDIT</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $no = 1; 
                    $totalSaldoAwal = 0;
                    $totalDebet = 0;
                    $totalKredit = 0;
                    $totalSaldoAkhir = 0;
                @endphp
                @foreach($data as $row)
                    @php
                        // Determine row color based on spk_type
                        $rowColor = '';
                        $spkType = strtoupper($row->spk_type);
                        if ($spkType == 'REGULER') {
                            $rowColor = 'bg-reguler';
                        } elseif ($spkType == 'ASURANSI') {
                            $rowColor = 'bg-asuransi';
                        } elseif ($spkType == 'INTERNAL') {
                            $rowColor = 'bg-internal';
                        }

                        // Add to totals
                        $totalSaldoAwal += $row->saldo_awal;
                        $totalDebet += $row->debet;
                        $totalKredit += $row->kredit;
                        $totalSaldoAkhir += $row->saldo_akhir;
                    @endphp
                    <tr class="{{ $rowColor }}">
                        <td>{{ $no++ }}</td>
                        <td>{{ $row->nama_konsumen }}</td>
                        <td>{{ $row->tgl_bukti ? $row->tgl_bukti->format('d M Y') : '-' }}</td>
                        <td>{{ $row->no_bukti }}</td>
                        <td class="text-right">{{ number_format($row->saldo_awal, 0, ',', ',') }}</td>
                        <td class="text-right">{{ number_format($row->debet, 0, ',', ',') }}</td>
                        <td class="text-right">{{ number_format($row->kredit, 0, ',', ',') }}</td>
                        <td>{{ $row->tgl_bukti_rek ? $row->tgl_bukti_rek->format('d M Y') : '-' }}</td>
                        <td>{{ $row->no_bukti_rek }}</td>
                        <td class="text-right">{{ number_format($row->saldo_akhir, 0, ',', ',') }}</td>
                        <td>{{ $row->keterangan }}</td>
                        <td>{{ $row->no_polisi }}</td>
                        <td>{{ $row->no_polis }}</td>
                        <td>{{ $row->spk_type }}</td>
                    </tr>
                @endforeach
                
                <!-- Totals Row -->
                <tr class="summary-row">
                    <td colspan="4" class="summary-label">Total</td>
                    <td class="text-right">{{ number_format($totalSaldoAwal, 0, ',', ',') }}</td>
                    <td class="text-right">{{ number_format($totalDebet, 0, ',', ',') }}</td>
                    <td class="text-right">{{ number_format($totalKredit, 0, ',', ',') }}</td>
                    <td colspan="2"></td>
                    <td class="text-right">{{ number_format($totalSaldoAkhir, 0, ',', ',') }}</td>
                    <td colspan="4"></td>
                </tr>
                <!-- GL Row -->
                <tr class="summary-row">
                    <td colspan="4" class="summary-label">GL</td>
                    <td class="text-right">{{ number_format($totalSaldoAwal, 0, ',', ',') }}</td>
                    <td class="text-right">{{ number_format($totalDebet, 0, ',', ',') }}</td>
                    <td class="text-right">{{ number_format($totalKredit, 0, ',', ',') }}</td>
                    <td colspan="2"></td>
                    <td class="text-right">{{ number_format($totalSaldoAkhir, 0, ',', ',') }}</td>
                    <td colspan="4"></td>
                </tr>
                <!-- SELISIH Row -->
                <tr class="summary-row" style="color: red;">
                    <td colspan="4" class="summary-label">SELISIH</td>
                    <td class="text-right">-</td>
                    <td class="text-right">-</td>
                    <td class="text-right">-</td>
                    <td colspan="2"></td>
                    <td class="text-right">-</td>
                    <td colspan="4"></td>
                </tr>
            </tbody>
        </table>
    @endforeach

</body>
</html>
