@extends('layouts.app')

@section('title', 'GR Jatiasih - Rekapitulasi Piutang')

@section('content')
    <div style="width: 100%; box-sizing: border-box; overflow-x: hidden;">
        <div class="page-header" style="margin-bottom: 20px;">
            <div>
                <h1 class="page-title">Rekapitulasi Piutang - GR Jatiasih</h1>
                <p class="page-subtitle">Kelola data saldo awal, mutasi, rekonsiliasi GL, dan saldo akhir konsumen cabang Jatiasih.</p>
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
                <button class="btn-primary" onclick="openModal()" id="btnTambahData"
                    style="background-color: #dc2626; border-color: #dc2626; color: #ffffff;">Tambah Data</button>
            </div>
        </div>

        {{-- Style Khusus: Tabel (Merah-Putih) & Modal (Putih-Merah) --}}
        <style>
            /* 1. TEMA TABEL */
            #piutangTable th,
            #piutangTable td {
                border: 1px solid #b91c1c !important;
                /* Garis merah elegan antar kolom */
            }

            #piutangTable thead th {
                color: #ffffff !important;
                /* Warna font judul putih */
                background-color: #111a36 !important;
                /* Background judul gelap agar font putih jelas */
            }

            #piutangTable tbody td {
                color: #111827 !important;
                /* Warna font isi tabel gelap pekat agar jelas */
            }

            /* 2. TEMA MODAL / FORM CREATE (PUTIH & MERAH) */
            .modal {
                background-color: #ffffff !important;
                /* Latar belakang putih */
                border: 2px solid #dc2626 !important;
                box-shadow: 0 25px 50px -12px rgba(220, 38, 38, 0.25) !important;
            }

            .modal-header {
                border-bottom: 1px solid #fee2e2 !important;
                background: #ffffff !important;
            }

            .modal-title {
                color: #dc2626 !important;
                /* Judul modal merah */
                font-weight: 700 !important;
            }

            .modal-body {
                background-color: #ffffff !important;
            }

            .form-label {
                color: #111827 !important;
                /* Label font gelap agar jelas */
                font-weight: 600 !important;
                margin-bottom: 6px !important;
                display: block;
            }

            .form-input,
            .form-select {
                background-color: #ffffff !important;
                /* Input background putih */
                border: 1px solid #d1d5db !important;
                /* Border abu standar */
                color: #111827 !important;
                /* Tulisan input gelap */
            }

            .form-input:focus,
            .form-select:focus {
                border-color: #dc2626 !important;
                /* Saat diklik berubah merah */
                box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
                outline: none;
            }

            .modal-footer {
                background-color: #f9fafb !important;
                border-top: 1px solid #fee2e2 !important;
            }

            .btn-primary {
                background-color: #dc2626 !important;
                /* Tombol Simpan Merah */
                border-color: #dc2626 !important;
                color: #ffffff !important;
            }

            .btn-primary:hover {
                background-color: #b91c1c !important;
            }

            .btn-secondary {
                background-color: #ffffff !important;
                /* Tombol Batal Putih */
                border: 1px solid #d1d5db !important;
                color: #374151 !important;
            }

            .modal-close {
                color: #9ca3af !important;
            }

            .modal-close:hover {
                color: #dc2626 !important;
            }
        </style>

        {{-- Kontainer Utama Tabel --}}
        <div class="table-container"
            style="width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; border-radius: 8px; background: #ffffff;">
            <div class="table-scroll" style="width: 100%; min-width: 1300px;">
                <table class="data-table" id="piutangTable" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th rowspan="2">NO</th>
                            <th rowspan="2">NAMA KONSUMEN</th>
                            <th rowspan="2">TGL. BUKTI</th>
                            <th rowspan="2" class="col-bukti">NO. BUKTI</th>
                            <th rowspan="2">SALDO AWAL</th>
                            <th colspan="2" style="text-align:center;">MUTASI</th>
                            <th rowspan="2" class="col-rek-tgl">TGL. BUKTI</th>
                            <th rowspan="2" class="hl col-rek-no">NO. BUKTI</th>
                            <th rowspan="2">SALDO AKHIR</th>
                            <th rowspan="2" class="col-keterangan">KETERANGAN</th>
                            <th rowspan="2" class="col-no-polisi">NO POLISI</th>
                            <th rowspan="2" class="col-no-polis">NO POLIS</th>
                            <th rowspan="2" class="col-spk">KATEGORI SPK</th>
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
                                $tglBukti = $rawTglBukti
                                    ? \Illuminate\Support\Carbon::parse($rawTglBukti)->format('d F Y')
                                    : '-';
                                $tglRek = $rawTglRek
                                    ? \Illuminate\Support\Carbon::parse($rawTglRek)->format('d F Y')
                                    : '-';

                                $saldoAwal = $row->saldo_awal ?? ($row['saldo_awal'] ?? 0);
                                $debet = $row->debet ?? ($row['debet'] ?? 0);
                                $kredit = $row->kredit ?? ($row['kredit'] ?? 0);
                                $saldoAkhir = $row->saldo_akhir ?? ($row['saldo_akhir'] ?? 0);

                                // 1. Set default style (jika tidak ada tanggal bukti)
                                $rowStyle = 'background-color: ' . ($loop->even ? '#fef2f2' : '#ffffff') . ';';

                                if ($rawTglBukti) {
                                    // Samakan timezone ke Asia/Jakarta agar perhitungannya sinkron dengan server
                                    $hariIni = \Illuminate\Support\Carbon::now('Asia/Jakarta')->startOfDay();
                                    $tanggalInput = \Illuminate\Support\Carbon::parse(
                                        $rawTglBukti,
                                        'Asia/Jakarta',
                                    )->startOfDay();

                                    // Hitung selisih hari
                                    $selisihHari = $tanggalInput->diffInDays($hariIni);

                                    // 2. LOGIC PEWARNAAN BERDASARKAN WAKTU
                                    if ($selisihHari > 30) {
                                        // Lebih dari 30 hari (Sebulan yang lalu) -> MERAH
                                        $rowStyle =
                                            'background-color: #f87171 !important; color: #111827 !important; font-weight: 600;';
                                    } elseif ($selisihHari >= 14) {
                                        // Sudah lewat 14 hari sampai 30 hari (2 minggu - sebulan) -> KUNING
                                        $rowStyle =
                                            'background-color: #fde047 !important; color: #111827 !important; font-weight: 600;';
                                    } else {
                                        // Kurang dari 14 hari (Inputan baru / di bawah 2 minggu) -> HIJAU
                                        $rowStyle =
                                            'background-color: #4ade80 !important; color: #111827 !important; font-weight: 600;';
                                    }
                                }
                            @endphp

                            <tr style="{{ $rowStyle }}">
                                <td style="text-align: center;">{{ $loop->iteration }}.</td>
                                <td>{{ $row->nama_konsumen ?? ($row['nama_konsumen'] ?? '-') }}</td>
                                <td>{{ $tglBukti }}</td>
                                <td>{{ $row->no_bukti ?? ($row['no_bukti'] ?? '-') }}</td>
                                <td class="text-bold">
                                    {{ is_numeric($saldoAwal) ? number_format($saldoAwal, 0, '.', ',') : '-' }}</td>
                                <td style="color: #111827 !important; font-weight: 800;">
                                    {{ is_numeric($debet) ? number_format($debet, 0, '.', ',') : '-' }}</td>
                                <td style="color: #111827 !important; font-weight: 800;">
                                    {{ is_numeric($kredit) ? number_format($kredit, 0, '.', ',') : '-' }}</td>
                                <td class="col-rek-tgl">{{ $tglRek }}</td>
                                <td class="col-rek-no">{{ $row->no_bukti_rek ?? ($row['no_bukti_rek'] ?? '-') }}</td>
                                <td class="text-bold">
                                    {{ is_numeric($saldoAkhir) ? number_format($saldoAkhir, 0, '.', ',') : '-' }}</td>
                                <td class="col-keterangan">{{ $row->keterangan ?? ($row['keterangan'] ?? '-') }}</td>
                                <td class="col-no-polisi">{{ $row->no_polisi ?? ($row['no_polisi'] ?? '-') }}</td>
                                <td class="col-no-polis">{{ $row->no_polis ?? ($row['no_polis'] ?? '-') }}</td>
                                <td class="col-spk">{{ strtoupper($row->spk_type ?? ($row['spk_type'] ?? '-')) }}</td>
                                <td class="col-action"
                                    style="background-color: #ffffff !important; border-left: 1px solid #e5e7eb;">
                                    <div
                                        style="display:flex; gap:12px; justify-content: center; align-items: center; height: 100%;">
                                        <a href="{{ url('/gr/jatiasih/' . ($row->id ?? ($row['id'] ?? '')) . '/edit') }}"
                                            class="action-btn edit" title="Edit"
                                            style="text-decoration: none; color: #2563eb !important; font-size: 16px; font-weight: bold;">✎</a>
                                        <form method="POST" action="{{ url('/gr/jatiasih/' . ($row->id ?? ($row['id'] ?? ''))) }}"
                                            style="display:inline; margin: 0;">
                                            @csrf @method('DELETE')
                                            <button class="action-btn delete" title="Hapus"
                                                style="background: none; border: none; padding: 0; color: #dc2626 !important; font-size: 16px; font-weight: bold; cursor: pointer;">🗑</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="no-data-row" style="background-color: #ffffff;">
                                <td colspan="15" style="text-align:center; color: #6b7280 !important; padding: 20px;">
                                    Tidak ada data untuk ditampilkan.</td>
                            </tr>
                        @endforelse
                    </tbody>

                    {{-- Bagian Footer / Summary --}}
                    <tfoot>
                        <tr style="background-color: #eff6ff; font-weight: 600;">
                            <td colspan="4"
                                style="text-align: right; padding-right: 16px; font-weight: bold; color: #111827;">Total
                            </td>
                            <td style="color: #111827;">{{ number_format($totalSaldoAwal ?? 0, 0, '.', ',') }}</td>
                            <td style="color: #111827;">{{ number_format($totalDebet ?? 0, 0, '.', ',') }}</td>
                            <td style="color: #111827;">{{ number_format($totalKredit ?? 0, 0, '.', ',') }}</td>
                            <td colspan="2"></td>
                            <td style="color: #111827;">{{ number_format($totalSaldoAkhir ?? 0, 0, '.', ',') }}</td>
                            <td colspan="5"></td>
                        </tr>
                        <tr style="background-color: #f8fafc; font-weight: 600;">
                            <td colspan="4"
                                style="text-align: right; padding-right: 16px; font-weight: bold; color: #111827;">GL</td>
                            <td style="color: #111827;">{{ number_format($totalSaldoAwal ?? 0, 0, '.', ',') }}</td>
                            <td style="color: #111827;">{{ number_format($totalDebet ?? 0, 0, '.', ',') }}</td>
                            <td style="color: #111827;">{{ number_format($totalKredit ?? 0, 0, '.', ',') }}</td>
                            <td colspan="2"></td>
                            <td style="color: #111827;">{{ number_format($totalSaldoAkhir ?? 0, 0, '.', ',') }}</td>
                            <td colspan="5"></td>
                        </tr>
                        <tr style="background-color: #fef2f2; font-weight: 600;">
                            <td colspan="4"
                                style="text-align: right; padding-right: 16px; font-weight: bold; color: #dc2626;">SELISIH
                            </td>
                            <td style="color: #dc2626;">-</td>
                            <td style="color: #dc2626;">-</td>
                            <td style="color: #dc2626;">-</td>
                            <td colspan="2"></td>
                            <td style="color: #dc2626;">-</td>
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
                        <div class="alert alert-danger"
                            style="margin-bottom: 16px; padding: 12px 16px; background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.3); border-radius: 8px; color: #dc2626; font-size: 14px;">
                            <ul style="list-style: none; margin: 0; padding: 0;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form id="createForm" method="POST" action="{{ url('/gr/jatiasih') }}">
                        @csrf
                        <div class="form-grid"
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 14px;">
                            <div class="form-group">
                                <label class="form-label">Nama Konsumen</label>
                                <input type="text" name="nama_konsumen" class="form-input"
                                    placeholder="Nama konsumen" value="{{ old('nama_konsumen') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tgl. Bukti</label>
                                <input type="date" name="tgl_bukti" class="form-input"
                                    value="{{ old('tgl_bukti') }}">
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
                                <label class="form-label">KATEGORI SPK</label>
                                <select class="form-select" name="spk_type" style="width: 100%;">
                                    <option value="">Pilih Jenis SPK</option>
                                    <option value="ASURANSI">ASURANSI</option>
                                    <option value="REGULER">REGULER</option>
                                    <option value="INTERNAL">INTERNAL</option>
                                </select>
                            </div>
                            <div class="form-group full-width" style="grid-column: 1 / -1;">
                                <label class="form-label">Saldo Akhir</label>
                                <input type="text" name="saldo_akhir" class="form-input" placeholder="Saldo Akhir"
                                    value="{{ old('saldo_akhir') }}">
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
    </div>

    {{-- Script Fitur Search Real-time & Shortcut Ctrl+K --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');

            // Listener Input Pencarian
            searchInput.addEventListener('input', function() {
                const filterValue = this.value.toLowerCase().trim();
                const tableRows = document.querySelectorAll('#piutangTable tbody tr');

                tableRows.forEach(row => {
                    // Jangan sembunyikan baris kalau bawaan data memang kosong
                    if (row.classList.contains('no-data-row')) return;

                    // Mengambil seluruh teks di baris tabel saat ini
                    const rowText = row.textContent.toLowerCase();

                    // Tampilkan/Sembunyikan baris berdasarkan kecocokan keyword pencarian
                    if (rowText.includes(filterValue)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // Fitur Shortcut: Tekan Ctrl + K untuk otomatis fokus ke Input Pencarian
            window.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                    e.preventDefault(); // Mencegah default browser search bar
                    searchInput.focus();
                }
            });
        });
    </script>
@endsection
