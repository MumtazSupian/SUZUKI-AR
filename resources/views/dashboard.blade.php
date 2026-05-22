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
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div class="stat-value" style="color:#3b82f6;">Rp 4.800.000</div>
        <div class="stat-label">Total Piutang</div>
    </div>

    {{-- Total Konsumen --}}
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(16,185,129,.15);">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div class="stat-value" style="color:#10b981;">4</div>
        <div class="stat-label">Total Konsumen</div>
    </div>

    {{-- Total Debet --}}
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(6,182,212,.15);">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#06b6d4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
        </div>
        <div class="stat-value" style="color:#06b6d4;">Rp 8.000</div>
        <div class="stat-label">Total Mutasi Debet</div>
    </div>

    {{-- Total Kredit --}}
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(139,92,246,.15);">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></svg>
        </div>
        <div class="stat-value" style="color:#8b5cf6;">Rp 8.000</div>
        <div class="stat-label">Total Mutasi Kredit</div>
    </div>

    {{-- Cabang Aktif --}}
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(245,158,11,.15);">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
        <div class="stat-value" style="color:#f59e0b;">4</div>
        <div class="stat-label">Cabang GR Aktif</div>
    </div>

    {{-- Selisih --}}
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(236,72,153,.15);">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#ec4899" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <div class="stat-value" style="color:#ec4899;">Rp 0</div>
        <div class="stat-label">Total Selisih</div>
    </div>
</div>

{{-- Quick Links --}}
<div class="table-container" style="padding:24px;">
    <h2 style="font-size:16px;font-weight:600;margin-bottom:16px;">Akses Cepat</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px;">
        <a href="{{ url('/bp') }}" style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:var(--bg-primary);border:1px solid var(--border-color);border-radius:10px;text-decoration:none;color:var(--text-primary);transition:all .2s;">
            <div style="width:36px;height:36px;background:rgba(59,130,246,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <div style="font-weight:600;font-size:13px;">BP</div>
                <div style="font-size:11px;color:var(--text-muted);">Bukti Piutang</div>
            </div>
        </a>
        <a href="{{ url('/gr/cinere') }}" style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:var(--bg-primary);border:1px solid var(--border-color);border-radius:10px;text-decoration:none;color:var(--text-primary);transition:all .2s;">
            <div style="width:36px;height:36px;background:rgba(6,182,212,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#06b6d4" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <div>
                <div style="font-weight:600;font-size:13px;">GR Cinere</div>
                <div style="font-size:11px;color:var(--text-muted);">Cabang Cinere</div>
            </div>
        </a>
        <a href="{{ url('/gr/jatiasih') }}" style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:var(--bg-primary);border:1px solid var(--border-color);border-radius:10px;text-decoration:none;color:var(--text-primary);transition:all .2s;">
            <div style="width:36px;height:36px;background:rgba(16,185,129,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <div>
                <div style="font-weight:600;font-size:13px;">GR Jatiasih</div>
                <div style="font-size:11px;color:var(--text-muted);">Cabang Jatiasih</div>
            </div>
        </a>
        <a href="{{ url('/gr/cianjur') }}" style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:var(--bg-primary);border:1px solid var(--border-color);border-radius:10px;text-decoration:none;color:var(--text-primary);transition:all .2s;">
            <div style="width:36px;height:36px;background:rgba(245,158,11,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <div>
                <div style="font-weight:600;font-size:13px;">GR Cianjur</div>
                <div style="font-size:11px;color:var(--text-muted);">Cabang Cianjur</div>
            </div>
        </a>
        <a href="{{ url('/gr/ciawi') }}" style="display:flex;align-items:center;gap:12px;padding:14px 16px;background:var(--bg-primary);border:1px solid var(--border-color);border-radius:10px;text-decoration:none;color:var(--text-primary);transition:all .2s;">
            <div style="width:36px;height:36px;background:rgba(139,92,246,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <div>
                <div style="font-weight:600;font-size:13px;">GR Ciawi</div>
                <div style="font-size:11px;color:var(--text-muted);">Cabang Ciawi</div>
            </div>
        </a>
    </div>
</div>
@endsection
