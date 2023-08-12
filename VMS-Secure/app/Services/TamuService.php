<?php

namespace App\Services;

use App\Models\Akun;
use App\Models\Tamu;

class TamuService
{

    public function save(Tamu $tamu)
    {
        $cekTamu = $this->getByNIK($tamu->nik);
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (!$cekTamu->sukses) {
            $sukses = $tamu->save();
            $rs->sukses = $sukses;
            if ($sukses) {
                $rs->pesan[] = 'Sukses tambah data Tamu';
                $rs->hasil->jumlah = 1;
                $rs->hasil->data = $this->getByNIK($tamu->nik)->hasil->data;
            } else {
                $rs->pesan[] = 'Gagal tambah data Tamu';
            }
        } else {
            $rs->pesan[] = 'Gagal tambah data Tamu, NIK telah tersedia';
        }

        return $rs;
    }

    public function getAll()
    {
        $tamu = Tamu::all();
        $rs = new ResultSet();
        $rs->sukses = true;
        $jumlah = count($tamu);
        $rs->hasil->jumlah = $jumlah;
        $rs->hasil->tipe = 'Array';
        if ($jumlah == 0) {
            $rs->pesan[] = 'Tidak ada data Tamu';
        } else {
            foreach ($tamu as $t) {
                $t->akun;
            }
            $rs->pesan[] = 'Data Tamu ditemukan';
            $rs->hasil->data = $tamu;
        }

        return $rs;
    }

    public function getById($id)
    {
        $tamu = Tamu::where('id', '=', $id)->first();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (is_null($tamu)) {
            $rs->pesan[] = 'Tamu dengan id ' . $id . ' tidak terdaftar';
        } else {
            $rs->sukses = true;
            $rs->hasil->jumlah = 1;
            $tamu->akun;
            $rs->pesan[] = 'Tamu ditemukan';
            $rs->hasil->data = $tamu;
        }

        return $rs;
    }

    public function getByNIK($nik)
    {
        $tamu = Tamu::where('nik', '=', $nik)->first();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (is_null($tamu)) {
            $rs->pesan[] = 'Tamu dengan NIK ' . $nik . ' tidak terdaftar';
        } else {
            $rs->sukses = true;
            $rs->hasil->jumlah = 1;
            $tamu->akun;
            $rs->pesan[] = 'Tamu ditemukan';
            $rs->hasil->data = $tamu;
        }

        return $rs;
    }

    public function getByNama($name)
    {
        $tamu = Tamu::where('nama', 'LIKE', '%' . $name . '%')->get();
        $rs = new ResultSet();
        $rs->sukses = true;
        $jumlah = count($tamu);
        $rs->hasil->jumlah = $jumlah;
        $rs->hasil->tipe = 'Array';
        if ($jumlah == 0) {
            $rs->pesan[] = 'Tidak ada data Tamu dengan nama ' . $name;
        } else {
            foreach ($tamu as $t) {
                $t->akun;
            }
            $rs->pesan[] = 'Data Tamu ditemukan';
            $rs->hasil->data = $tamu;
        }

        return $rs;
    }

    public function update($id, $attributes = [])
    {
        $tamu = Tamu::where('id', '=', $id)->first();
        $newNIK = $attributes['nik'];
        $cekTamu = $this->getByNIK($newNIK);
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (!is_null($tamu)) {
            if (!$cekTamu->sukses || $tamu->nik == $newNIK) {
                $update = $tamu->update($attributes);
                $rs->sukses = true;
                $rs->pesan[] = 'Sukses update Profil';
                $rs->hasil->jumlah = 1;
                $rs->hasil->data = $tamu;
            } else {
                $rs->pesan[] = 'Gagal update Profil, NIK telah tersedia';
            }
        } else {
            $rs->pesan[] = 'Gagal update Profil, id tidak ditemukan';
        }

        return $rs;
    }

    public function delete($id)
    {
        $tamu = Tamu::where('id', '=', $id)->first();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        $akun = null;
        if (is_null($tamu)) {
            $rs->pesan[] = 'Gagal delete Tamu, id tidak ditemukan';
        } else {
            $delete = $tamu->delete();
            if ($delete) {
                $akun = Akun::where('id', '=', $tamu->id_akun)->first();
                if (!is_null($akun)) {
                    $akun->delete();
                }
                $rs->sukses = true;
                $rs->pesan[] = 'Sukses delete Tamu';
                $rs->hasil->jumlah = 1;
            } else {
                $rs->pesan[] = 'Gagal delete Tamu';
            }
        }
        $data['tamu'] = $tamu;
        $data['akun'] = $akun;
        $rs->hasil->data = $data;
        return $rs;
    }
}
