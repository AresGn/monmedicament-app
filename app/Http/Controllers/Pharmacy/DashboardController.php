<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the pharmacy dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $pharmacy = $user->pharmacy;
        
        // Fetch pharmacy statistics
        $totalInventoryItems = $pharmacy->inventory()->count();
        $outOfStockItems = $pharmacy->inventory()->where('in_stock', false)->count();
        $lowStockItems = $pharmacy->inventory()
            ->where('in_stock', true)
            ->where('quantity_available', '<', 10)
            ->count();
            
        // Fetch recent reservations
        $pendingReservations = $pharmacy->reservations()
            ->where('status', 'PENDING')
            ->with(['user', 'items.medicine'])
            ->orderBy('reservation_date')
            ->take(5)
            ->get();
            
        // Most popular medicines
        $popularMedicines = DB::table('reservation_items')
            ->join('reservations', 'reservation_items.reservation_id', '=', 'reservations.id')
            ->join('medicines', 'reservation_items.medicine_id', '=', 'medicines.id')
            ->where('reservations.pharmacy_id', $pharmacy->id)
            ->select('medicines.id', 'medicines.name', DB::raw('SUM(reservation_items.quantity) as total_reserved'))
            ->groupBy('medicines.id', 'medicines.name')
            ->orderByDesc('total_reserved')
            ->take(5)
            ->get();
            
        return view('pharmacy.dashboard.index', [
            'pharmacy' => $pharmacy,
            'totalInventoryItems' => $totalInventoryItems,
            'outOfStockItems' => $outOfStockItems,
            'lowStockItems' => $lowStockItems,
            'pendingReservations' => $pendingReservations,
            'popularMedicines' => $popularMedicines,
        ]);
    }

    /**
     * Show the form for editing pharmacy profile
     */
    public function editProfile()
    {
        $pharmacy = Auth::user()->pharmacy;
        
        return view('pharmacy.dashboard.edit_profile', [
            'pharmacy' => $pharmacy,
        ]);
    }

    /**
     * Update the pharmacy profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'opening_hour' => 'required',
            'closing_hour' => 'required',
            'is_open_weekends' => 'boolean',
            'description' => 'nullable|string',
        ]);
        
        $pharmacy = Auth::user()->pharmacy;
        $pharmacy->fill($request->only([
            'name',
            'address',
            'phone_number',
            'opening_hour',
            'closing_hour',
            'is_open_weekends',
            'description',
        ]));
        
        $pharmacy->save();
        
        return redirect()->route('pharmacy.dashboard.index')
            ->with('success', 'Pharmacy profile updated successfully.');
    }
} 