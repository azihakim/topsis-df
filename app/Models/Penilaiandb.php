<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaiandb extends Model
{
    use HasFactory;

    protected $table = 'penilaians';
    protected $fillable = [
        'tgl_penilaian',
        'data_penilaian'
    ];
    // protected $casts = [
    //     'data' => 'array',
    // ];

    // public function pelanggans()
    // {
    //     return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    // }
}
