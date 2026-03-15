<?php
namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller {

    public function index() {
        $reservations = Reservation::with('guest')->orderBy('created_at','desc')->paginate(10);
        return view('reservations.index', compact('reservations'));
    }

    public function create() {
        return view('reservations.create');
    }

    public function store(Request $request) {
        $v = $request->validate([
            'name'                     => 'required|string|max:255',
            'profession'               => 'nullable|string|max:255',
            'company'                  => 'nullable|string|max:255',
            'nationality'              => 'required|string|max:100',
            'id_passport_number'       => 'nullable|string|max:100',
            'birth_date'               => 'nullable|date',
            'address'                  => 'nullable|string',
            'mobile_phone'             => 'nullable|string|max:50',
            'email'                    => 'nullable|email|max:255',
            'member_number'            => 'nullable|string|max:100',
            'room_number'              => 'nullable|string|max:20',
            'number_of_persons'        => 'required|integer|min:1',
            'number_of_rooms'          => 'required|integer|min:1',
            'room_type'                => 'required|string|max:100',
            'room_rate_net'            => 'nullable|numeric|min:0',
            'arrival_time'             => 'required|date_format:H:i',
            'arrival_date'             => 'required|date',
            'departure_date'           => 'required|date|after:arrival_date',
            'receptionist'             => 'nullable|string|max:255',
            'company_agent'            => 'nullable|string|max:255',
            'agent_telp'               => 'nullable|string|max:50',
            'agent_fax'                => 'nullable|string|max:50',
            'agent_email'              => 'nullable|email|max:255',
            'book_by'                  => 'nullable|string|max:255',
            'payment_method'           => 'required|in:cash,bank_transfer,credit_card',
            'bank_name'                => 'nullable|string|max:100',
            'bank_account_number'      => 'nullable|string|max:100',
            'bank_account_name'        => 'nullable|string|max:255',
            'card_number'              => 'nullable|string|max:20',
            'card_holder_name'         => 'nullable|string|max:255',
            'card_type'                => 'nullable|string|max:50',
            'card_expiry_date'         => 'nullable|string|max:10',
            'safety_deposit_box_number'=> 'nullable|string|max:50',
            'issued_by'                => 'nullable|string|max:255',
            'issued_date'              => 'nullable|date',
            'notes'                    => 'nullable|string',
        ]);

        $guest = Guest::create([
            'name'               => $v['name'],
            'profession'         => $v['profession'] ?? null,
            'company'            => $v['company'] ?? null,
            'nationality'        => $v['nationality'],
            'id_passport_number' => $v['id_passport_number'] ?? null,
            'birth_date'         => $v['birth_date'] ?? null,
            'address'            => $v['address'] ?? null,
            'mobile_phone'       => $v['mobile_phone'] ?? null,
            'email'              => $v['email'] ?? null,
            'member_number'      => $v['member_number'] ?? null,
        ]);

        $reservation = Reservation::create([
            'guest_id'                  => $guest->id,
            'room_number'               => $v['room_number'] ?? null,
            'number_of_persons'         => $v['number_of_persons'],
            'number_of_rooms'           => $v['number_of_rooms'],
            'room_type'                 => $v['room_type'],
            'arrival_time'              => $v['arrival_time'],
            'arrival_date'              => $v['arrival_date'],
            'departure_date'            => $v['departure_date'],
            'room_rate_net'             => $v['room_rate_net'] ?? null,
            'receptionist'              => $v['receptionist'] ?? null,
            'status'                    => 'confirmed',
            'company_agent'             => $v['company_agent'] ?? null,
            'agent_telp'                => $v['agent_telp'] ?? null,
            'agent_fax'                 => $v['agent_fax'] ?? null,
            'agent_email'               => $v['agent_email'] ?? null,
            'book_by'                   => $v['book_by'] ?? null,
            'payment_method'            => $v['payment_method'],
            'bank_name'                 => $v['bank_name'] ?? null,
            'bank_account_number'       => $v['bank_account_number'] ?? null,
            'bank_account_name'         => $v['bank_account_name'] ?? null,
            'card_number'               => $v['card_number'] ?? null,
            'card_holder_name'          => $v['card_holder_name'] ?? null,
            'card_type'                 => $v['card_type'] ?? null,
            'card_expiry_date'          => $v['card_expiry_date'] ?? null,
            'safety_deposit_box_number' => $v['safety_deposit_box_number'] ?? null,
            'issued_by'                 => $v['issued_by'] ?? null,
            'issued_date'               => $v['issued_date'] ?? null,
            'notes'                     => $v['notes'] ?? null,
        ]);

        return redirect()->route('reservations.show', $reservation->id)
            ->with('success', 'Reservasi berhasil disimpan! No. Booking: ' . $reservation->booking_number);
    }

    public function show(Reservation $reservation) {
        $reservation->load('guest');
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation) {
        $reservation->load('guest');
        return view('reservations.edit', compact('reservation'));
    }

    public function update(Request $request, Reservation $reservation) {
        $v = $request->validate([
            'name'                     => 'required|string|max:255',
            'profession'               => 'nullable|string|max:255',
            'company'                  => 'nullable|string|max:255',
            'nationality'              => 'required|string|max:100',
            'id_passport_number'       => 'nullable|string|max:100',
            'birth_date'               => 'nullable|date',
            'address'                  => 'nullable|string',
            'mobile_phone'             => 'nullable|string|max:50',
            'email'                    => 'nullable|email|max:255',
            'member_number'            => 'nullable|string|max:100',
            'room_number'              => 'nullable|string|max:20',
            'number_of_persons'        => 'required|integer|min:1',
            'number_of_rooms'          => 'required|integer|min:1',
            'room_type'                => 'required|string|max:100',
            'room_rate_net'            => 'nullable|numeric|min:0',
            'arrival_time'             => 'required|date_format:H:i',
            'arrival_date'             => 'required|date',
            'departure_date'           => 'required|date|after:arrival_date',
            'receptionist'             => 'nullable|string|max:255',
            'company_agent'            => 'nullable|string|max:255',
            'agent_telp'               => 'nullable|string|max:50',
            'agent_fax'                => 'nullable|string|max:50',
            'agent_email'              => 'nullable|email|max:255',
            'book_by'                  => 'nullable|string|max:255',
            'payment_method'           => 'required|in:cash,bank_transfer,credit_card',
            'bank_name'                => 'nullable|string|max:100',
            'bank_account_number'      => 'nullable|string|max:100',
            'bank_account_name'        => 'nullable|string|max:255',
            'card_number'              => 'nullable|string|max:20',
            'card_holder_name'         => 'nullable|string|max:255',
            'card_type'                => 'nullable|string|max:50',
            'card_expiry_date'         => 'nullable|string|max:10',
            'safety_deposit_box_number'=> 'nullable|string|max:50',
            'issued_by'                => 'nullable|string|max:255',
            'issued_date'              => 'nullable|date',
            'status'                   => 'nullable|in:pending,confirmed,checked_in,checked_out,cancelled',
            'notes'                    => 'nullable|string',
        ]);

        $reservation->guest->update([
            'name'               => $v['name'],
            'profession'         => $v['profession'] ?? null,
            'company'            => $v['company'] ?? null,
            'nationality'        => $v['nationality'],
            'id_passport_number' => $v['id_passport_number'] ?? null,
            'birth_date'         => $v['birth_date'] ?? null,
            'address'            => $v['address'] ?? null,
            'mobile_phone'       => $v['mobile_phone'] ?? null,
            'email'              => $v['email'] ?? null,
            'member_number'      => $v['member_number'] ?? null,
        ]);

        $reservation->update([
            'room_number'               => $v['room_number'] ?? null,
            'number_of_persons'         => $v['number_of_persons'],
            'number_of_rooms'           => $v['number_of_rooms'],
            'room_type'                 => $v['room_type'],
            'arrival_time'              => $v['arrival_time'],
            'arrival_date'              => $v['arrival_date'],
            'departure_date'            => $v['departure_date'],
            'room_rate_net'             => $v['room_rate_net'] ?? null,
            'receptionist'              => $v['receptionist'] ?? null,
            'status'                    => $v['status'] ?? $reservation->status,
            'company_agent'             => $v['company_agent'] ?? null,
            'agent_telp'                => $v['agent_telp'] ?? null,
            'agent_fax'                 => $v['agent_fax'] ?? null,
            'agent_email'               => $v['agent_email'] ?? null,
            'book_by'                   => $v['book_by'] ?? null,
            'payment_method'            => $v['payment_method'],
            'bank_name'                 => $v['bank_name'] ?? null,
            'bank_account_number'       => $v['bank_account_number'] ?? null,
            'bank_account_name'         => $v['bank_account_name'] ?? null,
            'card_number'               => $v['card_number'] ?? null,
            'card_holder_name'          => $v['card_holder_name'] ?? null,
            'card_type'                 => $v['card_type'] ?? null,
            'card_expiry_date'          => $v['card_expiry_date'] ?? null,
            'safety_deposit_box_number' => $v['safety_deposit_box_number'] ?? null,
            'issued_by'                 => $v['issued_by'] ?? null,
            'issued_date'               => $v['issued_date'] ?? null,
            'notes'                     => $v['notes'] ?? null,
        ]);

        return redirect()->route('reservations.show', $reservation->id)
            ->with('success', 'Reservasi berhasil diperbarui!');
    }

    public function print(Reservation $reservation) {
        $reservation->load('guest');
        return view('reservations.print', compact('reservation'));
    }

    public function updateStatus(Request $request, Reservation $reservation) {
        $request->validate(['status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled']);
        $reservation->update(['status' => $request->status]);
        return back()->with('success', 'Status berhasil diperbarui.');
    }
}
