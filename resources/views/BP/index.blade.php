@extends('layouts.app')

@section('title', 'BP - Rekapitulasi Piutang')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Rekapitulasi Piutang</h1>
            <p class="page-subtitle">Kelola data saldo awal, mutasi, rekonsiliasi GL, dan saldo akhir konsumen secara instan.
            </p>
        </div>
        <div class="server-time">
            <span class="dot"></span>
            <span>Waktu Server: {{ now()->setTimezone('Asia/Jakarta')->format('d M Y \\p\\u\\k\\u\\l H.i') }} WIB</span>
        </div>
    </div>

    <div class="toolbar">
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

    <div class="table-container">
        <div class="table-scroll">
            <table class="data-table" id="piutangTable">
                <thead>
                    <tr>
                        <th rowspan="2">NO</th>
                        <th rowspan="2">NAMA KONSUMEN</th>
                        <th rowspan="2">TGL. BUKTI</th>
                        <th rowspan="2">NO. BUKTI</th>
                        <th rowspan="2">SALDO AWAL</th>
                        <th colspan="2" style="text-align:center; border-bottom:1px solid var(--border-color);">MUTASI
                        </th>
                        <th rowspan="2">TGL. BUKTI</th>
                        <th rowspan="2" class="hl">NO. BUKTI</th>
                        <th rowspan="2">SALDO AKHIR</th>
                        <th rowspan="2">KETERANGAN</th>
                        <th rowspan="2">NO POLISI</th>
                        <th rowspan="2">NO POLIS</th>
                        <th rowspan="2">SPK</th>
                        <th rowspan="2">AKSI</th>
                    </tr>
                    <tr>
                        <th>DEBET</th>
                        <th>KREDIT</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records ?? [] as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->nama_konsumen ?? ($row['nama_konsumen'] ?? '-') }}</td>
                            <td>{{ optional($row->tgl_bukti ?? ($row['tgl_bukti'] ?? null))->format ? optional($row->tgl_bukti)->format('d M Y') : $row->tgl_bukti ?? '-' }}
                            </td>
                            <td>{{ $row->no_bukti ?? ($row['no_bukti'] ?? '-') }}</td>
                            <td class="text-bold">{{ $row->saldo_awal ?? ($row['saldo_awal'] ?? '-') }}</td>
                            <td class="text-green">{{ $row->debet ?? ($row['debet'] ?? '-') }}</td>
                            <td class="text-cyan">{{ $row->kredit ?? ($row['kredit'] ?? '-') }}</td>
                            <td>{{ optional($row->tgl_bukti_rek ?? ($row['tgl_bukti_rek'] ?? null))->format ? optional($row->tgl_bukti_rek)->format('d M Y') : $row->tgl_bukti_rek ?? '-' }}
                            </td>
                            <td>{{ $row->no_bukti_rek ?? ($row['no_bukti_rek'] ?? '-') }}</td>
                            <td class="text-bold">{{ $row->saldo_akhir ?? ($row['saldo_akhir'] ?? '-') }}</td>
                            <td class="">{{ $row->keterangan ?? ($row['keterangan'] ?? '-') }}</td>
                            <td class="">{{ $row->no_polisi ?? ($row['no_polisi'] ?? '-') }}</td>
                            <td class="">{{ $row->no_polis ?? ($row['no_polis'] ?? '-') }}</td>
                            <td class="">{{ strtoupper($row->spk_type ?? ($row['spk_type'] ?? '-')) }}</td>
                            <td>
                                <div style="display:flex;gap:4px;">
                                    <a href="{{ url('/bp/' . ($row->id ?? ($row['id'] ?? '')) . '/edit') }}"
                                        class="action-btn edit" title="Edit">✎</a>
                                    <form method="POST" action="{{ url('/bp/' . ($row->id ?? ($row['id'] ?? ''))) }}"
                                        style="display:inline">@csrf @method('DELETE')<button class="action-btn delete"
                                            title="Hapus">🗑</button></form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" style="text-align:center;color:var(--text-muted);">Tidak ada data untuk
                                ditampilkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Summary Section --}}
    <div style="margin-top: 24px;">
        <div class="table-container">
            <div class="table-scroll">
                <table class="data-table" style="border-top: 2px solid var(--accent-blue);">
                    <tbody>
                        <tr style="background-color: rgba(59, 130, 246, 0.1); font-weight: 600;">
                            <td colspan="4" style="text-align: right; padding-right: 16px;">Total</td>
                            <td style="text-align: right;">{{ number_format($totalSaldoAwal ?? 0, 2, ',', '.') }}</td>
                            <td style="text-align: right; color: var(--accent-emerald);">
                                {{ number_format($totalDebet ?? 0, 2, ',', '.') }}</td>
                            <td style="text-align: right; color: var(--accent-cyan);">
                                {{ number_format($totalKredit ?? 0, 2, ',', '.') }}</td>
                            <td colspan="2"></td>
                            <td style="text-align: right;">{{ number_format($totalSaldoAkhir ?? 0, 2, ',', '.') }}</td>
                            <td colspan="5"></td>
                        </tr>
                        <tr style="background-color: rgba(59, 130, 246, 0.05); font-weight: 600;">
                            <td colspan="4" style="text-align: right; padding-right: 16px;">GL</td>
                            <td style="text-align: right;">{{ number_format($totalSaldoAwal ?? 0, 2, ',', '.') }}</td>
                            <td style="text-align: right; color: var(--accent-emerald);">
                                {{ number_format($totalDebet ?? 0, 2, ',', '.') }}</td>
                            <td style="text-align: right; color: var(--accent-cyan);">
                                {{ number_format($totalKredit ?? 0, 2, ',', '.') }}</td>
                            <td colspan="2"></td>
                            <td style="text-align: right;">{{ number_format($totalSaldoAkhir ?? 0, 2, ',', '.') }}</td>
                            <td colspan="5"></td>
                        </tr>
                        <tr style="background-color: rgba(239, 68, 68, 0.05); font-weight: 600;">
                            <td colspan="4" style="text-align: right; padding-right: 16px;">SELISIH</td>
                            <td style="text-align: right;">-</td>
                            <td style="text-align: right;">-</td>
                            <td style="text-align: right;">-</td>
                            <td colspan="2"></td>
                            <td style="text-align: right;">-</td>
                            <td colspan="5"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Create (form SPK changed to generic 'SPK') --}}
    <div class="modal-overlay" id="createModal">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Tambah Data Piutang</h2>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger"
                        style="margin-bottom: 16px; padding: 12px 16px; background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.3); border-radius: 8px; color: var(--accent-red); font-size: 14px;">
                        <ul style="list-style: none;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="createForm" method="POST" action="{{ url('/bp') }}">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nama Konsumen</label>
                            <input type="text" name="nama_konsumen" class="form-input" placeholder="Nama konsumen"
                                value="{{ old('nama_konsumen') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tgl. Bukti</label>
                            <input type="date" name="tgl_bukti" class="form-input" value="{{ old('tgl_bukti') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">No. Bukti</label>
                            <input type="text" name="no_bukti" class="form-input" placeholder="Nomor bukti"
                                value="{{ old('no_bukti') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Saldo Awal</label>
                            <input type="text" name="saldo_awal" class="form-input" placeholder="0"
                                value="{{ old('saldo_awal') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Debet</label>
                            <input type="text" name="debet" class="form-input" placeholder="0"
                                value="{{ old('debet') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kredit</label>
                            <input type="text" name="kredit" class="form-input" placeholder="0"
                                value="{{ old('kredit') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tgl. Bukti (Rekonsiliasi)</label>
                            <input type="date" name="tgl_bukti_rek" class="form-input"
                                value="{{ old('tgl_bukti_rek') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">No. Bukti (Rekonsiliasi)</label>
                            <input type="text" name="no_bukti_rek" class="form-input" placeholder="Nomor bukti"
                                value="{{ old('no_bukti_rek') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="keterangan" class="form-input" placeholder="Keterangan"
                                value="{{ old('keterangan') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">No Polisi</label>
                            <input type="text" name="no_polisi" class="form-input" placeholder="Nomor polisi"
                                value="{{ old('no_polisi') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">No Polis</label>
                            <input type="text" name="no_polis" class="form-input" placeholder="Nomor polis"
                                value="{{ old('no_polis') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">SPK</label>
                            <select class="form-select" name="spk_type">
                                <option value="">Pilih Jenis SPK</option>
                                <option value="ASURANSI">ASURANSI</option>
                                <option value="REGULER">REGULER</option>
                            </select>
                        </div>
                        <div class="form-group full-width">
                            <label class="form-label">Nomor SPK</label>
                            <input type="text" name="no_spk" class="form-input" placeholder="Nomor SPK"
                                value="{{ old('no_spk') }}">
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
