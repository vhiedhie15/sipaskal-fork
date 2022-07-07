<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unitkerja;

class Opd extends Model
{
    use HasFactory;

    protected $table = 'opds';

    protected $fillable = [
        'id',
        'nama_opd',
        'singkatan',
        'alamat'
    ];

    public function unitkerjas()
    {
        return $this->hasMany(Unitkerja::class);
    }
}
