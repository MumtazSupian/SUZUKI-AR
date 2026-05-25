@extends('layouts.app')

@section('title', 'GR Cianjur - Edit Piutang')

@section('content')
<div style="padding: 16px; max-width: 1100px; margin: 0 auto; box-sizing: border-box; background-color: #ffffff;">

    {{-- Header - Lebih Ringkas --}}
    <div class="page-header" style="margin-bottom: 16px; border-bottom: 2px solid #f3f4f6; padding-bottom: 8px;">
        <div>
            <h1 class="page-title" style="color: #dc2626 !important; font-weight: 700 !important; font-size: 20px; margin: 0;">Edit Data Piutang - GR Cianjur</h1>
            <p class="page-subtitle" style="color: #6b7280; font-size: 12px; margin-top: 2px;">Perbarui detail piutang konsumen cabang Cianjur.</p>
        </div>
    </div>

    {{-- Kumpulan Style Eksklusif (Ukuran Diperkecil) --}}
    <style>
        .form-section-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 12px 16px;
            margin-bottom: 12px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .section-title {
            font-size: 11px;
            font-weight: 700;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 10px;
            padding-bottom: 4px;
            border-bottom: 2px solid #fee2e2;
            display: inline-block;
        }

        .form-label {
            color: #4b5563 !important;
            font-weight: 600 !important;
            font-size: 12px !important;
            margin-bottom: 4px !important;
            display: block;
        }

        .form-input,
        .form-select {
            background-color: #ffffff !important;
            border: 1px solid #d1d5db !important;
            color: #111827 !important;
            width: 100%;
            padding: 6px 10px;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 13px;
            transition: all 0.15s ease-in-out;
        }

        .form-input:focus,
        .form-select:focus {
            border-color: #dc2626 !important;
            box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.15) !important;
            outline: none;
        }

        .btn-primary {
            background-color: #dc2626 !important;
            border: 1px solid #dc2626 !important;
            color: #ffffff !important;
            padding: 8px 18px;
            border-radius: 5px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #b91c1c !important;
        }

        .btn-secondary {
            background-color: #ffffff !important;
            border: 1px solid #d1d5db !important;
            color: #4b5563 !important;
            padding: 8px 18px;
            border-radius: 5px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background-color: #f9fafb !important;
        }
    </style>

    <form method="POST" action="{{ url('/gr/cianjur/' . ($id ?? ($record->id ?? ''))) }}">
        @csrf
        @method('PUT')

        {{-- Section 1: Informasi Konsumen --}}
        <div class="form-section-card">
            <span class="section-title" style="color: #dc2626; border-bottom-color: #fca5a5;">1. Informasi Konsumen</span>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px;">
                <div class="form-group">
                    <label class="form-label">Nama Konsumen</label>
                    <input type="text" name="nama_konsumen" class="form-input" value="{{ old('nama_konsumen', $record->nama_konsumen ?? ($record['nama_konsumen'] ?? '')) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">No. Polisi (Plat)</label>
                    <input type="text" name="no_polisi" class="form-input" value="{{ old('no_polisi', $record->no_polisi ?? ($record['no_polisi'] ?? '')) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">No. Polis (Asuransi)</label>
                    <input type="text" name="no_polis" class="form-input" value="{{ old('no_polis', $record->no_polis ?? ($record['no_polis'] ?? '')) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori SPK</label>
                    <select class="form-select" name="spk_type">
                        <option value="">Pilih Jenis SPK</option>
                        <option value="ASURANSI" {{ old('spk_type', $record->spk_type ?? ($record['spk_type'] ?? '')) == 'ASURANSI' ? 'selected' : '' }}>ASURANSI</option>
                        <option value="REGULER" {{ old('spk_type', $record->spk_type ?? ($record['spk_type'] ?? '')) == 'REGULER' ? 'selected' : '' }}>REGULER</option>
                        <option value="INTERNAL" {{ old('spk_type', $record->spk_type ?? ($record['spk_type'] ?? '')) == 'INTERNAL' ? 'selected' : '' }}>INTERNAL</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Section 2: Transaksi & Pembukuan Utama --}}
        <div class="form-section-card">
            <span class="section-title">2. Transaksi & Pembukuan Utama</span>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px;">
                <div class="form-group">
                    <label class="form-label">Tgl. Bukti Utama</label>
                    <input type="date" name="tgl_bukti" class="form-input" value="{{ old('tgl_bukti', isset($record->tgl_bukti) ? (\Illuminate\Support\Carbon::parse($record->tgl_bukti)->format('Y-m-d')) : ($record['tgl_bukti'] ?? '')) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">No. Bukti Utama</label>
                    <input type="text" name="no_bukti" class="form-input" value="{{ old('no_bukti', $record->no_bukti ?? ($record['no_bukti'] ?? '')) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Saldo Pembukuan (Awal)</label>
                    <input type="text" name="saldo_awal" class="form-input" value="{{ old('saldo_awal', $record->saldo_awal ?? ($record['saldo_awal'] ?? '')) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Debet</label>
                    <input type="text" name="debet" class="form-input" value="{{ old('debet', $record->debet ?? ($record['debet'] ?? '')) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Kredit</label>
                    <input type="text" name="kredit" class="form-input" value="{{ old('kredit', $record->kredit ?? ($record['kredit'] ?? '')) }}">
                </div>
            </div>
        </div>

        {{-- Section 3: Rekonsiliasi & Saldo Akhir --}}
        <div class="form-section-card" style="border-left: 3px solid #dc2626;">
            <span class="section-title" style="color: #dc2626; border-bottom-color: #fca5a5;">3. Rekonsiliasi & Saldo Akhir</span>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; margin-bottom: 10px;">
                <div class="form-group">
                    <label class="form-label">Tgl. Bukti (Rekonsiliasi)</label>
                    <input type="date" name="tgl_bukti_rek" class="form-input" value="{{ old('tgl_bukti_rek', isset($record->tgl_bukti_rek) ? (\Illuminate\Support\Carbon::parse($record->tgl_bukti_rek)->format('Y-m-d')) : ($record['tgl_bukti_rek'] ?? '')) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">No. Bukti (Rekonsiliasi)</label>
                    <input type="text" name="no_bukti_rek" class="form-input" value="{{ old('no_bukti_rek', $record->no_bukti_rek ?? ($record['no_bukti_rek'] ?? '')) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" class="form-input" value="{{ old('keterangan', $record->keterangan ?? ($record['keterangan'] ?? '')) }}">
                </div>
            </div>

            <div class="form-group" style="border-top: 1px dashed #e5e7eb; padding-top: 10px; display: flex; align-items: center; gap: 12px;">
                <label class="form-label" style="margin-bottom: 0 !important; white-space: nowrap; font-size: 13px !important; color: #111827 !important;">Total Saldo Akhir:</label>
                <input type="text" name="saldo_akhir" class="form-input" style="font-weight: 700; font-size: 14px; color: #111827; background-color: #f9fafb !important; max-width: 250px;" value="{{ old('saldo_akhir', $record->saldo_akhir ?? ($record['saldo_akhir'] ?? '')) }}">
            </div>
        </div>

        {{-- Footer Buttons --}}
        <div style="margin-top: 16px; display: flex; justify-content: flex-end; gap: 8px; border-top: 1px solid #e5e7eb; padding-top: 12px;">
            <button class="btn-secondary" type="button" onclick="history.back();return false;">Batal</button>
            <button class="btn-primary" type="submit">Simpan</button>
        </div>
    </form>
</div>
@endsection
