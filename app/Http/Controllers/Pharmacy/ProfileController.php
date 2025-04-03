<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pharmacy;

class ProfileController extends Controller
{
    /**
     * Affiche le formulaire de modification du profil de la pharmacie
     */
    public function edit()
    {
        $user = Auth::user();
        $pharmacy = $user->pharmacy;
        
        return view('pharmacy.profile.edit', compact('user', 'pharmacy'));
    }

    /**
     * Met à jour les informations du profil de la pharmacie
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $pharmacy = $user->pharmacy;
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'pharmacy_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'opening_hours' => 'nullable|string|max:255',
        ]);
        
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);
        
        $pharmacy->update([
            'name' => $validated['pharmacy_name'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'longitude' => $validated['longitude'],
            'latitude' => $validated['latitude'],
            'opening_hours' => $validated['opening_hours'],
        ]);
        
        return redirect()->route('pharmacy.profile.edit')
            ->with('success', 'Profil mis à jour avec succès.');
    }
} 