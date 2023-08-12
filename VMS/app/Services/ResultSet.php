<?php

namespace App\Services;

class ResultSet
{
    public bool $sukses = false;
    public array $pesan = [];
    public Hasil $hasil;

    public function __construct(){
        $this->hasil = new Hasil();
    }
    
}

class Hasil{
    public string $tipe = '';
    public int $jumlah = 0;
    public $data = null;
}