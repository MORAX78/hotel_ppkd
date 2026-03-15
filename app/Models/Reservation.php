<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model {
    use HasFactory;

    protected $fillable = [
        'guest_id','booking_number',
        'room_number','number_of_rooms','number_of_persons',
        'room_type','receptionist',
        'arrival_time','arrival_date','departure_date','total_nights',
        'room_rate_net',
        'company_agent','agent_telp','agent_fax','agent_email','book_by',
        'payment_method',
        'bank_name','bank_account_number','bank_account_name',
        'card_number','card_holder_name','card_type','card_expiry_date',
        'safety_deposit_box_number','issued_by','issued_date',
        'status','notes',
    ];

    protected $casts = [
        'arrival_date'    => 'date',
        'departure_date'  => 'date',
        'issued_date'     => 'date',
    ];

    protected static function boot() {
        parent::boot();
        static::creating(function ($r) {
            if (empty($r->booking_number)) {
                $prefix = 'PPKD';
                $year   = date('Y'); $month = date('m');
                $last   = self::whereYear('created_at', $year)->whereMonth('created_at', $month)->latest()->first();
                $num    = $last ? str_pad((int)substr($last->booking_number, -4) + 1, 4, '0', STR_PAD_LEFT) : '0001';
                $r->booking_number = "{$prefix}/{$year}{$month}/{$num}";
            }
            if ($r->arrival_date && $r->departure_date) {
                $r->total_nights = Carbon::parse($r->arrival_date)->diffInDays(Carbon::parse($r->departure_date));
            }
        });
        static::saving(function ($r) {
            if ($r->isDirty(['arrival_date','departure_date']) && $r->arrival_date && $r->departure_date) {
                $r->total_nights = Carbon::parse($r->arrival_date)->diffInDays(Carbon::parse($r->departure_date));
            }
        });
    }

    public function guest() { return $this->belongsTo(Guest::class); }

    public function getTotalNightsAttribute() {
        if ($this->arrival_date && $this->departure_date) {
            return $this->arrival_date->diffInDays($this->departure_date);
        }
        return (int)($this->attributes['total_nights'] ?? 0);
    }

    public function getStatusBadgeAttribute() {
        return match($this->status) {
            'pending'     => ['label' => 'Pending',      'class' => 'badge-warning'],
            'confirmed'   => ['label' => 'Confirmed',    'class' => 'badge-info'],
            'checked_in'  => ['label' => 'Checked In',   'class' => 'badge-success'],
            'checked_out' => ['label' => 'Checked Out',  'class' => 'badge-secondary'],
            'cancelled'   => ['label' => 'Cancelled',    'class' => 'badge-danger'],
            default       => ['label' => 'Unknown',      'class' => 'badge-secondary'],
        };
    }
}
