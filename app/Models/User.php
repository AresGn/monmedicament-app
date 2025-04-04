<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password_hash',
        'phone_number',
        'user_type',
        'full_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password_hash',
        // 'remember_token', // Temporairement commenté pour éviter l'erreur
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'user_type' => 'string',
    ];

    /**
     * Get the password for the user.
     * Cet accesseur permet à Laravel de trouver le mot de passe dans password_hash
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
    
    /**
     * Set the user's password.
     * Permet à Auth::attempt() de fonctionner avec notre structure
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password_hash'] = Hash::make($value);
    }

    /**
     * Get the pharmacy associated with the user.
     */
    public function pharmacy()
    {
        return $this->hasOne(Pharmacy::class);
    }

    /**
     * Get the reservations for the user.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Check if user is a patient
     */
    public function isPatient()
    {
        return $this->user_type === 'PATIENT';
    }

    /**
     * Check if user is a pharmacy
     */
    public function isPharmacy()
    {
        return $this->user_type === 'PHARMACY';
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin()
    {
        return $this->user_type === 'ADMIN';
    }
}
