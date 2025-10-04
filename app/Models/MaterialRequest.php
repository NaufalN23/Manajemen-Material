<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_permintaan',
        'user_id',
        'material_id',
        'jumlah_diminta',
        'jumlah_disetujui',
        'keterangan',
        'status',
        'tanggal_permintaan',
        'tanggal_persetujuan',
        'approved_by',
    ];

    protected $casts = [
        'tanggal_permintaan' => 'datetime',
        'tanggal_persetujuan' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->nomor_permintaan = 'REQ-' . date('Ymd') . '-' . str_pad(static::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
        });
    }
}