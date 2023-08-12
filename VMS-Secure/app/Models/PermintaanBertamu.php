<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanBertamu extends Model
{
    use HasFactory;

    protected $table = "permintaan_bertamu";
    public $timestamps = false;

    protected $fillable = [
        'id_tamu',
        'id_admin',
        'id_front_office',
        'id_pegawai',
        'keperluan',
        'waktu_bertamu',
        'waktu_pengiriman',
        'waktu_pemeriksaan',
        'status',
        'batas_waktu',
        'pesan_ditolak'
    ];

    public function frontOffice()
    {
        return $this->belongsToMany(
            Pegawai::class,
            'buku_tamu',
            'id',
            'id_front_office'
        );
    }

    public function admin()
    {
        return $this->belongsTo(
            Pegawai::class,
            'id_admin'
        );
    }

    public function front_office()
    {
        return $this->belongsTo(
            Pegawai::class,
            'id_front_office'
        );
    }

    public function tamu()
    {
        return $this->belongsTo(
            Tamu::class,
            'id_tamu'
        );
    }

    public function pegawai()
    {
        return $this->belongsTo(
            Pegawai::class,
            'id_pegawai'
        );
    }

    public function buku_tamu(){
        return $this->hasOne(BukuTamu::class,'id_permintaan');
    }
}
