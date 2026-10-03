<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $fillable = [
        'nama_lapangan',
        'jenis_olahraga',
        'lokasi',
        'harga_per_jam',
        'fasilitas',
        'deskripsi',
        'foto',
        'status',
    ];

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
