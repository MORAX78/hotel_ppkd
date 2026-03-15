<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmation — {{ $reservation->booking_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/print.css') }}">
    <style>
        .logo-circle { width:60px;height:60px;border-radius:50%;border:1.5px solid #B8975A;display:flex;align-items:center;justify-content:center;margin:0 auto 3mm;overflow:hidden;background:#fff; }
        .logo-circle img { width:52px;height:52px;object-fit:contain; }
        .logo-fallback { font-size:20px;color:#B8975A; }

        /* Compact single-page layout */
        .print-page { padding: 12mm 15mm; }
        .doc-header  { padding-bottom: 3mm; margin-bottom: 3mm; }
        .doc-hotel-name { font-size: 16px; }

        .confirm-doc { font-size: 10px; }
        .confirm-title { font-size: 13px; margin-bottom: 3mm; }
        .confirm-hr { margin: 2.5mm 0; }
        .confirm-hr-gold { margin: 2.5mm 0; }
        .confirm-field-row { margin-bottom: 1.5mm; }
        .confirm-field-label { width: 42mm; font-size: 10px; }
        .confirm-two-col { gap: 0 8mm; margin-bottom: 2.5mm; }
        .confirm-box { padding: 2.5mm; margin-bottom: 2.5mm; font-size: 9.5px; }
        .confirm-box p { margin-bottom: 1mm; }
        .confirm-policy { font-size: 9px; }
        .confirm-policy ol { padding-left: 5mm; }
        .confirm-policy li { margin-bottom: 1mm; }
        .confirm-signature-area { margin-top: 4mm; }
        .confirm-signature-line { height: 8mm; width: 45mm; }
    </style>
</head>
<body>

{{-- Screen-only actions --}}
<div class="print-actions no-print" style="padding-top:16px;">
    <button onclick="window.print()" class="print-btn print-btn-primary"><i class="fas fa-print"></i> Cetak Konfirmasi</button>
    <a href="{{ route('reservations.show', $reservation) }}" class="print-btn print-btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="print-page">

    {{-- Header --}}
    <div class="doc-header">
        <div class="logo-circle">
            <img src="{{ asset('images/ppkd-logo.jpg') }}" alt="Logo PPKD"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
            <span class="logo-fallback" style="display:none;">&#9733;</span>
        </div>
        <div class="doc-hotel-name">PPKD HOTEL</div>
        <div class="doc-gold-line"></div>
    </div>

    <div class="confirm-doc">
        <div class="confirm-title">Reservation Confirmation</div>
        <hr class="confirm-hr">

        {{-- 2-column header: kiri = info tamu/agent, kanan = telp/fax/email/date --}}
        <div class="confirm-two-col">
            <div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">To.</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ $reservation->guest->name }}</div>
                </div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Company / Agent</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ $reservation->company_agent ?? '' }}</div>
                </div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Booking No.</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value" style="font-family:monospace;font-size:9px;">{{ $reservation->booking_number }}</div>
                </div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Book By</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ $reservation->book_by ?? '' }}</div>
                </div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Phone</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ $reservation->guest->mobile_phone ?? '' }}</div>
                </div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Email</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ $reservation->guest->email ?? '' }}</div>
                </div>
            </div>
            <div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Telp</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ $reservation->agent_telp ?? '' }}</div>
                </div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Fax</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ $reservation->agent_fax ?? '' }}</div>
                </div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Email</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ $reservation->agent_email ?? '' }}</div>
                </div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Date</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ $reservation->created_at->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>

        <hr class="confirm-hr">

        {{-- Reservation detail --}}
        <div class="confirm-two-col">
            <div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">First Name</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value" style="font-weight:500;">{{ $reservation->guest->name }}</div>
                </div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Arrival Date</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ $reservation->arrival_date->format('d F Y') }}</div>
                </div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Departure Date</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value" style="color:#8A3A3A;">{{ $reservation->departure_date->format('d F Y') }}</div>
                </div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Total Night</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ $reservation->total_nights }} Night(s)</div>
                </div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Room / Unit Type</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ $reservation->room_type }}{{ $reservation->room_number ? ' (Room '.$reservation->room_number.')' : '' }}</div>
                </div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Person Pax</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ $reservation->number_of_persons }} Person(s)</div>
                </div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Room Rate Net</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ $reservation->room_rate_net ? 'Rp '.number_format($reservation->room_rate_net,0,',','.') : '—' }}</div>
                </div>
            </div>
        </div>

        <hr class="confirm-hr-gold">

        {{-- Payment box --}}
        <div class="confirm-box">
            <p>Please guarantee this booking with credit card number with clear copy of the card both sides and card holder signature in the column provided. The copy of credit card both sides should be faxed to hotel fax number. Please settle your outstanding to or account:</p>
        </div>

        @if($reservation->payment_method === 'bank_transfer')
        <div style="margin-bottom:3mm;">
            <strong style="font-size:10px;">Bank Transfer</strong>
            <div class="confirm-field-row" style="margin-top:1mm;">
                <div class="confirm-field-label">{{ $reservation->bank_name ?? 'Mandiri' }} Account</div>
                <div class="confirm-field-colon">:</div>
                <div class="confirm-field-value">{{ $reservation->bank_account_number ?? '' }}</div>
            </div>
            <div class="confirm-field-row">
                <div class="confirm-field-label">{{ $reservation->bank_name ?? 'Mandiri' }} Name Account</div>
                <div class="confirm-field-colon">:</div>
                <div class="confirm-field-value">{{ $reservation->bank_account_name ?? '' }}</div>
            </div>
        </div>
        @endif

        <hr class="confirm-hr">

        {{-- Credit card --}}
        <p style="margin-bottom:2mm;font-size:10px;font-weight:500;">Reservation guaranteed by the following credit card:</p>
        <div class="confirm-two-col">
            <div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Card Number</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ $reservation->card_number ?? '' }}</div>
                </div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Card holder name</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ $reservation->card_holder_name ?? '' }}</div>
                </div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Card Type</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ $reservation->card_type ?? '' }}</div>
                </div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Payment Method</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ ucwords(str_replace('_',' ',$reservation->payment_method)) }}</div>
                </div>
            </div>
            <div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Or by Bank Transfer to</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ $reservation->bank_account_number ?? '' }}</div>
                </div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Expired date / month / year</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value">{{ $reservation->card_expiry_date ?? '' }}</div>
                </div>
                <div class="confirm-field-row">
                    <div class="confirm-field-label">Card holder signature</div>
                    <div class="confirm-field-colon">:</div>
                    <div class="confirm-field-value" style="border-bottom:0.5px solid #999;min-width:28mm;height:7mm;"></div>
                </div>
            </div>
        </div>

        <hr class="confirm-hr">

        {{-- Cancellation policy + Guest Signature side by side --}}
        <div style="display:flex;justify-content:space-between;align-items:flex-end;gap:10mm;">
            <div class="confirm-policy" style="flex:1;">
                <p style="font-weight:600;margin-bottom:2mm;">Cancellation policy:</p>
                <ol>
                    <li>Please note that check in time is 02.00 pm and check out time 12.00 pm.</li>
                    <li>All non guaranteed reservations will automatically be released on 6 pm.</li>
                    <li>The Hotel will charge 1 night for guaranteed reservations that have not been canceled before the day of arrival.</li>
                </ol>
            </div>
            <div style="text-align:center;flex-shrink:0;">
                <div style="height:12mm;"></div>
                <div style="border-bottom:0.5px solid #333;width:40mm;"></div>
                <div style="font-size:9px;margin-top:2mm;color:#555;">Guest Signature</div>
                <div style="font-size:9px;margin-top:3mm;color:#555;">Date : {{ $reservation->created_at->format('d/m/Y') }}</div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
