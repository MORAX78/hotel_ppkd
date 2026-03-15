@extends('layouts.app')
@section('title', 'Detail Reservasi')
@section('hero')
<div class="page-hero-eyebrow">Detail Reservasi</div>
<h1 class="page-hero-title">{{ $reservation->guest->name }}</h1>
<p class="page-hero-subtitle">Booking No: <strong style="color:#93C5FD;font-family:monospace;">{{ $reservation->booking_number }}</strong></p>
@endsection
@section('content')

<div style="display:flex;gap:var(--space-xl);align-items:flex-start;flex-wrap:wrap;">

  {{-- MAIN --}}
  <div style="flex:1;min-width:0;">

    {{-- Status Bar --}}
    <div class="card mb-xl">
      <div class="card-body" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:var(--space-md);">
        <div style="display:flex;align-items:center;gap:var(--space-xl);">
          <div>
            <div class="detail-label">Status</div>
            @php $badge = $reservation->status_badge; @endphp
            <span class="badge {{ $badge['class'] }}" style="font-size:0.8rem;padding:5px 14px;">{{ $badge['label'] }}</span>
          </div>
          <div><div class="detail-label">Malam</div><div class="detail-value large">{{ $reservation->total_nights }}</div></div>
          <div><div class="detail-label">Tamu</div><div class="detail-value large">{{ $reservation->number_of_persons }}</div></div>
          @if($reservation->room_rate_net)
          <div><div class="detail-label">Tarif / Malam</div><div class="detail-value large" style="color:var(--color-primary);">Rp {{ number_format($reservation->room_rate_net,0,',','.') }}</div></div>
          @endif
        </div>
        <form action="{{ route('reservations.updateStatus', $reservation) }}" method="POST" style="display:flex;gap:var(--space-sm);align-items:center;">
          @csrf @method('PATCH')
          <select name="status" class="form-control" style="width:auto;padding:6px 30px 6px 10px;font-size:0.8rem;">
            <option value="pending" {{ $reservation->status=='pending'?'selected':'' }}>Pending</option>
            <option value="confirmed" {{ $reservation->status=='confirmed'?'selected':'' }}>Confirmed</option>
            <option value="checked_in" {{ $reservation->status=='checked_in'?'selected':'' }}>Checked In</option>
            <option value="checked_out" {{ $reservation->status=='checked_out'?'selected':'' }}>Checked Out</option>
            <option value="cancelled" {{ $reservation->status=='cancelled'?'selected':'' }}>Cancelled</option>
          </select>
          <button type="submit" class="btn btn-primary btn-sm">Update</button>
        </form>
      </div>
    </div>

    {{-- Room Info --}}
    <div class="card mb-xl">
      <div class="card-header"><div class="card-header-left"><div class="card-header-icon"><i class="fas fa-door-closed"></i></div><div class="card-title">Informasi Kamar & Jadwal</div></div></div>
      <div class="card-body">
        <div class="detail-grid">
          <div class="detail-item"><div class="detail-label">No. Kamar</div><div class="detail-value">{{ $reservation->room_number ?? '—' }}</div></div>
          <div class="detail-item"><div class="detail-label">Jenis Kamar</div><div class="detail-value">{{ $reservation->room_type }}</div></div>
          <div class="detail-item"><div class="detail-label">Jumlah Kamar</div><div class="detail-value">{{ $reservation->number_of_rooms }}</div></div>
          <div class="detail-item"><div class="detail-label">Resepsionis</div><div class="detail-value">{{ $reservation->receptionist ?? '—' }}</div></div>
          <div class="detail-item"><div class="detail-label">Kedatangan</div><div class="detail-value">{{ $reservation->arrival_date->format('d F Y') }}</div></div>
          <div class="detail-item"><div class="detail-label">Waktu Kedatangan</div><div class="detail-value">{{ $reservation->arrival_time ?? '—' }}</div></div>
          <div class="detail-item"><div class="detail-label">Keberangkatan</div><div class="detail-value" style="color:var(--color-danger);">{{ $reservation->departure_date->format('d F Y') }}</div></div>
          <div class="detail-item"><div class="detail-label">Total Malam</div><div class="detail-value">{{ $reservation->total_nights }} malam</div></div>
        </div>
      </div>
    </div>

    {{-- Guest Info --}}
    <div class="card mb-xl">
      <div class="card-header"><div class="card-header-left"><div class="card-header-icon"><i class="fas fa-user"></i></div><div class="card-title">Data Tamu</div></div></div>
      <div class="card-body">
        <div class="detail-grid">
          <div class="detail-item"><div class="detail-label">Nama</div><div class="detail-value" style="font-family:var(--font-display);font-size:1.1rem;">{{ $reservation->guest->name }}</div></div>
          <div class="detail-item"><div class="detail-label">Pekerjaan</div><div class="detail-value">{{ $reservation->guest->profession ?? '—' }}</div></div>
          <div class="detail-item"><div class="detail-label">Perusahaan</div><div class="detail-value">{{ $reservation->guest->company ?? '—' }}</div></div>
          <div class="detail-item"><div class="detail-label">Kebangsaan</div><div class="detail-value">{{ $reservation->guest->nationality }}</div></div>
          <div class="detail-item"><div class="detail-label">No. KTP / Passport</div><div class="detail-value">{{ $reservation->guest->id_passport_number ?? '—' }}</div></div>
          <div class="detail-item"><div class="detail-label">Tanggal Lahir</div><div class="detail-value">{{ $reservation->guest->birth_date ? $reservation->guest->birth_date->format('d F Y') : '—' }}</div></div>
          <div class="detail-item" style="grid-column:span 2;"><div class="detail-label">Alamat</div><div class="detail-value">{{ $reservation->guest->address ?? '—' }}</div></div>
          <div class="detail-item"><div class="detail-label">Handphone</div><div class="detail-value">{{ $reservation->guest->mobile_phone ?? '—' }}</div></div>
          <div class="detail-item"><div class="detail-label">Email</div><div class="detail-value">{{ $reservation->guest->email ?? '—' }}</div></div>
          <div class="detail-item"><div class="detail-label">No. Member</div><div class="detail-value">{{ $reservation->guest->member_number ?? '—' }}</div></div>
        </div>
      </div>
    </div>

    {{-- Agent --}}
    @if($reservation->company_agent || $reservation->agent_telp || $reservation->agent_fax || $reservation->agent_email)
    <div class="card mb-xl">
      <div class="card-header"><div class="card-header-left"><div class="card-header-icon"><i class="fas fa-building"></i></div><div class="card-title">Data Agent / Perusahaan</div></div></div>
      <div class="card-body">
        <div class="detail-grid">
          <div class="detail-item"><div class="detail-label">Nama Agent</div><div class="detail-value">{{ $reservation->company_agent ?? '—' }}</div></div>
          <div class="detail-item"><div class="detail-label">Telepon Agent</div><div class="detail-value">{{ $reservation->agent_telp ?? '—' }}</div></div>
          <div class="detail-item"><div class="detail-label">Fax Agent</div><div class="detail-value">{{ $reservation->agent_fax ?? '—' }}</div></div>
          <div class="detail-item"><div class="detail-label">Email Agent</div><div class="detail-value">{{ $reservation->agent_email ?? '—' }}</div></div>
          <div class="detail-item"><div class="detail-label">Book By</div><div class="detail-value">{{ $reservation->book_by ?? '—' }}</div></div>
        </div>
      </div>
    </div>
    @endif

    {{-- Payment --}}
    <div class="card mb-xl">
      <div class="card-header"><div class="card-header-left"><div class="card-header-icon"><i class="fas fa-credit-card"></i></div><div class="card-title">Informasi Pembayaran</div></div></div>
      <div class="card-body">
        <div class="detail-item mb-md">
          <div class="detail-label">Metode Pembayaran</div>
          <div class="detail-value">
            @switch($reservation->payment_method)
              @case('cash') <span class="badge badge-success"><i class="fas fa-money-bill-wave"></i> Tunai</span> @break
              @case('bank_transfer') <span class="badge badge-info"><i class="fas fa-university"></i> Transfer Bank</span> @break
              @case('credit_card') <span class="badge badge-warning"><i class="fas fa-credit-card"></i> Kartu Kredit</span> @break
            @endswitch
          </div>
        </div>
        @if($reservation->payment_method==='bank_transfer')
        <div class="detail-grid">
          <div class="detail-item"><div class="detail-label">Bank</div><div class="detail-value">{{ $reservation->bank_name ?? '—' }}</div></div>
          <div class="detail-item"><div class="detail-label">No. Rekening</div><div class="detail-value">{{ $reservation->bank_account_number ?? '—' }}</div></div>
          <div class="detail-item"><div class="detail-label">Nama Rekening</div><div class="detail-value">{{ $reservation->bank_account_name ?? '—' }}</div></div>
        </div>
        @elseif($reservation->payment_method==='credit_card')
        <div class="detail-grid">
          <div class="detail-item"><div class="detail-label">Tipe Kartu</div><div class="detail-value">{{ $reservation->card_type ?? '—' }}</div></div>
          <div class="detail-item"><div class="detail-label">No. Kartu</div><div class="detail-value">{{ $reservation->card_number ?? '—' }}</div></div>
          <div class="detail-item"><div class="detail-label">Pemegang Kartu</div><div class="detail-value">{{ $reservation->card_holder_name ?? '—' }}</div></div>
          <div class="detail-item"><div class="detail-label">Exp. Date</div><div class="detail-value">{{ $reservation->card_expiry_date ?? '—' }}</div></div>
        </div>
        @endif
      </div>
    </div>

  </div>{{-- end main --}}

  {{-- SIDEBAR --}}
  <div style="width:260px;flex-shrink:0;">

    {{-- Actions --}}
    <div class="card mb-xl">
      <div class="card-header"><div class="card-title">Aksi Dokumen</div></div>
      <div class="card-body" style="display:flex;flex-direction:column;gap:var(--space-sm);">
        <a href="{{ route('reservations.print', $reservation) }}" target="_blank" class="btn btn-primary btn-block">
          <i class="fas fa-print"></i> Cetak Konfirmasi
        </a>
        <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-outline-primary btn-block">
          <i class="fas fa-edit"></i> Edit Reservasi
        </a>
        <div class="divider"></div>
        <a href="{{ route('reservations.index') }}" class="btn btn-outline btn-block">
          <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
      </div>
    </div>

    {{-- Deposit Box --}}
    @if($reservation->safety_deposit_box_number)
    <div class="card mb-xl">
      <div class="card-header"><div class="card-title">Safety Deposit Box</div></div>
      <div class="card-body">
        <div class="detail-item mb-sm"><div class="detail-label">Nomor Kotak</div><div class="detail-value">{{ $reservation->safety_deposit_box_number }}</div></div>
        <div class="detail-item mb-sm"><div class="detail-label">Dikeluarkan Oleh</div><div class="detail-value">{{ $reservation->issued_by ?? '—' }}</div></div>
        <div class="detail-item"><div class="detail-label">Tanggal</div><div class="detail-value">{{ $reservation->issued_date ? $reservation->issued_date->format('d M Y') : '—' }}</div></div>
      </div>
    </div>
    @endif

    {{-- Notes --}}
    @if($reservation->notes)
    <div class="card">
      <div class="card-header"><div class="card-title">Catatan</div></div>
      <div class="card-body"><p style="font-size:0.85rem;color:var(--color-text-soft);">{{ $reservation->notes }}</p></div>
    </div>
    @endif

  </div>{{-- end sidebar --}}

</div>
@endsection
