<?php

namespace App\Models;

use App\Models\User;
use App\Models\Penempatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis'; // Nama tabel di database

    protected $guarded = []; // Mengizinkan semua field untuk diisi

    // Relasi ke model User (Karyawan)
    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan_id', 'id'); // Menyesuaikan dengan kolom karyawan_id
    }

    // Relasi ke model Penempatan
    public function penempatan()
    {
        return $this->belongsTo(Penempatan::class, 'penempatan_id', 'id'); // Menyesuaikan dengan kolom penempatan_id
    }
}
