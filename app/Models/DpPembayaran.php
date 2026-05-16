<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class DpPembayaran extends Model
{
    use HasFactory;

    protected $table = 'dp_pembayarans';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'tanggal' => 'date',
    ];

    protected $fillable = [
        'transaksi_sewa_id',
        'tanggal',
        'jumlah',
        'keterangan',
        'status',
        'bukti_pembayaran'
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