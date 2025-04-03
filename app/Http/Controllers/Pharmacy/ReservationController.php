<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the reservations
     */
    public function index(Request $request)
    {
        $pharmacy = Auth::user()->pharmacy;
        
        $query = $pharmacy->reservations()->with(['user', 'items.medicine']);
        
        // Apply filters if provided
        if ($request->has('status')) {
            $status = $request->input('status');
            if (in_array($status, ['PENDING', 'CONFIRMED', 'COMPLETED', 'CANCELLED'])) {
                $query->where('status', $status);
            }
        }
        
        if ($request->has('date_from')) {
            $query->where('reservation_date', '>=', $request->input('date_from'));
        }
        
        if ($request->has('date_to')) {
            $query->where('reservation_date', '<=', $request->input('date_to'));
        }
        
        $reservations = $query->orderBy('reservation_date', 'desc')->paginate(15);
        
        return view('pharmacy.reservation.index', [
            'reservations' => $reservations,
            'status' => $request->input('status', 'all'),
            'date_from' => $request->input('date_from', ''),
            'date_to' => $request->input('date_to', ''),
        ]);
    }

    /**
     * Display the specified reservation
     */
    public function show($id)
    {
        $pharmacy = Auth::user()->pharmacy;
        $reservation = $pharmacy->reservations()
            ->with(['user', 'items.medicine'])
            ->findOrFail($id);
            
        return view('pharmacy.reservation.show', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * Update the reservation status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:PENDING,CONFIRMED,COMPLETED,CANCELLED',
        ]);
        
        $pharmacy = Auth::user()->pharmacy;
        $reservation = $pharmacy->reservations()->findOrFail($id);
        
        // Check for valid status transitions
        $newStatus = $request->input('status');
        $currentStatus = $reservation->status;
        
        $validTransitions = [
            'PENDING' => ['CONFIRMED', 'CANCELLED'],
            'CONFIRMED' => ['COMPLETED', 'CANCELLED'],
            'COMPLETED' => [],
            'CANCELLED' => [],
        ];
        
        if (!in_array($newStatus, $validTransitions[$currentStatus])) {
            return redirect()->back()
                ->with('error', "Cannot change status from {$currentStatus} to {$newStatus}.");
        }
        
        $reservation->status = $newStatus;
        $reservation->save();
        
        return redirect()->route('pharmacy.reservations.show', $id)
            ->with('success', 'Reservation status updated successfully.');
    }

    /**
     * Export reservations (could implement CSV or PDF export)
     */
    public function export(Request $request)
    {
        // This would be implemented based on specific export requirements
        // e.g., generating a CSV or PDF report of reservations
        
        return redirect()->route('pharmacy.reservations.index')
            ->with('info', 'Export functionality will be implemented in a future update.');
    }
} 