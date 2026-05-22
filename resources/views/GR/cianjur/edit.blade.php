@extends('layouts.app')

@section('title', 'GR Cianjur - Edit Piutang')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Data Piutang - GR Cianjur</h1>
            <p class="page-subtitle">Perbarui detail piutang konsumen cabang Cianjur.</p>
        </div>
    </div>

    <form method="POST" action="{{ url('/gr/cianjur/' . ($id ?? ($record->id ?? ''))) }}">
        @csrf
        @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Nama Konsumen</label>
                <input type="text" name="nama_konsumen" class="form-input"
                    value="{{ old('nama_konsumen', $record->nama_konsumen ?? ($record['nama_konsumen'] ?? '')) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Tgl. Bukti</label>
                <input type="date" name="tgl_bukti" class="form-input"
                    value="{{ old('tgl_bukti', isset($record->tgl_bukti) ? $record->tgl_bukti->format('Y-m-d') : $record['tgl_bukti'] ?? '') }}">
            </div>
            <div class="form-group">
                <label class="form-label">No. Bukti</label>
                <input type="text" name="no_bukti" class="form-input"
                    value="{{ old('no_bukti', $record->no_bukti ?? ($record['no_bukti'] ?? '')) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Saldo Awal</label>
                <input type="text" name="saldo_awal" class="form-input"
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
                <label class="form-label">SPK</label>
                <select class="form-select" name="spk_type">
                    <option value="">Pilih Jenis SPK</option>
                    <option value="ASURANSI"
                        {{ old('spk_type', $record->spk_type ?? ($record['spk_type'] ?? '')) == 'ASURANSI' ? 'selected' : '' }}>
                        ASURANSI</option>
                    <option value="REGULER"
                        {{ old('spk_type', $record->spk_type ?? ($record['spk_type'] ?? '')) == 'REGULER' ? 'selected' : '' }}>
                        REGULER</option>
                </select>
            </div>
            <div class="form-group full-width">
                <label class="form-label">Nomor SPK</label>
                <input type="text" name="no_spk" class="form-input"
                    value="{{ old('no_spk', $record->no_spk ?? ($record['no_spk'] ?? '')) }}">
            </div>
        </div>
        <div style="margin-top:16px;">
            <button class="btn-secondary" onclick="history.back();return false;">Batal</button>
            <button class="btn-primary" type="submit">Simpan</button>
        </div>
    </form>
