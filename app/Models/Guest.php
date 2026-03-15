<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model {
    use HasFactory;
    protected $fillable = [
        'name','profession','company','nationality',
        'id_passport_number','birth_date','address',
        'mobile_phone','email','member_number',
    ];
    protected $casts = ['birth_date' => 'date'];
    public function reservations() { return $this->hasMany(Reservation::class); }
}
