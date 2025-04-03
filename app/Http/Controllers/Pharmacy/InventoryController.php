<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\PharmacyInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * Display the pharmacy inventory
     */
    public function index(Request $request)
    {
        $pharmacy = Auth::user()->pharmacy;
        
        $query = $pharmacy->inventory()->with('medicine');
        
        // Apply filters if provided
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('medicine', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('generic_name', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('stock_status')) {
            $status = $request->input('stock_status');
            if ($status === 'in_stock') {
                $query->where('in_stock', true);
            } elseif ($status === 'out_of_stock') {
                $query->where('in_stock', false);
            } elseif ($status === 'low_stock') {
                $query->where('in_stock', true)->where('quantity_available', '<', 10);
            }
        }
        
        $inventory = $query->paginate(20);
        
        return view('pharmacy.inventory.index', [
            'inventory' => $inventory,
            'search' => $request->input('search', ''),
            'stock_status' => $request->input('stock_status', 'all'),
        ]);
    }

    /**
     * Show the form for adding a new medicine to inventory
     */
    public function create()
    {
        $medicines = Medicine::orderBy('name')->get();
        
        return view('pharmacy.inventory.create', [
            'medicines' => $medicines,
        ]);
    }

    /**
     * Store a newly created inventory item
     */
    public function store(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity_available' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date|after:today',
            'in_stock' => 'boolean',
        ]);
        
        $pharmacy = Auth::user()->pharmacy;
        
        // Check if medicine already exists in inventory
        $existingItem = $pharmacy->inventory()
            ->where('medicine_id', $request->input('medicine_id'))
            ->first();
            
        if ($existingItem) {
            return redirect()->back()
                ->with('error', 'This medicine is already in your inventory. Please edit the existing entry.');
        }
        
        // Create new inventory item
        $inventory = new PharmacyInventory([
            'pharmacy_id' => $pharmacy->id,
            'medicine_id' => $request->input('medicine_id'),
            'quantity_available' => $request->input('quantity_available'),
            'price' => $request->input('price'),
            'expiry_date' => $request->input('expiry_date'),
            'in_stock' => $request->input('in_stock', true),
        ]);
        
        $inventory->save();
        
        return redirect()->route('pharmacy.inventory.index')
            ->with('success', 'Medicine added to inventory successfully.');
    }

    /**
     * Show the form for editing an inventory item
     */
    public function edit($id)
    {
        $pharmacy = Auth::user()->pharmacy;
        $inventoryItem = $pharmacy->inventory()
            ->with('medicine')
            ->where('id', $id)
            ->firstOrFail();
        
        return view('pharmacy.inventory.edit', [
            'inventoryItem' => $inventoryItem,
        ]);
    }

    /**
     * Update the specified inventory item
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity_available' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date|after:today',
            'in_stock' => 'boolean',
        ]);
        
        $pharmacy = Auth::user()->pharmacy;
        $inventoryItem = $pharmacy->inventory()->findOrFail($id);
        
        $inventoryItem->fill([
            'quantity_available' => $request->input('quantity_available'),
            'price' => $request->input('price'),
            'expiry_date' => $request->input('expiry_date'),
            'in_stock' => $request->input('in_stock', false),
            'last_updated' => now(),
        ]);
        
        $inventoryItem->save();
        
        return redirect()->route('pharmacy.inventory.index')
            ->with('success', 'Inventory item updated successfully.');
    }

    /**
     * Remove the specified inventory item
     */
    public function destroy($id)
    {
        $pharmacy = Auth::user()->pharmacy;
        $inventoryItem = $pharmacy->inventory()->findOrFail($id);
        
        $inventoryItem->delete();
        
        return redirect()->route('pharmacy.inventory.index')
            ->with('success', 'Inventory item removed successfully.');
    }
} 