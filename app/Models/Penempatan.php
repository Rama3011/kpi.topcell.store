<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penempatan extends Model
{
    use HasFactory;

    protected $table = 'penempatans';

    protected $guarded = [];

    public function penempatan()
{
    return $this->belongsTo(Penempatan::class, 'penempatan_id', 'id');
}

}
