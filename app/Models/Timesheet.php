<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Timesheet extends Model
{
    use HasFactory;

    protected $table = 'timesheets';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'tanggal' => 'date',
    ];


    protected $fillable = [
        'transaksi_sewa_id',
        'tanggal',
        'hm_awal',
        'hm_akhir',
        'jam_baket',
        'jam_breker',
        'foto'
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
