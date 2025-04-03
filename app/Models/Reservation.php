<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'pharmacy_id',
        'reservation_date',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'reservation_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the reservation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the pharmacy for the reservation.
     */
    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    /**
     * Get the items for the reservation.
     */
    public function items()
    {
        return $this->hasMany(ReservationItem::class);
    }

    /**
     * Get the medicines in this reservation through the items.
     */
    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'reservation_items')
            ->withPivot(['quantity', 'unit_price']);
    }
} 