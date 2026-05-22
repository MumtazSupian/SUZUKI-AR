@extends('layouts.app')

@section('title', 'GR Ciawi - Rekapitulasi Piutang')

@section('content')
<div style="width: 100%; box-sizing: border-box; overflow-x: hidden;">
    <div class="page-header" style="margin-bottom: 20px;">
        <div>
            <h1 class="page-title">Rekapitulasi Piutang - GR Ciawi</h1>
            <p class="page-subtitle">Kelola data saldo awal, mutasi, rekonsiliasi GL, dan saldo akhir konsumen cabang Ciawi.</p>
        </div>
        <div class="server-time">
            <span class="dot"></span>
            <span>Waktu Server: {{ now()->setTimezone('Asia/Jakarta')->format('d F Y \\p\\u\\k\\u\\l H.i') }} WIB</span>
        </div>
    </div>

    <div class="toolbar" style="margin-bottom: 20px;">
        <div class="search-wrapper">
            <input type="text" class="search-input" placeholder="Cari konsumen, no. bukti, plat/no. polisi, polis..."
                id="searchInput">
            <span class="search-shortcut">Ctrl+K</span>
        </div>
        <div class="toolbar-right">
            <span class="toolbar-label">Tampilkan:</span>
            <select class="toolbar-select" id="rowsPerPage">
                <option value="50">50 Baris</option>
                <option value="100">100 Baris</option>
                <option value="200">200 Baris</option>
            </select>
            <button class="btn-primary" onclick="openModal()" id="btnTambahData">Tambah Data</button>
        </div>
    </div>

    {{-- Kontainer Utama Tabel --}}
    <div class="table-container" style="width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; border-radius: 8px; background: #111a36;">
        <div class="table-scroll" style="width: 100%; min-width: 1300px;">
            <table class="data-table" id="piutangTable" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th rowspan="2">NO</th>
                        <th rowspan="2">NAMA KONSUMEN</th>
                        <th rowspan="2">TGL. BUKTI</th>
                        <th rowspan="2" class="col-bukti">NO. BUKTI</th>
                        <th rowspan="2">SALDO AWAL</th>
                        <th colspan="2" style="text-align:center; border-bottom:1px solid var(--border-color);">MUTASI</th>
                        <th rowspan="2" class="col-rek-tgl">TGL. BUKTI</th>
                        <th rowspan="2" class="hl col-rek-no">NO. BUKTI</th>
                        <th rowspan="2">SALDO AKHIR</th>
                        <th rowspan="2" class="col-keterangan">KETERANGAN</th>
                        <th rowspan="2" class="col-no-polisi">NO POLISI</th>
                        <th rowspan="2" class="col-no-polis">NO POLIS</th>
                        <th rowspan="2" class="col-spk">SPK</th>
                        <th rowspan="2" class="col-action">AKSI</th>
                    </tr>
                    <tr>
                        <th>DEBET</th>
                        <th>KREDIT</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records ?? [] as $row)
                        @php
                            $rawTglBukti = $row->tgl_bukti ?? ($row['tgl_bukti'] ?? null);
                            $rawTglRek = $row->tgl_bukti_rek ?? ($row['tgl_bukti_rek'] ?? null);
                            $tglBukti = $rawTglBukti ? (\Illuminate\Support\Carbon::parse($rawTglBukti)->format('d F Y')) : '-';
                            $tglRek = $rawTglRek ? (\Illuminate\Support\Carbon::parse($rawTglRek)->format('d F Y')) : '-';
                            $saldoAwal = $row->saldo_awal ?? ($row['saldo_awal'] ?? 0);
                            $debet = $row->debet ?? ($row['debet'] ?? 0);
                            $kredit = $row->kredit ?? ($row['kredit'] ?? 0);
                            $saldoAkhir = $row->saldo_akhir ?? ($row['saldo_akhir'] ?? 0);
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->nama_konsumen ?? ($row['nama_konsumen'] ?? '-') }}</td>
                            <td>{{ $tglBukti }}</td>
                            <td>{{ $row->no_bukti ?? ($row['no_bukti'] ?? '-') }}</td>

                            <td class="text-bold">{{ is_numeric($saldoAwal) ? number_format($saldoAwal, 0, '.', ',') : '-' }}</td>
                            <td class="text-green">{{ is_numeric($debet) ? number_format($debet, 0, '.', ',') : '-' }}</td>
                            <td class="text-cyan">{{ is_numeric($kredit) ? number_format($kredit, 0, '.', ',') : '-' }}</td>

                            <td class="col-rek-tgl">{{ $tglRek }}</td>
                            <td class="col-rek-no">{{ $row->no_bukti_rek ?? ($row['no_bukti_rek'] ?? '-') }}</td>

                            <td class="text-bold">{{ is_numeric($saldoAkhir) ? number_format($saldoAkhir, 0, '.', ',') : '-' }}</td>

                            <td class="col-keterangan">{{ $row->keterangan ?? ($row['keterangan'] ?? '-') }}</td>
                            <td class="col-no-polisi">{{ $row->no_polisi ?? ($row['no_polisi'] ?? '-') }}</td>
                            <td class="col-no-polis">{{ $row->no_polis ?? ($row['no_polis'] ?? '-') }}</td>
                            <td class="col-spk">{{ strtoupper($row->spk_type ?? ($row['spk_type'] ?? '-')) }}</td>
                            <td class="col-action">
                                <div style="display:flex; gap:6px;">
                                    <a href="{{ url('/gr/ciawi/' . ($row->id ?? ($row['id'] ?? '')) . '/edit') }}" class="action-btn edit" title="Edit" style="text-decoration: none;">✎</a>
                                    <form method="POST" action="{{ url('/gr/ciawi/' . ($row->id ?? ($row['id'] ?? ''))) }}" style="display:inline">@csrf @method('DELETE')<button class="action-btn delete" title="Hapus">🗑</button></form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" style="text-align:center; color:var(--text-muted); padding: 20px;">Tidak ada data untuk ditampilkan.</td>
                        </tr>
                    @endforelse
                </tbody>

                <tfoot style="border-top: 2px solid var(--accent-blue);">
                    <tr style="background-color: rgba(59, 130, 246, 0.15); font-weight: 600;">
                        <td colspan="4" style="text-align: right; padding-right: 16px; font-weight: bold;">Total</td>
                        <td>{{ number_format($totalSaldoAwal ?? 0, 0, '.', ',') }}</td>
                        <td style="color: var(--accent-emerald);">{{ number_format($totalDebet ?? 0, 0, '.', ',') }}</td>
                        <td style="color: var(--accent-cyan);">{{ number_format($totalKredit ?? 0, 0, '.', ',') }}</td>
                        <td colspan="2"></td>
                        <td>{{ number_format($totalSaldoAkhir ?? 0, 0, '.', ',') }}</td>
                        <td colspan="5"></td>
                    </tr>
                    <tr style="background-color: rgba(59, 130, 246, 0.08); font-weight: 600;">
                        <td colspan="4" style="text-align: right; padding-right: 16px; font-weight: bold;">GL</td>
                        <td>{{ number_format($totalSaldoAwal ?? 0, 0, '.', ',') }}</td>
                        <td style="color: var(--accent-emerald);">{{ number_format($totalDebet ?? 0, 0, '.', ',') }}</td>
                        <td style="color: var(--accent-cyan);">{{ number_format($totalKredit ?? 0, 0, '.', ',') }}</td>
                        <td colspan="2"></td>
                        <td>{{ number_format($totalSaldoAkhir ?? 0, 0, '.', ',') }}</td>
                        <td colspan="5"></td>
                    </tr>
                    <tr style="background-color: rgba(239, 68, 68, 0.08); font-weight: 600;">
                        <td colspan="4" style="text-align: right; padding-right: 16px; font-weight: bold; color: #ff6b6b;">SELISIH</td>
                        <td style="color: #ff6b6b;">-</td>
                        <td style="color: #ff6b6b;">-</td>
                        <td style="color: #ff6b6b;">-</td>
                        <td colspan="2"></td>
                        <td style="color: #ff6b6b;">-</td>
                        <td colspan="5"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Modal Create --}}
    <div class="modal-overlay" id="createModal">
        <div class="modal" style="max-width: 800px; width: 90%;">
            <div class="modal-header">
                <h2 class="modal-title">Tambah Data Piutang</h2>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger" style="margin-bottom: 16px; padding: 12px 16px; background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.3); border-radius: 8px; color: var(--accent-red); font-size: 14px;">
                        <ul style="list-style: none; margin: 0; padding: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="createForm" method="POST" action="{{ url('/gr/ciawi') }}">
                    @csrf
                    <div class="form-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 14px;">
                        <div class="form-group">
                            <label class="form-label">Nama Konsumen</label>
                            <input type="text" name="nama_konsumen" class="form-input" placeholder="Nama konsumen" value="{{ old('nama_konsumen') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tgl. Bukti</label>
                            <input type="date" name="tgl_bukti" class="form-input" value="{{ old('tgl_bukti') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">No. Bukti</label>
                            <input type="text" name="no_bukti" class="form-input" placeholder="Nomor bukti" value="{{ old('no_bukti') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Saldo Awal</label>
                            <input type="text" name="saldo_awal" class="form-input" placeholder="0" value="{{ old('saldo_awal') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Debet</label>
                            <input type="text" name="debet" class="form-input" placeholder="0" value="{{ old('debet') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kredit</label>
                            <input type="text" name="kredit" class="form-input" placeholder="0" value="{{ old('kredit') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tgl. Bukti (Rekonsiliasi)</label>
                            <input type="date" name="tgl_bukti_rek" class="form-input" value="{{ old('tgl_bukti_rek') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">No. Bukti (Rekonsiliasi)</label>
                            <input type="text" name="no_bukti_rek" class="form-input" placeholder="Nomor bukti" value="{{ old('no_bukti_rek') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="keterangan" class="form-input" placeholder="Keterangan" value="{{ old('keterangan') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">No Polisi</label>
                            <input type="text" name="no_polisi" class="form-input" placeholder="Nomor polisi" value="{{ old('no_polisi') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">No Polis</label>
                            <input type="text" name="no_polis" class="form-input" placeholder="Nomor polis" value="{{ old('no_polis') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">SPK</label>
                            <select class="form-select" name="spk_type" style="width: 100%;">
                                <option value="">Pilih Jenis SPK</option>
                                <option value="ASURANSI">ASURANSI</option>
                                <option value="REGULER">REGULER</option>
                            </select>
                        </div>
                        <div class="form-group full-width" style="grid-column: 1 / -1;">
                            <label class="form-label">Saldo Akhir</label>
                            <input type="text" name="saldo_akhir" class="form-input" placeholder="Saldo Akhir" value="{{ old('saldo_akhir') }}">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeModal()">Batal</button>
                <button class="btn-primary" form="createForm">Simpan</button>
            </div>
        </div>
    </div>

@endsection
