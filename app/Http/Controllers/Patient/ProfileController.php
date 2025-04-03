<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Affiche le tableau de bord du patient
     */
    public function dashboard()
    {
        $user = Auth::user();
        $reservations = $user->reservations()->latest()->take(5)->get();
        
        return view('patient.dashboard', compact('user', 'reservations'));
    }

    /**
     * Affiche le formulaire de modification du profil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('patient.profile.edit', compact('user'));
    }

    /**
     * Met à jour les informations du profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('patient.profile.edit')
            ->with('success', 'Profil mis à jour avec succès.');
    }
} 