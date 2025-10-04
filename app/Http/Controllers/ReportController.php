<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialRequest;
use App\Models\MaterialReturn;
use App\Models\Report;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with('creator')->orderBy('created_at', 'desc')->paginate(10);
        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.create');
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'jenis_laporan' => 'required|in:stok,permintaan,pengembalian,riwayat',
            'periode_mulai' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_mulai',
        ]);

        $data = $this->generateReportData($validated);

        $report = Report::create([
            'judul_laporan' => $this->getReportTitle($validated['jenis_laporan'], $validated['periode_mulai'], $validated['periode_akhir']),
            'jenis_laporan' => $validated['jenis_laporan'],
            'data_laporan' => $data,
            'periode_mulai' => $validated['periode_mulai'],
            'periode_akhir' => $validated['periode_akhir'],
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('reports.show', $report)->with('success', 'Laporan berhasil dibuat');
    }

    public function show(Report $report)
    {
        return view('reports.show', compact('report'));
    }

    private function generateReportData($params)
    {
        switch ($params['jenis_laporan']) {
            case 'stok':
                return Material::with(['materialRequests', 'materialReturns'])->get()->toArray();
            
            case 'permintaan':
                return MaterialRequest::with(['user', 'material', 'approver'])
                    ->whereBetween('created_at', [$params['periode_mulai'], $params['periode_akhir']])
                    ->get()->toArray();
            
            case 'pengembalian':
                return MaterialReturn::with(['user', 'material', 'receiver'])
                    ->whereBetween('created_at', [$params['periode_mulai'], $params['periode_akhir']])
                    ->get()->toArray();
            
            case 'riwayat':
                $requests = MaterialRequest::with(['user', 'material', 'approver'])
                    ->whereBetween('created_at', [$params['periode_mulai'], $params['periode_akhir']])
                    ->get();
                
                $returns = MaterialReturn::with(['user', 'material', 'receiver'])
                    ->whereBetween('created_at', [$params['periode_mulai'], $params['periode_akhir']])
                    ->get();
                
                return [
                    'requests' => $requests->toArray(),
                    'returns' => $returns->toArray(),
                ];
            
            default:
                return [];
        }
    }

    private function getReportTitle($jenis, $mulai, $akhir)
    {
        $titles = [
            'stok' => 'Laporan Stok Material',
            'permintaan' => 'Laporan Permintaan Material',
            'pengembalian' => 'Laporan Pengembalian Material',
            'riwayat' => 'Laporan Riwayat Material',
        ];

        return $titles[$jenis] . ' (' . Carbon::parse($mulai)->format('d/m/Y') . ' - ' . Carbon::parse($akhir)->format('d/m/Y') . ')';
    }
}