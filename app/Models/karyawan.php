<?php

namespace App\Models;

use App\Models\Jabatan;
use App\Models\Kontrak;
use App\Models\Penempatan;
use App\Models\Absensi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory;

    // Menentukan tabel yang digunakan dalam database
    protected $table = 'karyawans'; // Pastikan tabel ini benar di database

    // Mengizinkan semua field untuk diisi secara massal
    protected $guarded = []; 

    /**
     * Relasi ke model Jabatan
     * 
     * Menunjukkan bahwa karyawan memiliki satu jabatan.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id'); // Foreign key 'jabatan_id' mengarah ke 'id' di tabel jabatan
    }

    /**
     * Relasi ke model Kontrak
     * 
     * Setiap karyawan bisa memiliki satu kontrak.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kontrak()
    {
        return $this->belongsTo(Kontrak::class, 'kontrak_id', 'id'); // Foreign key 'kontrak_id' mengarah ke 'id' di tabel kontrak
    }

    /**
     * Relasi ke model Penempatan
     * 
     * Menunjukkan bahwa karyawan ditempatkan di satu penempatan.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function penempatan()
    {
        return $this->belongsTo(Penempatan::class, 'penempatan_id', 'id'); // Foreign key 'penempatan_id' mengarah ke 'id' di tabel penempatan
    }

    /**
     * Relasi ke model Absensi
     * 
     * Karyawan memiliki banyak absensi.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'karyawan_id', 'id'); // Relasi satu-ke-banyak, 'karyawan_id' sebagai foreign key di tabel absensi
    }
   
}
