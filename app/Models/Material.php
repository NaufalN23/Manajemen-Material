<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_material',
        'nama_material',
        'deskripsi',
        'satuan',
        'stok',
        'minimum_stok',
        'harga',
        'lokasi_penyimpanan',
        'status',
    ];

    public function materialRequests()
    {
        return $this->hasMany(MaterialRequest::class);
    }

    public function materialReturns()
    {
        return $this->hasMany(MaterialReturn::class);
    }

    public function isLowStock()
    {
        return $this->stok <= $this->minimum_stok;
    }
}
