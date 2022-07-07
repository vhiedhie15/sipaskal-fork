<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jabatan;
use Opd;

class Unitkerja extends Model
{
    use HasFactory;

    protected $table = 'unitkerjas';

    protected $fillable = [
        'id',
        'nama_unitkerja',
        'induk_unitkerja',
        'alamat',
        'id_opd'
    ];

    public function jabatans()
    {
        return $this->hasMany(Jabatan::class);
    }

    public function opds()
    {
        return $this->belongsTo(Opd::class);
    }
}
