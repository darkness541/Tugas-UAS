<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Tampilkan halaman filter laporan
     */
    public function index(Request $request)
    {
        // Set default date range to current month if not provided
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfMonth();
        
        $query = Transaction::with(['item', 'user', 'supplier'])
                            ->whereBetween('transaction_date', [$startDate, $endDate]);

        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        $transactions = $query->orderBy('transaction_date', 'asc')->get();

        // Calculate summary
        $totalIn = $transactions->where('type', 'in')->sum('quantity');
        $totalOut = $transactions->where('type', 'out')->sum('quantity');

        return view('report.index', [
            'title' => 'Laporan Pergerakan Stok',
            'transactions' => $transactions,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'selectedType' => $request->type ?? '',
            'totalIn' => $totalIn,
            'totalOut' => $totalOut,
        ]);
    }

    /**
     * Tampilkan halaman khusus cetak (Print to PDF)
     */
    public function print(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfMonth();
        
        $query = Transaction::with(['item', 'user', 'supplier'])
                            ->whereBetween('transaction_date', [$startDate, $endDate]);

        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        $transactions = $query->orderBy('transaction_date', 'asc')->get();

        $totalIn = $transactions->where('type', 'in')->sum('quantity');
        $totalOut = $transactions->where('type', 'out')->sum('quantity');

        return view('report.print', [
            'transactions' => $transactions,
            'startDate' => $startDate->format('d/m/Y'),
            'endDate' => $endDate->format('d/m/Y'),
            'selectedType' => $request->type ?? '',
            'totalIn' => $totalIn,
            'totalOut' => $totalOut,
            'printedAt' => Carbon::now()->format('d/m/Y H:i'),
            'printedBy' => auth()->user()->name,
        ]);
    }
}
