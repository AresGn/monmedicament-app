<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyInventory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pharmacy_inventory';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pharmacy_id',
        'medicine_id',
        'quantity_available',
        'price',
        'expiry_date',
        'in_stock',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity_available' => 'integer',
        'price' => 'float',
        'expiry_date' => 'date',
        'in_stock' => 'boolean',
        'last_updated' => 'datetime',
    ];

    /**
     * Get the pharmacy that owns the inventory item.
     */
    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    /**
     * Get the medicine related to this inventory item.
     */
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
} 