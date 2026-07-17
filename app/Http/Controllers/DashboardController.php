<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // User stats
        $totalUsers = User::count();
        $superadminCount = User::whereHas('role', function ($query) {
            $query->where('name', 'Superadmin');
        })->count();
        $adminCount = User::whereHas('role', function ($query) {
            $query->where('name', 'Admin');
        })->count();

        // Inventory Analytics
        $totalItems = Item::count();
        
        // Calculate Total Valuation
        $totalValuation = Item::select(DB::raw('SUM(current_stock * price) as total'))->value('total') ?? 0;
        
        // Low Stock Items (taking up to 10 for dashboard preview)
        $lowStockItems = Item::whereColumn('current_stock', '<=', 'minimum_stock')
                            ->orderBy('current_stock', 'asc')
                            ->take(10)
                            ->get();

        // Transactions Chart Data (Last 30 Days)
        $startDate = Carbon::now()->subDays(29)->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        
        $transactions = Transaction::select(
                DB::raw('DATE(transaction_date) as date'),
                'type',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(quantity) as total_quantity')
            )
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->groupBy('date', 'type')
            ->orderBy('date', 'asc')
            ->get();
            
        // Formatting chart data for ApexCharts
        $dates = collect();
        for ($i = 0; $i < 30; $i++) {
            $dates->push(Carbon::now()->subDays(29 - $i)->format('Y-m-d'));
        }
        
        $chartDataIn = [];
        $chartDataOut = [];
        
        foreach ($dates as $date) {
            // Find IN transactions for this date
            $in = $transactions->where('date', $date)->where('type', 'in')->first();
            $chartDataIn[] = $in ? (int) $in->total_quantity : 0;
            
            // Find OUT transactions for this date
            $out = $transactions->where('date', $date)->where('type', 'out')->first();
            $chartDataOut[] = $out ? (int) $out->total_quantity : 0;
        }

        return view('dashboard.index', [
            'title' => 'Dashboard',
            'user' => $user,
            'totalUsers' => $totalUsers,
            'superadminCount' => $superadminCount,
            'adminCount' => $adminCount,
            
            'totalItems' => $totalItems,
            'totalValuation' => $totalValuation,
            'lowStockItems' => $lowStockItems,
            
            'chartDates' => $dates->map(fn($date) => Carbon::parse($date)->format('d/m'))->toArray(),
            'chartDataIn' => $chartDataIn,
            'chartDataOut' => $chartDataOut,
        ]);
    }

    public function show()
    {
        return view('dashboard.show', [
            'title' => 'My Profile',
            'user' => Auth::user()
        ]);
    }

    public function edit()
    {
        return view('dashboard.edit', [
            'title' => 'Edit Profile',
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $validate = $request->validate([
                'name' => 'required',
                'password' => 'nullable|min:8',
                'passwordconfirm' => 'nullable|same:password',
                'email' => 'required|email|lowercase|unique:users,email,' . $user->id,
                'avatar' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:512'
            ], [
                'name.required' => 'Nama wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'passwordconfirm.same' => 'Konfirmasi password tidak cocok',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'avatar.image' => 'File avatar harus berupa gambar',
                'avatar.mimes' => 'Format avatar harus png, jpg, jpeg, atau svg',
                'avatar.max' => 'Ukuran avatar tidak boleh lebih dari 512 KB',
            ]);

            if ($request->file('avatar')) {
                $validate['avatar'] = $request->file('avatar')->store('img', 'public');
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }

            if ($request->password) {
                $validate['password'] = bcrypt($request->password);
            } else {
                unset($validate['password']);
            }
            $user->update($validate);

            DB::commit();
            return to_route('dashboard.show')->withSuccess('Data berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('dashboard.edit')->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }
}
