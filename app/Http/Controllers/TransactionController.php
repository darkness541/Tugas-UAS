<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['item', 'user', 'supplier'])->latest('transaction_date');
        
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }
        
        return view('transaction.index', [
            'title' => 'Riwayat Transaksi',
            'transactions' => $query->get(),
            'selected_type' => $request->type ?? ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transaction.create', [
            'title' => 'Catat Transaksi Baru',
            'items' => Item::all(),
            'suppliers' => Supplier::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:in,out',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'supplier_id' => 'nullable|required_if:type,in|exists:suppliers,id',
        ]);

        $item = Item::findOrFail($validated['item_id']);

        if ($validated['type'] === 'out' && $item->current_stock < $validated['quantity']) {
            return back()->withInput()->withErrors(['quantity' => 'Stok tidak mencukupi untuk transaksi keluar. Stok saat ini: ' . $item->current_stock]);
        }

        try {
            DB::transaction(function () use ($validated, $item) {
                // 1. Create Transaction
                Transaction::create([
                    'item_id' => $validated['item_id'],
                    'user_id' => Auth::id(),
                    'supplier_id' => $validated['type'] === 'in' ? $validated['supplier_id'] : null,
                    'type' => $validated['type'],
                    'quantity' => $validated['quantity'],
                    'reference_number' => $validated['reference_number'],
                    'transaction_date' => $validated['transaction_date'],
                    'notes' => $validated['notes'],
                ]);

                // 2. Update Item Stock
                if ($validated['type'] === 'in') {
                    $item->increment('current_stock', $validated['quantity']);
                } else {
                    $item->decrement('current_stock', $validated['quantity']);
                }
            });

            return redirect()->route('transaction.index')->with('success', 'Transaksi berhasil dicatat!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return view('transaction.show', [
            'transaction' => $transaction->load(['item', 'user', 'supplier']),
        ]);
    }
}
