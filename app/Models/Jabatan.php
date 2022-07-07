<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatans';

    protected $fillable = [
        'id',
        'id_unitkerja',
        'nama_jabatan',
        'induk_jabatan'
    ];

    public function opds()
    {
        return $this->belongsTo(Opd::class);
    }

    public function unitkerjas()
    {
        return $this->belongsTo(Unitkerja::class);
    }
}
