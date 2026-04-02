<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class LokasiProyek extends Model
{
    use HasFactory;

    protected $table = 'lokasi_proyeks';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nama_lokasi', 'kabupaten', 'alamat'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function transaksiSewa()
    {
        return $this->hasMany(TransaksiSewa::class, 'lokasi_id');
    }
}
