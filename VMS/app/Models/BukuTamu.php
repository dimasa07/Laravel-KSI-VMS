<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuTamu extends Model
{
    use HasFactory;

    protected $table = "buku_tamu";
    public $timestamps = false;

    protected $fillable = [
        'id_front_office',
        'id_permintaan',
        'check_in',
        'check_out',
    ];

    public function front_office(){
        return $this->belongsTo(Pegawai::class,'id_front_office');
    }

    public function permintaan_bertamu(){
        return $this->belongsTo(PermintaanBertamu::class,'id_permintaan');
    }
    
}
