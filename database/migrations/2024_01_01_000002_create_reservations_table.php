<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->constrained('guests')->onDelete('cascade');
            $table->string('booking_number')->unique();

            // Kamar
            $table->string('room_number')->nullable();
            $table->integer('number_of_rooms')->default(1);
            $table->integer('number_of_persons')->default(1);
            $table->string('room_type');
            $table->string('receptionist')->nullable();

            // Jadwal
            $table->time('arrival_time')->nullable();
            $table->date('arrival_date');
            $table->date('departure_date');
            $table->integer('total_nights')->default(0);

            // Tarif
            $table->decimal('room_rate_net', 12, 2)->nullable();

            // Agent / Perusahaan
            $table->string('company_agent')->nullable();
            $table->string('agent_telp')->nullable();
            $table->string('agent_fax')->nullable();
            $table->string('agent_email')->nullable();
            $table->string('book_by')->nullable();

            // Pembayaran
            $table->string('payment_method')->default('cash'); // cash, bank_transfer, credit_card
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('card_number')->nullable();
            $table->string('card_holder_name')->nullable();
            $table->string('card_type')->nullable();
            $table->string('card_expiry_date', 10)->nullable();

            // Safety deposit
            $table->string('safety_deposit_box_number')->nullable();
            $table->string('issued_by')->nullable();
            $table->date('issued_date')->nullable();

            // Status & catatan
            $table->enum('status', ['pending','confirmed','checked_in','checked_out','cancelled'])->default('confirmed');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('reservations'); }
};
