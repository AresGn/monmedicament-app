<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\PharmacyInventory;
use App\Models\Reservation;
use App\Models\ReservationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display the user's reservations
     */
    public function index()
    {
        $reservations = Auth::user()->reservations()->with(['pharmacy', 'items.medicine'])->get();
        
        return view('patient.reservation.index', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * Show the form for creating a new reservation
     */
    public function create(Request $request)
    {
        $pharmacyId = $request->query('pharmacy_id');
        $medicineId = $request->query('medicine_id');
        
        if (!$pharmacyId) {
            return redirect()->route('patient.search.index')
                ->with('error', 'Pharmacy ID is required to create a reservation.');
        }
        
        $pharmacy = Pharmacy::findOrFail($pharmacyId);
        
        $medicines = [];
        if ($medicineId) {
            $medicine = Medicine::findOrFail($medicineId);
            $inventory = $pharmacy->inventory()
                ->where('medicine_id', $medicineId)
                ->where('in_stock', true)
                ->first();
                
            if ($inventory) {
                $medicines[] = [
                    'id' => $medicine->id,
                    'name' => $medicine->name,
                    'price' => $inventory->price,
                    'max_quantity' => $inventory->quantity_available,
                ];
            }
        } else {
            $inventory = $pharmacy->inventory()
                ->with('medicine')
                ->where('in_stock', true)
                ->where('quantity_available', '>', 0)
                ->get();
                
            foreach ($inventory as $item) {
                $medicines[] = [
                    'id' => $item->medicine->id,
                    'name' => $item->medicine->name,
                    'price' => $item->price,
                    'max_quantity' => $item->quantity_available,
                ];
            }
        }
        
        return view('patient.reservation.create', [
            'pharmacy' => $pharmacy,
            'medicines' => $medicines,
        ]);
    }

    /**
     * Store a newly created reservation
     */
    public function store(Request $request)
    {
        $request->validate([
            'pharmacy_id' => 'required|exists:pharmacies,id',
            'reservation_date' => 'required|date|after:now',
            'medicines' => 'required|array|min:1',
            'medicines.*.id' => 'required|exists:medicines,id',
            'medicines.*.quantity' => 'required|integer|min:1',
        ]);
        
        // Create the reservation
        $reservation = new Reservation([
            'user_id' => Auth::id(),
            'pharmacy_id' => $request->input('pharmacy_id'),
            'reservation_date' => $request->input('reservation_date'),
            'status' => 'PENDING',
        ]);
        
        $reservation->save();
        
        // Add medicines to the reservation
        $medicines = $request->input('medicines');
        foreach ($medicines as $medicine) {
            $inventory = PharmacyInventory::where('pharmacy_id', $request->input('pharmacy_id'))
                ->where('medicine_id', $medicine['id'])
                ->first();
                
            if (!$inventory || $inventory->quantity_available < $medicine['quantity']) {
                $reservation->delete();
                return redirect()->back()->with('error', 'Some medicines are no longer available in the requested quantity.');
            }
            
            $reservationItem = new ReservationItem([
                'reservation_id' => $reservation->id,
                'medicine_id' => $medicine['id'],
                'quantity' => $medicine['quantity'],
                'unit_price' => $inventory->price,
            ]);
            
            $reservationItem->save();
        }
        
        return redirect()->route('patient.reservations.show', $reservation->id)
            ->with('success', 'Reservation created successfully.');
    }

    /**
     * Display the specified reservation
     */
    public function show($id)
    {
        $reservation = Reservation::with(['pharmacy', 'items.medicine'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);
            
        return view('patient.reservation.show', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * Cancel the specified reservation
     */
    public function cancel($id)
    {
        $reservation = Reservation::where('user_id', Auth::id())->findOrFail($id);
        
        if ($reservation->status === 'PENDING' || $reservation->status === 'CONFIRMED') {
            $reservation->status = 'CANCELLED';
            $reservation->save();
            
            return redirect()->route('patient.reservations.index')
                ->with('success', 'Reservation cancelled successfully.');
        }
        
        return redirect()->route('patient.reservations.index')
            ->with('error', 'Cannot cancel this reservation.');
    }

    /**
     * Display the verification page before finalizing the reservation
     */
    public function verify(Request $request)
    {
        return view('patient.reservation.verify');
    }

    /**
     * Display the confirmation page after reservation is submitted
     */
    public function confirm(Request $request)
    {
        return view('patient.reservation.confirm');
    }
} 