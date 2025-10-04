<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_pengembalian',
        'user_id',
        'material_id',
        'jumlah_dikembalikan',
        'kondisi_material',
        'keterangan',
        'status',
        'tanggal_pengembalian',
        'received_by',
    ];

    protected $casts = [
        'tanggal_pengembalian' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->nomor_pengembalian = 'RET-' . date('Ymd') . '-' . str_pad(static::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
        });
    }
}