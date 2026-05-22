@extends('layouts.app')

@section('title', 'GR Cianjur - Edit Piutang')

@section('content')
<div style="padding: 24px; max-width: 100%; box-sizing: border-box;">
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Data Piutang - GR Cianjur</h1>
            <p class="page-subtitle">Perbarui detail piutang konsumen cabang Cianjur.</p>
        </div>
    </div>

    <form method="POST" action="{{ url('/gr/cianjur/' . ($id ?? ($record->id ?? ''))) }}">
        @csrf
        @method('PUT')
        {{-- Menggunakan grid yang adaptif agar input tidak saling bertumpuk --}}
        <div class="form-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; width: 100%;">
            <div class="form-group">
                <label class="form-label">Nama Konsumen</label>
                <input type="text" name="nama_konsumen" class="form-input"
                    value="{{ old('nama_konsumen', $record->nama_konsumen ?? ($record['nama_konsumen'] ?? '')) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Tgl. Bukti</label>
                <input type="date" name="tgl_bukti" class="form-input"
                    value="{{ old('tgl_bukti', isset($record->tgl_bukti) ? (\Illuminate\Support\Carbon::parse($record->tgl_bukti)->format('Y-m-d')) : ($record['tgl_bukti'] ?? '')) }}">
            </div>
            <div class="form-group">
                <label class="form-label">No. Bukti</label>
                <input type="text" name="no_bukti" class="form-input"
                    value="{{ old('no_bukti', $record->no_bukti ?? ($record['no_bukti'] ?? '')) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Saldo Pembukuan (Saldo Awal)</label>
                <input type="text" name="saldo_awal" class="form-input" style="width: 100%;"
                    value="{{ old('saldo_awal', $record->saldo_awal ?? ($record['saldo_awal'] ?? '')) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Debet</label>
                <input type="text" name="debet" class="form-input"
                    value="{{ old('debet', $record->debet ?? ($record['debet'] ?? '')) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Kredit</label>
                <input type="text" name="kredit" class="form-input"
                    value="{{ old('kredit', $record->kredit ?? ($record['kredit'] ?? '')) }}">
            </div>

            {{-- Tambahan Field yang Sebelumnya Kurang --}}
            <div class="form-group">
                <label class="form-label">Tgl. Bukti (Rekonsiliasi)</label>
                <input type="date" name="tgl_bukti_rek" class="form-input"
                    value="{{ old('tgl_bukti_rek', isset($record->tgl_bukti_rek) ? (\Illuminate\Support\Carbon::parse($record->tgl_bukti_rek)->format('Y-m-d')) : ($record['tgl_bukti_rek'] ?? '')) }}">
            </div>
            <div class="form-group">
                <label class="form-label">No. Bukti (Rekonsiliasi)</label>
                <input type="text" name="no_bukti_rek" class="form-input"
                    value="{{ old('no_bukti_rek', $record->no_bukti_rek ?? ($record['no_bukti_rek'] ?? '')) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Keterangan</label>
                <input type="text" name="keterangan" class="form-input"
                    value="{{ old('keterangan', $record->keterangan ?? ($record['keterangan'] ?? '')) }}">
            </div>
            {{-- End Tambahan Field --}}

            <div class="form-group">
                <label class="form-label">No Polisi</label>
                <input type="text" name="no_polisi" class="form-input"
                    value="{{ old('no_polisi', $record->no_polisi ?? ($record['no_polisi'] ?? '')) }}">
            </div>
            <div class="form-group">
                <label class="form-label">No Polis</label>
                <input type="text" name="no_polis" class="form-input"
                    value="{{ old('no_polis', $record->no_polis ?? ($record['no_polis'] ?? '')) }}">
            </div>
            <div class="form-group">
                <label class="form-label">KATEGORI SPK</label>
                <select class="form-select" name="spk_type">
                    <option value="">Pilih Jenis SPK</option>
                    <option value="ASURANSI"
                        {{ old('spk_type', $record->spk_type ?? ($record['spk_type'] ?? '')) == 'ASURANSI' ? 'selected' : '' }}>
                        ASURANSI</option>
                    <option value="REGULER"
                        {{ old('spk_type', $record->spk_type ?? ($record['spk_type'] ?? '')) == 'REGULER' ? 'selected' : '' }}>
                        REGULER</option>
                    <option value="INTERNAL"
                        {{ old('spk_type', $record->spk_type ?? ($record['spk_type'] ?? '')) == 'INTERNAL' ? 'selected' : '' }}>
                        INTERNAL</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Saldo Akhir</label>
                <input type="text" name="saldo_akhir" class="form-input"
                    value="{{ old('saldo_akhir', $record->saldo_akhir ?? ($record['saldo_akhir'] ?? '')) }}">
            </div>
        </div>
        <div style="margin-top: 24px; display: flex; gap: 8px;">
            <button class="btn-secondary" onclick="history.back();return false;">Batal</button>
            <button class="btn-primary" type="submit">Simpan</button>
        </div>
    </form>
</div>
@endsection
