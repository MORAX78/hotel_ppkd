@extends('layouts.app')
@section('title', 'Edit Reservasi')
@section('hero')
<div class="page-hero-eyebrow">Edit Reservasi</div>
<h1 class="page-hero-title">Edit Reservasi</h1>
<p class="page-hero-subtitle">No. Booking: <strong style="color:#93C5FD;font-family:monospace;">{{ $reservation->booking_number }}</strong></p>
@endsection
@section('content')

@php $g = $reservation->guest; @endphp

<form action="{{ route('reservations.update', $reservation) }}" method="POST" id="reservationForm">
@csrf @method('PUT')

@if($errors->any())
<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>
    <div><strong>Harap perbaiki:</strong><ul style="margin-top:4px;padding-left:16px;">
    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
</div>
@endif

{{-- KAMAR --}}
<div class="card mb-xl">
    <div class="card-header"><div class="card-header-left"><div class="card-header-icon"><i class="fas fa-door-closed"></i></div><div><div class="card-title">Informasi Kamar</div></div></div></div>
    <div class="card-body">
        <div class="form-grid">
            <div class="form-group col-3"><label class="form-label">No. Kamar</label><input type="text" name="room_number" class="form-control" value="{{ old('room_number', $reservation->room_number) }}" placeholder="mis. 0601"></div>
            <div class="form-group col-3"><label class="form-label">Jumlah Tamu <span class="required">*</span></label><input type="number" name="number_of_persons" class="form-control" value="{{ old('number_of_persons', $reservation->number_of_persons) }}" min="1" required></div>
            <div class="form-group col-3"><label class="form-label">Jumlah Kamar <span class="required">*</span></label><input type="number" name="number_of_rooms" class="form-control" value="{{ old('number_of_rooms', $reservation->number_of_rooms) }}" min="1" required></div>
            <div class="form-group col-3"><label class="form-label">Resepsionis</label><input type="text" name="receptionist" class="form-control" value="{{ old('receptionist', $reservation->receptionist) }}"></div>
            <div class="form-group col-4">
                <label class="form-label">Jenis Kamar <span class="required">*</span></label>
                <select name="room_type" id="roomTypeSelect" class="form-control" required>
                    <option value="">— Pilih Tipe —</option>
                    @foreach(['Standard'=>350000,'Superior'=>450000,'Deluxe'=>600000,'Junior Suite'=>850000,'Suite'=>1200000,'Executive'=>1500000] as $t=>$r)
                    <option value="{{ $t }}" data-rate="{{ $r }}" {{ old('room_type',$reservation->room_type)==$t?'selected':'' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-4"><label class="form-label">Tarif / Malam (Rp)</label><input type="number" name="room_rate_net" id="roomRateInput" class="form-control" value="{{ old('room_rate_net', $reservation->room_rate_net) }}" step="1000"><span class="form-hint" id="rateHint"></span></div>
            <div class="form-group col-4"><label class="form-label">Total Estimasi</label><input type="text" id="totalEstimasi" class="form-control" readonly></div>
        </div>
        <div class="divider"></div>
        <div class="form-grid">
            <div class="form-group col-3"><label class="form-label">Waktu Kedatangan <span class="required">*</span></label><input type="time" name="arrival_time" class="form-control" value="{{ old('arrival_time', $reservation->arrival_time) }}" required></div>
            <div class="form-group col-3"><label class="form-label">Tanggal Kedatangan <span class="required">*</span></label><input type="date" name="arrival_date" id="arrivalDate" class="form-control" value="{{ old('arrival_date', $reservation->arrival_date?->format('Y-m-d')) }}" required></div>
            <div class="form-group col-3"><label class="form-label">Tanggal Keberangkatan <span class="required">*</span></label><input type="date" name="departure_date" id="departureDate" class="form-control" value="{{ old('departure_date', $reservation->departure_date?->format('Y-m-d')) }}" required></div>
            <div class="form-group col-3"><label class="form-label">Jumlah Malam</label><input type="text" id="totalNights" class="form-control" readonly></div>
        </div>
    </div>
</div>

{{-- DATA TAMU --}}
<div class="card mb-xl">
    <div class="card-header"><div class="card-header-left"><div class="card-header-icon"><i class="fas fa-user"></i></div><div><div class="card-title">Data Tamu</div></div></div></div>
    <div class="card-body">
        <div class="form-grid">
            <div class="form-group col-6"><label class="form-label">Nama <span class="required">*</span></label><input type="text" name="name" class="form-control" value="{{ old('name', $g->name) }}" required></div>
            <div class="form-group col-6"><label class="form-label">Pekerjaan</label><input type="text" name="profession" class="form-control" value="{{ old('profession', $g->profession) }}"></div>
            <div class="form-group col-6"><label class="form-label">Perusahaan</label><input type="text" name="company" class="form-control" value="{{ old('company', $g->company) }}"></div>
            <div class="form-group col-3"><label class="form-label">Kebangsaan <span class="required">*</span></label><input type="text" name="nationality" class="form-control" value="{{ old('nationality', $g->nationality) }}" required></div>
            <div class="form-group col-3"><label class="form-label">No. KTP / Passport</label><input type="text" name="id_passport_number" class="form-control" value="{{ old('id_passport_number', $g->id_passport_number) }}"></div>
            <div class="form-group col-3"><label class="form-label">Tanggal Lahir</label><input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $g->birth_date?->format('Y-m-d')) }}"></div>
            <div class="form-group col-9"><label class="form-label">Alamat</label><input type="text" name="address" class="form-control" value="{{ old('address', $g->address) }}"></div>
            <div class="form-group col-4"><label class="form-label">Handphone</label><input type="tel" name="mobile_phone" class="form-control" value="{{ old('mobile_phone', $g->mobile_phone) }}"></div>
            <div class="form-group col-4"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $g->email) }}"></div>
            <div class="form-group col-4"><label class="form-label">No. Member</label><input type="text" name="member_number" class="form-control" value="{{ old('member_number', $g->member_number) }}"></div>
        </div>
    </div>
</div>

{{-- AGENT --}}
<div class="card mb-xl">
    <div class="card-header"><div class="card-header-left"><div class="card-header-icon"><i class="fas fa-building"></i></div><div><div class="card-title">Data Agent / Perusahaan</div></div></div></div>
    <div class="card-body">
        <div class="form-grid">
            <div class="form-group col-6"><label class="form-label">Nama Agent / Perusahaan</label><input type="text" name="company_agent" class="form-control" value="{{ old('company_agent', $reservation->company_agent) }}"></div>
            <div class="form-group col-6"><label class="form-label">Telepon Agent</label><input type="text" name="agent_telp" class="form-control" value="{{ old('agent_telp', $reservation->agent_telp) }}"></div>
            <div class="form-group col-6"><label class="form-label">Fax Agent</label><input type="text" name="agent_fax" class="form-control" value="{{ old('agent_fax', $reservation->agent_fax) }}"></div>
            <div class="form-group col-6"><label class="form-label">Email Agent</label><input type="email" name="agent_email" class="form-control" value="{{ old('agent_email', $reservation->agent_email) }}"></div>
            <div class="form-group col-6"><label class="form-label">Dipesan Oleh / Book By</label><input type="text" name="book_by" class="form-control" value="{{ old('book_by', $reservation->book_by) }}"></div>
            <div class="form-group col-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    @foreach(['pending'=>'Pending','confirmed'=>'Confirmed','checked_in'=>'Checked In','checked_out'=>'Checked Out','cancelled'=>'Cancelled'] as $val=>$label)
                    <option value="{{ $val }}" {{ old('status',$reservation->status)==$val?'selected':'' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

{{-- PEMBAYARAN --}}
<div class="card mb-xl">
    <div class="card-header"><div class="card-header-left"><div class="card-header-icon"><i class="fas fa-credit-card"></i></div><div><div class="card-title">Metode Pembayaran</div></div></div></div>
    <div class="card-body">
        <label class="form-label" style="margin-bottom:8px;display:block;">Metode Pembayaran <span class="required">*</span></label>
        <div class="payment-tabs">
            <button type="button" class="payment-tab {{ old('payment_method',$reservation->payment_method)=='cash'?'active':'' }}" onclick="setPayment('cash',this)"><i class="fas fa-money-bill-wave"></i> Tunai</button>
            <button type="button" class="payment-tab {{ old('payment_method',$reservation->payment_method)=='bank_transfer'?'active':'' }}" onclick="setPayment('bank_transfer',this)"><i class="fas fa-university"></i> Transfer Bank</button>
            <button type="button" class="payment-tab {{ old('payment_method',$reservation->payment_method)=='credit_card'?'active':'' }}" onclick="setPayment('credit_card',this)"><i class="fas fa-credit-card"></i> Kartu Kredit</button>
        </div>
        <input type="hidden" name="payment_method" id="paymentMethod" value="{{ old('payment_method',$reservation->payment_method) }}">
        <div class="payment-section {{ old('payment_method',$reservation->payment_method)=='cash'?'active':'' }}" id="payment-cash">
            <p style="color:var(--color-text-soft);font-size:0.82rem;padding:var(--space-md) 0;"><i class="fas fa-check-circle text-primary"></i> Pembayaran dilakukan secara tunai saat check-in.</p>
        </div>
        <div class="payment-section {{ old('payment_method',$reservation->payment_method)=='bank_transfer'?'active':'' }}" id="payment-bank_transfer">
            <div class="form-grid" style="margin-top:var(--space-md);">
                <div class="form-group col-4"><label class="form-label">Nama Bank</label><input type="text" name="bank_name" class="form-control" value="{{ old('bank_name',$reservation->bank_name) }}"></div>
                <div class="form-group col-4"><label class="form-label">No. Rekening</label><input type="text" name="bank_account_number" class="form-control" value="{{ old('bank_account_number',$reservation->bank_account_number) }}"></div>
                <div class="form-group col-4"><label class="form-label">Nama Rekening</label><input type="text" name="bank_account_name" class="form-control" value="{{ old('bank_account_name',$reservation->bank_account_name) }}"></div>
            </div>
        </div>
        <div class="payment-section {{ old('payment_method',$reservation->payment_method)=='credit_card'?'active':'' }}" id="payment-credit_card">
            <div class="form-grid" style="margin-top:var(--space-md);">
                <div class="form-group col-4"><label class="form-label">Tipe Kartu</label>
                    <select name="card_type" class="form-control">
                        <option value="">— Pilih —</option>
                        @foreach(['Visa','Mastercard','JCB','Amex'] as $ct)
                        <option value="{{ $ct }}" {{ old('card_type',$reservation->card_type)==$ct?'selected':'' }}>{{ $ct }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-4"><label class="form-label">Nomor Kartu</label><input type="text" name="card_number" class="form-control" value="{{ old('card_number',$reservation->card_number) }}" maxlength="19"></div>
                <div class="form-group col-4"><label class="form-label">Exp. Date (MM/YY)</label><input type="text" name="card_expiry_date" class="form-control" value="{{ old('card_expiry_date',$reservation->card_expiry_date) }}" placeholder="MM/YY" maxlength="5"></div>
                <div class="form-group col-6"><label class="form-label">Nama Pemegang Kartu</label><input type="text" name="card_holder_name" class="form-control" value="{{ old('card_holder_name',$reservation->card_holder_name) }}"></div>
            </div>
        </div>
    </div>
</div>

{{-- SAFETY DEPOSIT --}}
<div class="card mb-xl">
    <div class="card-header"><div class="card-header-left"><div class="card-header-icon"><i class="fas fa-lock"></i></div><div><div class="card-title">Safety Deposit Box & Catatan</div></div></div></div>
    <div class="card-body">
        <div class="form-grid">
            <div class="form-group col-4"><label class="form-label">Nomor Kotak Deposit</label><input type="text" name="safety_deposit_box_number" class="form-control" value="{{ old('safety_deposit_box_number',$reservation->safety_deposit_box_number) }}"></div>
            <div class="form-group col-4"><label class="form-label">Dikeluarkan Oleh</label><input type="text" name="issued_by" class="form-control" value="{{ old('issued_by',$reservation->issued_by) }}"></div>
            <div class="form-group col-4"><label class="form-label">Tanggal</label><input type="date" name="issued_date" class="form-control" value="{{ old('issued_date',$reservation->issued_date?->format('Y-m-d')) }}"></div>
            <div class="form-group col-12"><label class="form-label">Catatan Tambahan</label><textarea name="notes" class="form-control" rows="2" placeholder="Permintaan khusus, catatan penting, dll.">{{ old('notes',$reservation->notes) }}</textarea></div>
        </div>
    </div>
</div>

<div class="btn-group" style="justify-content:flex-end;">
    <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
    <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Perbarui Reservasi</button>
</div>
</form>
@endsection
@push('scripts')
<script>
const roomRates={'Standard':350000,'Superior':450000,'Deluxe':600000,'Junior Suite':850000,'Suite':1200000,'Executive':1500000};
const roomTypeSelect=document.getElementById('roomTypeSelect'),roomRateInput=document.getElementById('roomRateInput'),rateHint=document.getElementById('rateHint'),arrivalDate=document.getElementById('arrivalDate'),departureDate=document.getElementById('departureDate'),totalNightsEl=document.getElementById('totalNights'),totalEstimasiEl=document.getElementById('totalEstimasi');
function formatRp(n){return'Rp '+n.toLocaleString('id-ID');}
function calcNights(){const a=new Date(arrivalDate.value),d=new Date(departureDate.value);if(!isNaN(a)&&!isNaN(d)&&d>a)return Math.round((d-a)/86400000);return 0;}
function updateNightsDisplay(){const n=calcNights();totalNightsEl.value=n>0?n+' malam':'';updateTotal();}
function updateTotal(){const nights=calcNights(),rate=parseFloat(roomRateInput.value)||0;totalEstimasiEl.value=(nights>0&&rate>0)?formatRp(nights*rate):'';}
roomTypeSelect.addEventListener('change',function(){const rate=roomRates[this.value];if(rate){roomRateInput.value=rate;rateHint.textContent='Tarif standar: '+formatRp(rate)+' / malam';}else{roomRateInput.value='';rateHint.textContent='';}updateTotal();});
arrivalDate.addEventListener('change',updateNightsDisplay);departureDate.addEventListener('change',updateNightsDisplay);roomRateInput.addEventListener('input',updateTotal);
updateNightsDisplay();
function setPayment(method,btn){document.getElementById('paymentMethod').value=method;document.querySelectorAll('.payment-tab').forEach(t=>t.classList.remove('active'));btn.classList.add('active');document.querySelectorAll('.payment-section').forEach(s=>s.classList.remove('active'));document.getElementById('payment-'+method).classList.add('active');}
</script>
@endpush
