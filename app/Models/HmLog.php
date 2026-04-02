<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class HmLog extends Model
{
    use HasFactory;

    protected $table = 'hm_logs';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'transaksi_sewa_id',
        'tanggal_terakhir',
        'tanggal_sekarang',
        'hm_terkahir',
        'hm_sekarang'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function transaksi()
    {
        return $this->belongsTo(TransaksiSewa::class, 'transaksi_sewa_id');
    }
}
