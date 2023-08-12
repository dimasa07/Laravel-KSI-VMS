<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = "pegawai";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'nip',
        'nama',
        'no_telepon',
        'email',
        'jabatan',
        'alamat',
        'id_akun'
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun');
    }

    public function buku_tamu()
    {
        return $this->hasMany(BukuTamu::class, 'id');
    }
}
