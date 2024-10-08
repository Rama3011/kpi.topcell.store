<?php

namespace App\Models;

use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Penempatan;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 
        'email',
        'password',
        'kode_user',
        'stock_tabung',
        'alamat',
        'id_agent',
        'id_kecamatan',
        'id_desa',
        'level',
        'karyawan_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function scopeIsNotAdmin($query)
    {
        return $query->where([
            ['level', '!=', 1],
            ['level', '!=', 2]
        ]);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id');
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa', 'id');
    }
    

    public function data_karyawan()
    {
        return $this->belongsTo(karyawan::class, 'karyawan_id', 'id');
    }
    public function penempatan()
{
    return $this->hasOneThrough(Penempatan::class, Karyawan::class, 'id', 'id', 'karyawan_id', 'penempatan_id');
}

}
