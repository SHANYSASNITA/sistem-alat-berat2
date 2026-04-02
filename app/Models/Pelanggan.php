<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggans';
    public $incrementing = false;
    protected $keyType = 'string';

    // PERBAIKAN: Menambahkan semua kolom baru ke dalam fillable
    protected $fillable = [
        'nama', 
        'kontak', 
        'alamat',
        'tanggal_lahir', 
        'ktp_pelanggan'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function transaksiSewa()
    {
        return $this->hasMany(TransaksiSewa::class, 'pelanggan_id');
    }
}