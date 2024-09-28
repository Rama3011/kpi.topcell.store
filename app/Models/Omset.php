<?php

namespace App\Models;

use App\Models\User;
use App\Models\Penempatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Omset extends Model
{
    use HasFactory;

    protected $table = 'omsets';

    protected $guarded = [];

    // public function sales()
    // {
    //     return $this->belongsTo(karyawan::class, 'karyawan_id', 'id');
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'karyawan_id', 'id');
    }

    public function penempatan()
    {
        return $this->belongsTo(Penempatan::class, 'penempatan_id', 'id'); // Menyesuaikan dengan kolom penempatan_id
    }

    
    
}
