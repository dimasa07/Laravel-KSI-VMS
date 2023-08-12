<?php

namespace App\Models;

class Akun extends User
{

    protected $table = "akun";
    public $timestamps = false;

    protected $fillable = [
        'role',
        'username',
        'password',
        'name',
        'email',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pegawai()
    {
        return $this->hasOne(Pegawai::class, 'id_akun');
    }

    public function tamu()
    {
        return $this->hasOne(Tamu::class, 'id_akun');
    }
}
