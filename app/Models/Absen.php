<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $table = 'absens';

    protected $fillable = [
        'peserta_magang_id',
        'tanggal',
        'jam_masuk',
        'status',
    ];

    public function pesertaMagang()
    {
        return $this->belongsTo(PesertaMagang::class, 'peserta_magang_id');
    }
}