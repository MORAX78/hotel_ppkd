@extends('layouts.app')
@section('title', 'Reservasi Baru')
@section('hero')
<div class="page-hero-eyebrow">Formulir Reservasi</div>
<h1 class="page-hero-title">Reservasi Baru</h1>
<p class="page-hero-subtitle">Isi data tamu dan informasi kamar dengan lengkap</p>
@endsection
@section('content')
<form action="{{ route('reservations.store') }}" method="POST" id="reservationForm">
@csrf
@if($errors->any())
<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>
    <div><strong>Harap perbaiki:</strong><ul style="margin-top:4px;padding-left:16px;">
    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul></div>
</div>
@endif

{{-- SECTION 1: KAMAR --}}
<div class="card mb-xl">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-header-icon"><i class="fas fa-door-closed"></i></div>
            <div><div class="card-title">Informasi Kamar</div><div class="card-subtitle">Detail kamar dan jadwal menginap</div></div>
        </div>
    </div>
    <div class="card-body">
        <div class="form-grid">
            <div class="form-group col-3">
                <label class="form-label">No. Kamar</label>
                <input type="text" name="room_number" class="form-control" value="{{ old('room_number') }}" placeholder="mis. 0601">
            </div>
            <div class="form-group col-3">
                <label class="form-label">Jumlah Tamu <span class="required">*</span></label>
                <input type="number" name="number_of_persons" class="form-control @error('number_of_persons') is-invalid @enderror" value="{{ old('number_of_persons') }}" min="1" placeholder="—" required>
                @error('number_of_persons')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group col-3">
                <label class="form-label">Jumlah Kamar <span class="required">*</span></label>
                <input type="number" name="number_of_rooms" class="form-control @error('number_of_rooms') is-invalid @enderror" value="{{ old('number_of_rooms') }}" min="1" placeholder="—" required>
                @error('number_of_rooms')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group col-3">
                <label class="form-label">Resepsionis</label>
                <input type="text" name="receptionist" class="form-control" value="{{ old('receptionist', Auth::user()->name) }}" placeholder="Nama petugas">
            </div>
            <div class="form-group col-4">
                <label class="form-label">Jenis Kamar <span class="required">*</span></label>
                <select name="room_type" id="roomTypeSelect" class="form-control @error('room_type') is-invalid @enderror" required>
                    <option value="">— Pilih Tipe —</option>
                    <option value="Standard"     data-rate="350000"  {{ old('room_type')=='Standard'     ?'selected':'' }}>Standard</option>
                    <option value="Superior"     data-rate="450000"  {{ old('room_type')=='Superior'     ?'selected':'' }}>Superior</option>
                    <option value="Deluxe"       data-rate="600000"  {{ old('room_type')=='Deluxe'       ?'selected':'' }}>Deluxe</option>
                    <option value="Junior Suite" data-rate="850000"  {{ old('room_type')=='Junior Suite' ?'selected':'' }}>Junior Suite</option>
                    <option value="Suite"        data-rate="1200000" {{ old('room_type')=='Suite'        ?'selected':'' }}>Suite</option>
                    <option value="Executive"    data-rate="1500000" {{ old('room_type')=='Executive'    ?'selected':'' }}>Executive</option>
                </select>
                @error('room_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group col-4">
                <label class="form-label">Tarif / Malam (Rp)</label>
                <input type="number" name="room_rate_net" id="roomRateInput" class="form-control" value="{{ old('room_rate_net') }}" placeholder="Otomatis dari tipe kamar" step="1000">
                <span class="form-hint" id="rateHint"></span>
            </div>
            <div class="form-group col-4">
                <label class="form-label">Total Estimasi</label>
                <input type="text" id="totalEstimasi" class="form-control" readonly placeholder="Pilih kamar & tanggal">
            </div>
        </div>
        <div class="divider"></div>
        <div class="form-grid">
            <div class="form-group col-3">
                <label class="form-label">Waktu Kedatangan <span class="required">*</span></label>
                <input type="time" name="arrival_time" class="form-control @error('arrival_time') is-invalid @enderror" value="{{ old('arrival_time', '14:00') }}" required>
                @error('arrival_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group col-3">
                <label class="form-label">Tanggal Kedatangan <span class="required">*</span></label>
                <input type="date" name="arrival_date" id="arrivalDate" class="form-control @error('arrival_date') is-invalid @enderror" value="{{ old('arrival_date') }}" required>
                @error('arrival_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group col-3">
                <label class="form-label">Tanggal Keberangkatan <span class="required">*</span></label>
                <input type="date" name="departure_date" id="departureDate" class="form-control @error('departure_date') is-invalid @enderror" value="{{ old('departure_date') }}" required>
                @error('departure_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group col-3">
                <label class="form-label">Jumlah Malam</label>
                <input type="text" id="totalNights" class="form-control" readonly placeholder="Otomatis">
            </div>
        </div>
    </div>
</div>

{{-- SECTION 2: DATA TAMU --}}
<div class="card mb-xl">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-header-icon"><i class="fas fa-user"></i></div>
            <div><div class="card-title">Data Tamu</div><div class="card-subtitle">Harap tulis dengan huruf cetak — Please print in block letters</div></div>
        </div>
    </div>
    <div class="card-body">
        <div class="form-grid">
            <div class="form-group col-6">
                <label class="form-label">Nama / Name <span class="required">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Nama lengkap tamu" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group col-6">
                <label class="form-label">Pekerjaan / Profession</label>
                <input type="text" name="profession" class="form-control" value="{{ old('profession') }}" placeholder="Jabatan / pekerjaan">
            </div>
            <div class="form-group col-6">
                <label class="form-label">Perusahaan / Company</label>
                <input type="text" name="company" class="form-control" value="{{ old('company') }}" placeholder="Nama perusahaan">
            </div>
            <div class="form-group col-3">
                <label class="form-label">Kebangsaan / Nationality <span class="required">*</span></label>
                <input type="text" name="nationality" class="form-control @error('nationality') is-invalid @enderror" value="{{ old('nationality') }}" placeholder="mis. Indonesia" required>
                @error('nationality')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group col-3">
                <label class="form-label">No. KTP / Passport</label>
                <input type="text" name="id_passport_number" class="form-control" value="{{ old('id_passport_number') }}" placeholder="Nomor identitas">
            </div>
            <div class="form-group col-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}">
            </div>
            <div class="form-group col-9">
                <label class="form-label">Alamat / Address</label>
                <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="Alamat lengkap tamu">
            </div>
            <div class="form-group col-4">
                <label class="form-label">Handphone / Mobile</label>
                <input type="tel" name="mobile_phone" class="form-control" value="{{ old('mobile_phone') }}" placeholder="08xxxxxxxxxx">
            </div>
            <div class="form-group col-4">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="email@example.com">
            </div>
            <div class="form-group col-4">
                <label class="form-label">No. Member</label>
                <input type="text" name="member_number" class="form-control" value="{{ old('member_number') }}" placeholder="—">
            </div>
        </div>
    </div>
</div>

{{-- SECTION 3: DATA AGENT / PERUSAHAAN --}}
<div class="card mb-xl">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-header-icon"><i class="fas fa-building"></i></div>
            <div><div class="card-title">Data Agent / Perusahaan</div><div class="card-subtitle">Informasi agen atau perusahaan pemesan</div></div>
        </div>
    </div>
    <div class="card-body">
        <div class="form-grid">
            <div class="form-group col-6">
                <label class="form-label">Nama Agent / Perusahaan</label>
                <input type="text" name="company_agent" class="form-control" value="{{ old('company_agent') }}" placeholder="Nama agen atau perusahaan">
            </div>
            <div class="form-group col-6">
                <label class="form-label">Telepon Agent</label>
                <input type="text" name="agent_telp" class="form-control" value="{{ old('agent_telp') }}" placeholder="Nomor telepon agent">
            </div>
            <div class="form-group col-6">
                <label class="form-label">Fax Agent</label>
                <input type="text" name="agent_fax" class="form-control" value="{{ old('agent_fax') }}" placeholder="Nomor fax agent">
            </div>
            <div class="form-group col-6">
                <label class="form-label">Email Agent</label>
                <input type="email" name="agent_email" class="form-control" value="{{ old('agent_email') }}" placeholder="email@agent.com">
            </div>
            <div class="form-group col-6">
                <label class="form-label">Dipesan Oleh / Book By</label>
                <input type="text" name="book_by" class="form-control" value="{{ old('book_by') }}" placeholder="Nama pemesan">
            </div>
        </div>
    </div>
</div>

{{-- SECTION 4: PEMBAYARAN --}}
<div class="card mb-xl">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-header-icon"><i class="fas fa-credit-card"></i></div>
            <div><div class="card-title">Metode Pembayaran</div></div>
        </div>
    </div>
    <div class="card-body">
        <label class="form-label" style="margin-bottom:8px;display:block;">Metode Pembayaran <span class="required">*</span></label>
        <div class="payment-tabs">
            <button type="button" class="payment-tab {{ old('payment_method','cash')=='cash'?'active':'' }}" onclick="setPayment('cash',this)"><i class="fas fa-money-bill-wave"></i> Tunai</button>
            <button type="button" class="payment-tab {{ old('payment_method')=='bank_transfer'?'active':'' }}" onclick="setPayment('bank_transfer',this)"><i class="fas fa-university"></i> Transfer Bank</button>
            <button type="button" class="payment-tab {{ old('payment_method')=='credit_card'?'active':'' }}" onclick="setPayment('credit_card',this)"><i class="fas fa-credit-card"></i> Kartu Kredit</button>
        </div>
        <input type="hidden" name="payment_method" id="paymentMethod" value="{{ old('payment_method','cash') }}">
        <div class="payment-section {{ old('payment_method','cash')=='cash'?'active':'' }}" id="payment-cash">
            <p style="color:var(--color-text-soft);font-size:0.82rem;padding:var(--space-md) 0;"><i class="fas fa-check-circle text-primary"></i> Pembayaran dilakukan secara tunai saat check-in.</p>
        </div>
        <div class="payment-section {{ old('payment_method')=='bank_transfer'?'active':'' }}" id="payment-bank_transfer">
            <div class="form-grid" style="margin-top:var(--space-md);">
                <div class="form-group col-4"><label class="form-label">Nama Bank</label><input type="text" name="bank_name" class="form-control" value="{{ old('bank_name','Mandiri') }}"></div>
                <div class="form-group col-4"><label class="form-label">No. Rekening</label><input type="text" name="bank_account_number" class="form-control" value="{{ old('bank_account_number') }}"></div>
                <div class="form-group col-4"><label class="form-label">Nama Rekening</label><input type="text" name="bank_account_name" class="form-control" value="{{ old('bank_account_name') }}"></div>
            </div>
        </div>
        <div class="payment-section {{ old('payment_method')=='credit_card'?'active':'' }}" id="payment-credit_card">
            <div class="form-grid" style="margin-top:var(--space-md);">
                <div class="form-group col-4">
                    <label class="form-label">Tipe Kartu</label>
                    <select name="card_type" class="form-control">
                        <option value="">— Pilih —</option>
                        <option value="Visa" {{ old('card_type')=='Visa'?'selected':'' }}>Visa</option>
                        <option value="Mastercard" {{ old('card_type')=='Mastercard'?'selected':'' }}>Mastercard</option>
                        <option value="JCB" {{ old('card_type')=='JCB'?'selected':'' }}>JCB</option>
                        <option value="Amex" {{ old('card_type')=='Amex'?'selected':'' }}>American Express</option>
                    </select>
                </div>
                <div class="form-group col-4"><label class="form-label">Nomor Kartu</label><input type="text" name="card_number" class="form-control" value="{{ old('card_number') }}" placeholder="XXXX XXXX XXXX XXXX" maxlength="19" oninput="formatCardNumber(this)"></div>
                <div class="form-group col-4"><label class="form-label">Exp. Date (MM/YY)</label><input type="text" name="card_expiry_date" class="form-control" value="{{ old('card_expiry_date') }}" placeholder="MM/YY" maxlength="5"></div>
                <div class="form-group col-6"><label class="form-label">Nama Pemegang Kartu</label><input type="text" name="card_holder_name" class="form-control" value="{{ old('card_holder_name') }}" placeholder="Sesuai nama di kartu"></div>
            </div>
        </div>
    </div>
</div>

{{-- SECTION 5: SAFETY DEPOSIT --}}
<div class="card mb-xl">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-header-icon"><i class="fas fa-lock"></i></div>
            <div><div class="card-title">Safety Deposit Box & Catatan</div></div>
        </div>
    </div>
    <div class="card-body">
        <div class="form-grid">
            <div class="form-group col-4"><label class="form-label">Nomor Kotak Deposit</label><input type="text" name="safety_deposit_box_number" class="form-control" value="{{ old('safety_deposit_box_number') }}" placeholder="No. kotak"></div>
            <div class="form-group col-4"><label class="form-label">Dikeluarkan Oleh</label><input type="text" name="issued_by" class="form-control" value="{{ old('issued_by') }}" placeholder="Nama petugas"></div>
            <div class="form-group col-4"><label class="form-label">Tanggal</label><input type="date" name="issued_date" class="form-control" value="{{ old('issued_date') }}"></div>
            <div class="form-group col-12"><label class="form-label">Catatan Tambahan</label><textarea name="notes" class="form-control" rows="2" placeholder="Permintaan khusus, catatan penting, dll.">{{ old('notes') }}</textarea></div>
        </div>
    </div>
</div>

<div class="btn-group" style="justify-content:flex-end;">
    <a href="{{ route('reservations.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
    <button type="reset" class="btn btn-outline"><i class="fas fa-undo"></i> Reset</button>
    <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Simpan Reservasi</button>
</div>
</form>
@endsection
@push('scripts')
<script>
const roomRates = { 'Standard':350000,'Superior':450000,'Deluxe':600000,'Junior Suite':850000,'Suite':1200000,'Executive':1500000 };
const roomTypeSelect=document.getElementById('roomTypeSelect'),roomRateInput=document.getElementById('roomRateInput'),rateHint=document.getElementById('rateHint'),arrivalDate=document.getElementById('arrivalDate'),departureDate=document.getElementById('departureDate'),totalNightsEl=document.getElementById('totalNights'),totalEstimasiEl=document.getElementById('totalEstimasi');
function formatRp(n){return'Rp '+n.toLocaleString('id-ID');}
function calcNights(){const a=new Date(arrivalDate.value),d=new Date(departureDate.value);if(!isNaN(a)&&!isNaN(d)&&d>a)return Math.round((d-a)/86400000);return 0;}
function updateNightsDisplay(){const n=calcNights();totalNightsEl.value=n>0?n+' malam':'';updateTotal();}
function updateTotal(){const nights=calcNights(),rate=parseFloat(roomRateInput.value)||0;totalEstimasiEl.value=(nights>0&&rate>0)?formatRp(nights*rate):'';}
roomTypeSelect.addEventListener('change',function(){const rate=roomRates[this.value];if(rate){roomRateInput.value=rate;rateHint.textContent='Tarif standar: '+formatRp(rate)+' / malam';}else{roomRateInput.value='';rateHint.textContent='';}updateTotal();});
if(roomTypeSelect.value&&roomRates[roomTypeSelect.value]){if(!roomRateInput.value)roomRateInput.value=roomRates[roomTypeSelect.value];rateHint.textContent='Tarif standar: '+formatRp(roomRates[roomTypeSelect.value])+' / malam';}
arrivalDate.addEventListener('change',updateNightsDisplay);
departureDate.addEventListener('change',updateNightsDisplay);
roomRateInput.addEventListener('input',updateTotal);
updateNightsDisplay();
function setPayment(method,btn){document.getElementById('paymentMethod').value=method;document.querySelectorAll('.payment-tab').forEach(t=>t.classList.remove('active'));btn.classList.add('active');document.querySelectorAll('.payment-section').forEach(s=>s.classList.remove('active'));document.getElementById('payment-'+method).classList.add('active');}
function formatCardNumber(input){let v=input.value.replace(/\D/g,'').substring(0,16);input.value=v.replace(/(.{4})/g,'$1 ').trim();}
</script>
@endpush
