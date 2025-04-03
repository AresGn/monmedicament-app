<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'generic_name',
        'manufacturer',
        'description',
        'category',
        'requires_prescription',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'requires_prescription' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the pharmacies that stock this medicine.
     */
    public function pharmacies()
    {
        return $this->belongsToMany(Pharmacy::class, 'pharmacy_inventory')
            ->withPivot(['quantity_available', 'price', 'expiry_date', 'in_stock', 'last_updated']);
    }

    /**
     * Get the inventory entries for this medicine.
     */
    public function inventory()
    {
        return $this->hasMany(PharmacyInventory::class);
    }

    /**
     * Get reservation items for this medicine.
     */
    public function reservationItems()
    {
        return $this->hasMany(ReservationItem::class);
    }
} 