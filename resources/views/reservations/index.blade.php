@extends('layouts.app')
@section('title', 'Daftar Reservasi')
@section('hero')
<div class="page-hero-eyebrow">Sistem Manajemen Hotel</div>
<h1 class="page-hero-title">Daftar Reservasi</h1>
<p class="page-hero-subtitle">Kelola seluruh reservasi tamu PPKD Hotel Jakarta Pusat</p>
@endsection
@section('content')

<div class="stats-grid">
    <div class="stat-card"><div class="stat-icon gold"><i class="fas fa-calendar-check"></i></div><div class="stat-body"><div class="stat-number">{{ \App\Models\Reservation::count() }}</div><div class="stat-label">Total Reservasi</div></div></div>
    <div class="stat-card"><div class="stat-icon success"><i class="fas fa-door-open"></i></div><div class="stat-body"><div class="stat-number">{{ \App\Models\Reservation::where('status','checked_in')->count() }}</div><div class="stat-label">Tamu Check In</div></div></div>
    <div class="stat-card"><div class="stat-icon info"><i class="fas fa-clock"></i></div><div class="stat-body"><div class="stat-number">{{ \App\Models\Reservation::where('status','confirmed')->count() }}</div><div class="stat-label">Terkonfirmasi</div></div></div>
    <div class="stat-card"><div class="stat-icon dark"><i class="fas fa-users"></i></div><div class="stat-body"><div class="stat-number">{{ \App\Models\Guest::count() }}</div><div class="stat-label">Total Tamu</div></div></div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-header-icon"><i class="fas fa-list"></i></div>
            <div><div class="card-title">Semua Reservasi</div><div class="card-subtitle">{{ $reservations->total() }} data ditemukan</div></div>
        </div>
        <a href="{{ route('reservations.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Reservasi Baru</a>
    </div>

    @if($reservations->count() > 0)
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No. Booking</th>
                    <th>Nama Tamu</th>
                    <th>Kamar</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Malam</th>
                    <th>Status</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                <tr>
                    <td><span class="booking-no">{{ $reservation->booking_number }}</span></td>
                    <td>
                        <div class="guest-name">{{ $reservation->guest->name }}</div>
                        <div style="font-size:0.72rem;color:var(--color-text-soft);">{{ $reservation->guest->nationality }}</div>
                    </td>
                    <td>
                        <div style="font-weight:500;">{{ $reservation->room_number ?? '—' }}</div>
                        <div style="font-size:0.72rem;color:var(--color-text-soft);">{{ $reservation->room_type }}</div>
                    </td>
                    <td>{{ $reservation->arrival_date->format('d M Y') }}</td>
                    <td>{{ $reservation->departure_date->format('d M Y') }}</td>
                    <td style="text-align:center;">{{ $reservation->total_nights }}</td>
                    <td>
                        @php $badge = $reservation->status_badge; @endphp
                        <span class="badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                    </td>
                    <td>
                        <div class="btn-group" style="justify-content:flex-end;">
                            <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-outline btn-sm" title="Detail"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-outline-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                            <a href="{{ route('reservations.print', $reservation) }}" class="btn btn-outline btn-sm" target="_blank" title="Cetak"><i class="fas fa-print"></i></a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pagination-wrapper">{{ $reservations->links('vendor.pagination.custom') }}</div>
    @else
    <div class="empty-state">
        <div class="empty-state-icon"><i class="fas fa-calendar-times"></i></div>
        <div class="empty-state-title">Belum Ada Reservasi</div>
        <div class="empty-state-text">Mulai dengan membuat reservasi pertama untuk tamu hotel</div>
        <a href="{{ route('reservations.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Buat Reservasi Pertama</a>
    </div>
    @endif
</div>
@endsection
