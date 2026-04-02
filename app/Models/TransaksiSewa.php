<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class TransaksiSewa extends Model
{
    use HasFactory;

    protected $table = 'transaksi_sewas';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
    'tanggal_mulai' => 'date',
    'tanggal_selesai' => 'date',
    'jenis_pekerjaan' => 'array',
    ];



    protected $fillable = [
        'alat_berat_id',
        'operator_id',
        'pelanggan_id',
        'jenis_sewa',
        'jenis_pekerjaan',
        'lokasi_proyek',
        'mobilisasi',
        'demobilisasi',
        'biaya_modem',
        'tanggal_mulai',
        'tanggal_selesai',
        'harga_sewa_baket',
        'harga_sewa_breker',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    // RELASI
    public function alat()
    {
        return $this->belongsTo(AlatBerat::class, 'alat_berat_id');
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class, 'operator_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class, 'transaksi_sewa_id');
    }

    public function dpPembayaran()
    {
        return $this->hasMany(DpPembayaran::class, 'transaksi_sewa_id');
    }

    public function hmLogs()
    {
        return $this->hasMany(HmLog::class, 'transaksi_sewa_id');
    }

    public function hasbaket()
    {
        return in_array('baket', $this->jenis_pekerjaan ?? []);
    }

    public function hasbreker()
    {
        return in_array('breker', $this->jenis_pekerjaan ?? []);
    }


}
