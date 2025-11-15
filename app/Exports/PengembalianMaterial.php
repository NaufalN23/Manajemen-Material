<?php

namespace App\Exports;

use App\Models\MaterialRequest;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PengembalianMaterial implements FromView
{
    public function view(): View
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $requests = MaterialRequest::with(['user', 'material'])->paginate(10);
        } else {
            $requests = MaterialRequest::with('material')
                ->where('user_id', $user->id)
                ->paginate(10);
        }

        return view('exports.pengembalian-material', [
            'data' => $requests
        ]);
    }
}
