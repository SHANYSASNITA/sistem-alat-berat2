<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Operator extends Model
{
    use HasFactory;

    protected $table = 'operators';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama', 
        'no_hp', 
        'alamat', 
        'tanggal_lahir', 
        'ktp_operator'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->id = (string) Str::uuid());
    }

    public function transaksiSewa()
    {
        return $this->hasMany(TransaksiSewa::class, 'operator_id');
    }
    
    public function operator()
    {
        return $this->hasMany(Operator::class, 'operator_id');
    }
}