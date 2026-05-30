@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">Ringkasan data piutang konsumen AR Service.</p>
        </div>
        <div class="server-time">
            <span class="dot"></span>
            <span>Waktu Server: {{ now()->setTimezone('Asia/Jakarta')->format('d M Y \\p\\u\\k\\u\\l H.i') }} WIB</span>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="dashboard-grid">
        {{-- Total Piutang --}}
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(59,130,246,.15);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="1" x2="12" y2="23" />
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                </svg>
            </div>
            <div class="stat-value" style="color:#3b82f6;">Rp {{ number_format($totalPiutang ?? 0, 0, ',', '.') }}</div>
            <div class="stat-label">Total Piutang</div>
        </div>

        {{-- Total Konsumen --}}
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(16,185,129,.15);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
            <div class="stat-value" style="color:#10b981;">{{ $totalKonsumen ?? 0 }}</div>
            <div class="stat-label">Total Konsumen</div>
        </div>

        {{-- Total Debet --}}
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(6,182,212,.15);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#06b6d4" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                    <polyline points="17 6 23 6 23 12" />
                </svg>
            </div>
            <div class="stat-value" style="color:#06b6d4;">Rp {{ number_format($totalDebet ?? 0, 0, ',', '.') }}</div>
            <div class="stat-label">Total Mutasi Debet</div>
        </div>

        {{-- Total Kredit --}}
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(139,92,246,.15);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 18 13.5 8.5 8.5 13.5 1 6" />
                    <polyline points="17 18 23 18 23 12" />
                </svg>
            </div>
            <div class="stat-value" style="color:#8b5cf6;">Rp {{ number_format($totalKredit ?? 0, 0, ',', '.') }}</div>
            <div class="stat-label">Total Mutasi Kredit</div>
        </div>

        {{-- Cabang Aktif --}}
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(245,158,11,.15);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                    <circle cx="12" cy="10" r="3" />
                </svg>
            </div>
            <div class="stat-value" style="color:#f59e0b;">{{ $grBranchCount ?? 0 }}</div>
            <div class="stat-label">Cabang GR Aktif</div>
        </div>

        {{-- Selisih --}}
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(236,72,153,.15);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#ec4899" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
            </div>
            <div class="stat-value" style="color:#ec4899;">Rp {{ number_format($totalSelisih ?? 0, 0, ',', '.') }}</div>
            <div class="stat-label">Total Selisih</div>
        </div>
    </div>

    @if (!empty($branchSummaries))
        <div class="table-container" style="padding:24px; margin-top: 16px;">
            <h2 style="font-size:16px;font-weight:600;margin-bottom:16px;">Ringkasan Semua Cabang</h2>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;">
                @foreach ($branchSummaries as $branch => $summary)
                    <div class="stat-card" style="padding: 16px;">
                        <div style="font-size:13px;font-weight:700;margin-bottom:8px;color:#111827;">
                            {{ strtoupper($branch === 'bp' ? 'BP' : 'GR ' . ucfirst($branch)) }}</div>
                        <div style="font-size:28px;font-weight:700;color:#111827;">{{ $summary['count'] }}</div>
                        <div style="margin-top:6px;color:#6b7280;font-size:12px;">Jumlah data</div>
                        <div style="margin-top:12px;font-size:13px;color:#374151;">Saldo Akhir: Rp
                            {{ number_format($summary['saldo_akhir'] ?? 0, 0, ',', '.') }}</div>
                        <div style="font-size:13px;color:#374151;">Debet: Rp
                            {{ number_format($summary['debet'] ?? 0, 0, ',', '.') }}</div>
                        <div style="font-size:13px;color:#374151;">Kredit: Rp
                            {{ number_format($summary['kredit'] ?? 0, 0, ',', '.') }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if(auth()->check() && auth()->user()->is_admin)
        {{-- Quick Links --}}
        <div class="table-container" style="padding:24px;">
            <h2 style="font-size:16px;font-weight:600;margin-bottom:16px;">Akses Cepat</h2>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px;">
                <a href="{{ url('/bp') }}"
                    style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:var(--bg-primary);border:1px solid var(--border-color);border-radius:10px;text-decoration:none;color:var(--text-primary);transition:all .2s;">
                    <div
                        style="width:36px;height:36px;background:rgba(59,130,246,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="#3b82f6" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:13px;">BP</div>
                        <div style="font-size:11px;color:var(--text-muted);">Bukti Piutang</div>
                    </div>
                </a>
                <a href="{{ url('/gr/cinere') }}"
                    style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:var(--bg-primary);border:1px solid var(--border-color);border-radius:10px;text-decoration:none;color:var(--text-primary);transition:all .2s;">
                    <div
                        style="width:36px;height:36px;background:rgba(6,182,212,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="#06b6d4" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:13px;">GR Cinere</div>
                        <div style="font-size:11px;color:var(--text-muted);">Cabang Cinere</div>
                    </div>
                </a>
                <a href="{{ url('/gr/jatiasih') }}"
                    style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:var(--bg-primary);border:1px solid var(--border-color);border-radius:10px;text-decoration:none;color:var(--text-primary);transition:all .2s;">
                    <div
                        style="width:36px;height:36px;background:rgba(16,185,129,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="#10b981" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:13px;">GR Jatiasih</div>
                        <div style="font-size:11px;color:var(--text-muted);">Cabang Jatiasih</div>
                    </div>
                </a>
                <a href="{{ url('/gr/cianjur') }}"
                    style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:var(--bg-primary);border:1px solid var(--border-color);border-radius:10px;text-decoration:none;color:var(--text-primary);transition:all .2s;">
                    <div
                        style="width:36px;height:36px;background:rgba(245,158,11,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="#f59e0b" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:13px;">GR Cianjur</div>
                        <div style="font-size:11px;color:var(--text-muted);">Cabang Cianjur</div>
                    </div>
                </a>
                <a href="{{ url('/gr/ciawi') }}"
                    style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:var(--bg-primary);border:1px solid var(--border-color);border-radius:10px;text-decoration:none;color:var(--text-primary);transition:all .2s;">
                    <div
                        style="width:36px;height:36px;background:rgba(139,92,246,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="#8b5cf6" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:13px;">GR Ciawi</div>
                        <div style="font-size:11px;color:var(--text-muted);">Cabang Ciawi</div>
                    </div>
                </a>
            </div>
        </div>
    @endif

    <div class="table-container" style="padding:24px; margin-top:24px;">
        <h2 style="font-size:16px;font-weight:600;margin-bottom:16px;">Data Terbaru Semua Cabang</h2>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;min-width:860px;">
                <thead>
                    <tr style="background:#f3f4f6;">
                        <th
                            style="text-align:left;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">
                            Cabang</th>
                        <th
                            style="text-align:left;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">
                            No SPK</th>
                        <th
                            style="text-align:left;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">
                            No. Bukti</th>
                        <th
                            style="text-align:left;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">
                            Tgl Bukti</th>
                        <th
                            style="text-align:right;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">
                            Debet</th>
                        <th
                            style="text-align:right;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">
                            Kredit</th>
                        <th
                            style="text-align:right;padding:12px 10px;font-size:12px;color:#4b5563;border-bottom:1px solid #e5e7eb;">
                            Saldo Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentRecords as $record)
                        <tr style="border-bottom:1px solid #e5e7eb;">
                            <td style="padding:12px 10px;font-size:13px;color:#111827;">
                                {{ $record->branch === 'bp' ? 'BP' : 'GR ' . ucfirst($record->branch) }}</td>
                            <td style="padding:12px 10px;font-size:13px;color:#111827;">{{ $record->no_spk ?? $record->nama_konsumen }}</td>
                            <td style="padding:12px 10px;font-size:13px;color:#111827;">{{ $record->no_bukti }}</td>
                            <td style="padding:12px 10px;font-size:13px;color:#111827;">
                                {{ optional($record->tgl_bukti)->format('d M Y') }}</td>
                            <td style="padding:12px 10px;font-size:13px;color:#111827;text-align:right;">Rp
                                {{ number_format($record->debet ?? 0, 0, ',', '.') }}</td>
                            <td style="padding:12px 10px;font-size:13px;color:#111827;text-align:right;">Rp
                                {{ number_format($record->kredit ?? 0, 0, ',', '.') }}</td>
                            <td style="padding:12px 10px;font-size:13px;color:#111827;text-align:right;">Rp
                                {{ number_format($record->saldo_akhir ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:14px 10px;text-align:center;color:#6b7280;">Belum ada data
                                piutang untuk ditampilkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
