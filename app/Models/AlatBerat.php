<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class AlatBerat extends Model
{
    use HasFactory;

    protected $table = 'alat_berats';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_unit',
        'nama_alat',
        'jenis',
        'merk',
        'tahun',
        'foto',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    // RELASI
    public function pricing()
    {
        return $this->hasMany(PricingAlat::class, 'alat_berat_id');
    }

    public function transaksiSewa()
    {
        return $this->hasMany(TransaksiSewa::class, 'alat_berat_id');
    }
}
