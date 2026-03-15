<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran — {{ $reservation->guest->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/print.css') }}">
</head>
<body>

{{-- Print Actions --}}
<div class="print-actions no-print" style="padding-top:16px;">
    <button onclick="window.print()" class="print-btn print-btn-primary">
        <i class="fas fa-print"></i> Cetak Formulir
    </button>
    <a href="{{ route('reservations.show', $reservation) }}" class="print-btn print-btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <a href="{{ route('reservations.print', $reservation) }}" target="_blank" class="print-btn print-btn-outline">
        <i class="fas fa-file-alt"></i> Lihat Konfirmasi
    </a>
</div>

{{-- Print Document --}}
<div class="print-page">

    {{-- Hotel Header --}}
    <div class="doc-header">
        <div style="width:55px;height:55px;margin:0 auto 4mm;border-radius:50%;border:1.5px solid #B8975A;display:flex;align-items:center;justify-content:center;font-size:22px;color:#B8975A;">
            &#9733;
        </div>
        <div class="doc-hotel-name">PPKD HOTEL</div>
        <div class="doc-gold-line"></div>
        <div class="doc-form-title">Formulir Pendaftaran</div>
        <div class="doc-form-subtitle">Registration</div>
    </div>

    {{-- Room Info Table --}}
    <table class="reg-table">
        <tr>
            <td class="field-label" rowspan="2" style="width:90px;">
                <span class="field-label-primary">Room No. {{ $reservation->room_number_1 ?? '——' }}</span>
                <span class="field-label-primary">Room No. {{ $reservation->room_number_2 ?? '——' }}</span>
            </td>
            <td class="field-label" style="width:120px;">
                <span class="field-label-primary">Jumlah Tamu</span>
                <span class="field-label-secondary">No. of Person</span>
            </td>
            <td class="field-value" colspan="2">{{ $reservation->number_of_persons }} Orang</td>
            <td class="field-label" style="width:80px;">
                <span class="field-label-primary">Receptionist</span>
            </td>
            <td class="field-value" rowspan="2">{{ $reservation->receptionist ?? '' }}</td>
        </tr>
        <tr>
            <td class="field-label">
                <span class="field-label-primary">Jumlah Kamar</span>
                <span class="field-label-secondary">No. of Room</span>
            </td>
            <td class="field-value">{{ $reservation->number_of_rooms }}</td>
            <td class="field-label">
                <span class="field-label-primary">Jenis Kamar</span>
                <span class="field-label-secondary">Room Type</span>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="checkout-notice">
                <strong>Check Out Time : 12.00 Noon</strong><br>
                Waktu Lapor Keluar : Jam 12.00 Siang
            </td>
        </tr>
    </table>

    {{-- Guest Data Table --}}
    <table class="reg-table">
        <tr>
            <td colspan="4" style="font-size:9px;color:#555;border-bottom:1px solid #ccc;padding:2mm 4mm;">
                Harap tulis dengan huruf cetak — <em>Please print in block letters</em>
            </td>
            <td class="field-label" style="white-space:nowrap;vertical-align:top;">
                <span class="field-label-primary">Waktu Kedatangan</span>
                <span class="field-label-secondary">Arrival Time</span>
            </td>
            <td class="field-value" style="vertical-align:top;">
                {{ $reservation->arrival_time->format('H:i') }}
            </td>
        </tr>
        <tr>
            <td class="field-label" style="white-space:nowrap;">
                <span class="field-label-primary">Nama</span>
                <span class="field-label-secondary">Name</span>
            </td>
            <td class="field-value large" colspan="3">{{ $reservation->guest->name }}</td>
            <td class="field-label" rowspan="3" style="white-space:nowrap;vertical-align:top;">
                <span class="field-label-primary">Tanggal Kedatangan</span>
                <span class="field-label-secondary">Arrival Date</span>
            </td>
            <td class="field-value" rowspan="3" style="vertical-align:top;">
                {{ $reservation->arrival_date->format('d M Y') }}
            </td>
        </tr>
        <tr>
            <td class="field-label" style="white-space:nowrap;">
                <span class="field-label-primary">Pekerjaan</span>
                <span class="field-label-secondary">Profession</span>
            </td>
            <td class="field-value" colspan="3">{{ $reservation->guest->profession ?? '' }}</td>
        </tr>
        <tr>
            <td class="field-label" style="white-space:nowrap;">
                <span class="field-label-primary">Perusahaan</span>
                <span class="field-label-secondary">Company</span>
            </td>
            <td class="field-value" colspan="3">{{ $reservation->guest->company ?? '' }}</td>
        </tr>
        <tr>
            <td class="field-label" style="white-space:nowrap;">
                <span class="field-label-primary">Kebangsaan</span>
                <span class="field-label-secondary">Nationality</span>
            </td>
            <td class="field-value">{{ $reservation->guest->nationality }}</td>
            <td class="field-label" style="white-space:nowrap;">
                <span class="field-label-primary">No. KTP</span>
                <span class="field-label-secondary">Passport No.</span>
            </td>
            <td class="field-value">{{ $reservation->guest->id_passport_number ?? '' }}</td>
            <td class="field-label" style="white-space:nowrap;color:#B8975A;">
                <span class="field-label-primary">Tanggal Lahir</span>
                <span class="field-label-secondary">Birth Date</span>
            </td>
            <td class="field-value">
                {{ $reservation->guest->birth_date ? $reservation->guest->birth_date->format('d M Y') : '' }}
            </td>
        </tr>
        <tr>
            <td class="field-label" style="white-space:nowrap;">
                <span class="field-label-primary">Alamat</span>
                <span class="field-label-secondary">Address</span>
            </td>
            <td class="field-value" colspan="2">{{ $reservation->guest->address ?? '' }}</td>
            <td class="field-label" style="font-size:9px;">
                <span class="field-label-primary">Telephone / Phone</span><br>
                <span style="color:#1C1C1C;">{{ $reservation->guest->phone ?? '' }}</span><br>
                <span class="field-label-primary" style="margin-top:2mm;display:block;">Handphone / Mobile</span><br>
                <span style="color:#1C1C1C;">{{ $reservation->guest->mobile_phone ?? '' }}</span>
            </td>
            <td class="field-label" style="white-space:nowrap;color:#B8975A;">
                <span class="field-label-primary">Tgl. Keberangkatan</span>
                <span class="field-label-secondary">Departure Date</span>
            </td>
            <td class="field-value" style="color:#B8975A;font-weight:500;">
                {{ $reservation->departure_date->format('d M Y') }}
            </td>
        </tr>
        <tr>
            <td class="field-label" style="white-space:nowrap;">
                <span class="field-label-primary">Email</span>
            </td>
            <td class="field-value" colspan="5">{{ $reservation->guest->email ?? '' }}</td>
        </tr>
        <tr>
            <td class="field-label" style="white-space:nowrap;">
                <span class="field-label-primary">No. Member</span>
            </td>
            <td class="field-value" colspan="5">{{ $reservation->guest->member_number ?? '' }}</td>
        </tr>

        {{-- Signature Area --}}
        <tr>
            <td colspan="6" style="height:20mm;vertical-align:bottom;padding:2mm 4mm;">
                <div style="display:flex;justify-content:space-between;">
                    <div style="font-size:9px;color:#888;">Catatan / Notes: {{ $reservation->notes ?? '' }}</div>
                    <div style="text-align:center;font-size:9px;color:#555;">
                        <div style="border-bottom:0.5px solid #999;width:40mm;height:15mm;"></div>
                        Tanda Tangan Tamu / Guest Signature
                    </div>
                </div>
            </td>
        </tr>

        {{-- Deposit Box --}}
        <tr>
            <td class="field-label" style="white-space:nowrap;">
                <span class="field-label-primary">Nomor Kotak Deposit</span>
                <span class="field-label-secondary">Safety Deposit Box Number</span>
            </td>
            <td class="field-value" colspan="2">{{ $reservation->safety_deposit_box_number ?? '' }}</td>
            <td class="field-label" style="white-space:nowrap;">
                <span class="field-label-primary">Dikeluarkan oleh</span>
                <span class="field-label-secondary">Issued</span>
            </td>
            <td class="field-value">{{ $reservation->issued_by ?? '' }}</td>
            <td class="field-label">
                <span class="field-label-primary">Tanggal</span>
                <span class="field-label-secondary">Date</span><br>
                <span style="color:#1C1C1C;font-size:10px;">{{ $reservation->issued_date ? $reservation->issued_date->format('d/m/Y') : '' }}</span>
            </td>
        </tr>
    </table>

</div>

</body>
</html>
