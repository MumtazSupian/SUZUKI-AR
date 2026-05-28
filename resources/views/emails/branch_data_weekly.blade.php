<x-mail::message>
# Laporan Data Cabang Mingguan

Berikut adalah laporan data cabang untuk minggu ini.

@foreach($branchData as $branch => $data)
## Cabang: {{ $branch ?: 'Tidak Diketahui' }}
- **Total Data:** {{ $data->count() }}
- **Total Saldo Awal:** Rp {{ number_format($data->sum('saldo_awal'), 2, ',', '.') }}
- **Total Debet:** Rp {{ number_format($data->sum('debet'), 2, ',', '.') }}
- **Total Kredit:** Rp {{ number_format($data->sum('kredit'), 2, ',', '.') }}
- **Total Saldo Akhir:** Rp {{ number_format($data->sum('saldo_akhir'), 2, ',', '.') }}

@endforeach

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
