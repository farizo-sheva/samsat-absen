<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaMagang extends Model
{
    use HasFactory;

    protected $table = 'peserta_magang';

    protected $fillable = [
        'nama',
        'asal_instansi',
        'email',
        'password',
    ];

    public function absens()
    {
        return $this->hasMany(Absen::class, 'peserta_magang_id');
    }
}