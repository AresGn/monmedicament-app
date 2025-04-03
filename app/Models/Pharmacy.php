<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'latitude',
        'longitude',
        'phone_number',
        'opening_hour',
        'closing_hour',
        'is_open_weekends',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'opening_hour' => 'datetime',
        'closing_hour' => 'datetime',
        'is_open_weekends' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the pharmacy.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the inventory items for the pharmacy.
     */
    public function inventory()
    {
        return $this->hasMany(PharmacyInventory::class);
    }

    /**
     * Get the reservations for the pharmacy.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get medicines available at this pharmacy through inventory.
     */
    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'pharmacy_inventory')
            ->withPivot(['quantity_available', 'price', 'expiry_date', 'in_stock', 'last_updated']);
    }
} 