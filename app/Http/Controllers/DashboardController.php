<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialRequest;
use App\Models\MaterialReturn;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } else {
            return $this->teknisiDashboard();
        }
    }

    private function adminDashboard()
    {
        $totalMaterials = Material::count();
        $lowStockMaterials = Material::whereColumn('stok', '<=', 'minimum_stok')->count();
        $pendingRequests = MaterialRequest::where('status', 'pending')->count();
        $pendingReturns = MaterialReturn::where('status', 'pending')->count();

        $recentRequests = MaterialRequest::with(['user', 'material'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentReturns = MaterialReturn::with(['user', 'material'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMaterials', 'lowStockMaterials', 'pendingRequests', 
            'pendingReturns', 'recentRequests', 'recentReturns'
        ));
    }

    private function teknisiDashboard()
    {
        $user = auth()->user();
        $myRequests = MaterialRequest::where('user_id', $user->id)->count();
        $myReturns = MaterialReturn::where('user_id', $user->id)->count();
        $pendingRequests = MaterialRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $recentRequests = MaterialRequest::with('material')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('teknisi.dashboard', compact(
            'myRequests', 'myReturns', 'pendingRequests', 'recentRequests'
        ));
    }
}