<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class PricingAlat extends Model
{
    use HasFactory;

    protected $table = 'pricing_alats';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'alat_berat_id',
        'jenis_pekerjaan',
        'harga_per_hari',
        'harga_per_jam',
        'berlaku_mulai',
        'berlaku_selesai'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function alat()
    {
        return $this->belongsTo(AlatBerat::class, 'alat_berat_id');
    }
}
