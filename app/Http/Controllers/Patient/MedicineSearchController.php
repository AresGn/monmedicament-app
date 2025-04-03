<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\PharmacyInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicineSearchController extends Controller
{
    /**
     * Display the search form
     */
    public function index()
    {
        return view('patient.search.index');
    }

    /**
     * Search for medicines
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2',
        ]);

        $query = $request->input('query');

        // Find pharmacies that have the medicine in stock
        $results = PharmacyInventory::join('medicines', 'pharmacy_inventory.medicine_id', '=', 'medicines.id')
            ->join('pharmacies', 'pharmacy_inventory.pharmacy_id', '=', 'pharmacies.id')
            ->where(function($q) use ($query) {
                $q->where('medicines.name', 'like', "%{$query}%")
                  ->orWhere('medicines.generic_name', 'like', "%{$query}%");
            })
            ->where('pharmacy_inventory.in_stock', true)
            ->where('pharmacy_inventory.quantity_available', '>', 0)
            ->select(
                'pharmacies.id as pharmacy_id',
                'pharmacies.name as pharmacy_name',
                'pharmacies.address',
                'pharmacies.latitude',
                'pharmacies.longitude',
                'pharmacies.phone_number',
                'medicines.id as medicine_id',
                'medicines.name as medicine_name',
                'pharmacy_inventory.quantity_available',
                'pharmacy_inventory.price'
            )
            ->orderBy('pharmacy_inventory.price')
            ->get();

        // Group results by pharmacy for better display
        $pharmacies = $results->groupBy('pharmacy_id')->map(function($items) {
            $pharmacy = $items->first();
            
            return [
                'id' => $pharmacy->pharmacy_id,
                'name' => $pharmacy->pharmacy_name,
                'address' => $pharmacy->address,
                'latitude' => $pharmacy->latitude,
                'longitude' => $pharmacy->longitude,
                'phone_number' => $pharmacy->phone_number,
                'medicines' => $items->map(function($item) {
                    return [
                        'id' => $item->medicine_id,
                        'name' => $item->medicine_name,
                        'quantity' => $item->quantity_available,
                        'price' => $item->price,
                    ];
                }),
            ];
        });

        return view('patient.search.results', [
            'pharmacies' => $pharmacies,
            'query' => $query,
        ]);
    }

    /**
     * Display pharmacy details
     */
    public function pharmacyDetails($id)
    {
        $pharmacy = Pharmacy::with(['inventory.medicine'])->findOrFail($id);
        
        return view('patient.search.pharmacy_details', [
            'pharmacy' => $pharmacy,
        ]);
    }

    /**
     * Display list of all pharmacies
     */
    public function pharmacyList()
    {
        $pharmacies = Pharmacy::orderBy('name')
            ->withCount('inventory')
            ->paginate(12);
        
        return view('patient.search.pharmacy_list', [
            'pharmacies' => $pharmacies,
        ]);
    }
} 