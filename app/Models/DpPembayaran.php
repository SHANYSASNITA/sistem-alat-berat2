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
        'operator_id',
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
    
    public function operator()
    {
        // Catatan: Pastikan ini mengarah ke model Operator, bukan TransaksiSewa
        return $this->belongsTo(Operator::class, 'operator_id'); 
    }
}