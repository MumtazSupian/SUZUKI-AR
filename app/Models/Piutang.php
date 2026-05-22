<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piutang extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch',
        'nama_konsumen',
        'tgl_bukti',
        'no_bukti',
        'saldo_awal',
        'debet',
        'kredit',
        'tgl_bukti_rek',
        'no_bukti_rek',
        'saldo_akhir',
        'keterangan',
        'no_polisi',
        'no_polis',
        'spk_type',
        'no_spk',
    ];

    protected $casts = [
        'tgl_bukti' => 'date',
        'tgl_bukti_rek' => 'date',
        'saldo_awal' => 'decimal:2',
        'debet' => 'decimal:2',
        'kredit' => 'decimal:2',
        'saldo_akhir' => 'decimal:2',
    ];
}
