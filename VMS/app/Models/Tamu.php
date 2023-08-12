<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    use HasFactory;

    protected $table = "tamu";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'nik',
        'nama',
        'no_telepon',
        'email',
        'alamat',
        'id_akun'
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun');
    }

    public function permintaan(){
        return $this->hasMany(PermintaanBertamu::class,'id');
    }
}
