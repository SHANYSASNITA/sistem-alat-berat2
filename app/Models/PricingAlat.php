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
        'harga_baket',    
        'harga_breker',    
        'berlaku_mulai',
        'berlaku_selesai',
        'status'
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
