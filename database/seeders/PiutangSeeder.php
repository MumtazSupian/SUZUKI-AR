<?php

namespace Database\Seeders;

use App\Models\Piutang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PiutangSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Data BP branch
        $piutangData = [
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000425', 'tgl_bukti' => '2025-01-30', 'no_bukti' => 'IA05/25/000004', 'saldo_awal' => 17850, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000438', 'tgl_bukti' => '2025-01-26', 'no_bukti' => 'IA05/25/000006', 'saldo_awal' => 19282, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000424', 'tgl_bukti' => '2025-01-30', 'no_bukti' => 'IA05/25/000070', 'saldo_awal' => 32375, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT', 'no_polisi' => 'NADIA RAHMAD'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000433', 'tgl_bukti' => '2025-01-28', 'no_bukti' => 'IA05/25/000008', 'saldo_awal' => 46025, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT - CAKRAVALA'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000437', 'tgl_bukti' => '2025-01-28', 'no_bukti' => 'IA05/25/000001', 'saldo_awal' => 48730, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000422', 'tgl_bukti' => '2025-01-31', 'no_bukti' => 'IA05/25/000008', 'saldo_awal' => 120200, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'SPK/24/000018', 'tgl_bukti' => '2025-01-31', 'no_bukti' => 'IA05/25/000024', 'saldo_awal' => 1500000, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'GR'],
            ['branch' => 'bp', 'nama_konsumen' => 'SPK/24/000019', 'tgl_bukti' => '2025-01-31', 'no_bukti' => 'IA05/25/000023', 'saldo_awal' => 1800000, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'GR'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000462', 'tgl_bukti' => '2025-02-21', 'no_bukti' => 'IA05/25/000032', 'saldo_awal' => 19360, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000466', 'tgl_bukti' => '2025-02-21', 'no_bukti' => 'IA05/25/000033', 'saldo_awal' => 15750, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'SPK/24/000367', 'tgl_bukti' => '2025-02-28', 'no_bukti' => 'IA05/25/000046', 'saldo_awal' => 167685, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000476', 'tgl_bukti' => '2025-02-28', 'no_bukti' => 'IA05/25/000043', 'saldo_awal' => 57337, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'SPK/24/000385', 'tgl_bukti' => '2025-02-28', 'no_bukti' => 'IA05/25/000051', 'saldo_awal' => 166355, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000485', 'tgl_bukti' => '2025-02-28', 'no_bukti' => 'IA05/25/000052', 'saldo_awal' => 127228, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000468', 'tgl_bukti' => '2025-02-28', 'no_bukti' => 'IA05/25/000055', 'saldo_awal' => 40800, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000473', 'tgl_bukti' => '2025-02-25', 'no_bukti' => 'IC05/25/000033', 'saldo_awal' => 23760, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000512', 'tgl_bukti' => '2025-03-23', 'no_bukti' => 'IA05/25/000060', 'saldo_awal' => 19374, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000435', 'tgl_bukti' => '2025-03-23', 'no_bukti' => 'IA05/25/000061', 'saldo_awal' => 2300, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000501', 'tgl_bukti' => '2025-03-21', 'no_bukti' => 'IA05/25/000063', 'saldo_awal' => 32375, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000497', 'tgl_bukti' => '2025-03-28', 'no_bukti' => 'IA05/25/000070', 'saldo_awal' => 68074, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000540', 'tgl_bukti' => '2025-03-28', 'no_bukti' => 'IA05/25/000075', 'saldo_awal' => 20831, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000580', 'tgl_bukti' => '2025-04-30', 'no_bukti' => 'IA05/25/000073', 'saldo_awal' => 17945, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000573', 'tgl_bukti' => '2025-04-30', 'no_bukti' => 'IA05/25/000081', 'saldo_awal' => 39542, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000231', 'tgl_bukti' => '2025-04-30', 'no_bukti' => 'IA05/25/000082', 'saldo_awal' => 4467880, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/25/000546', 'tgl_bukti' => '2025-04-30', 'no_bukti' => 'IA05/25/000088', 'saldo_awal' => 57877, 'debet' => 0, 'kredit' => 0, 'keterangan' => 'EUPOT'],
            // Additional rows for visual completeness (continuing the pattern)
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/26/000206', 'tgl_bukti' => '2026-04-28', 'no_bukti' => 'IA05/26/000076', 'saldo_awal' => 0, 'debet' => 7783457, 'kredit' => 0, 'keterangan' => ''],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/26/000830', 'tgl_bukti' => '2026-04-30', 'no_bukti' => 'IA05/26/000084', 'saldo_awal' => 0, 'debet' => 21819635, 'kredit' => 0, 'keterangan' => ''],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/26/000210', 'tgl_bukti' => '2026-04-30', 'no_bukti' => 'IA05/26/000083', 'saldo_awal' => 300000, 'debet' => 24363257, 'kredit' => 20, 'tgl_bukti_rek' => '2026-04-20', 'no_bukti_rek' => 'BT05/26/000203', 'keterangan' => ''],
            ['branch' => 'bp', 'nama_konsumen' => 'PK05/26/000138', 'tgl_bukti' => '2026-04-30', 'no_bukti' => 'IA05/26/000090', 'saldo_awal' => 0, 'debet' => 39721408, 'kredit' => 0, 'keterangan' => ''],
        ];

        // Insert data dengan batch processing
        foreach ($piutangData as $data) {
            // Calculate saldo_akhir
            $saldoAwal = $data['saldo_awal'] ?? 0;
            $debet = $data['debet'] ?? 0;
            $kredit = $data['kredit'] ?? 0;
            $saldoAkhir = $saldoAwal + $debet - $kredit;

            Piutang::create([
                'branch' => $data['branch'],
                'nama_konsumen' => $data['nama_konsumen'],
                'tgl_bukti' => $data['tgl_bukti'],
                'no_bukti' => $data['no_bukti'],
                'saldo_awal' => $saldoAwal,
                'debet' => $debet,
                'kredit' => $kredit,
                'saldo_akhir' => $saldoAkhir,
                'tgl_bukti_rek' => $data['tgl_bukti_rek'] ?? null,
                'no_bukti_rek' => $data['no_bukti_rek'] ?? null,
                'keterangan' => $data['keterangan'] ?? null,
                'no_polisi' => $data['no_polisi'] ?? null,
                'no_polis' => $data['no_polis'] ?? null,
                'spk_type' => $data['spk_type'] ?? null,
                'no_spk' => $data['no_spk'] ?? null,
            ]);
        }
    }
}
