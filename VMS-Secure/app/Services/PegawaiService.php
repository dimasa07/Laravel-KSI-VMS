<?php

namespace App\Services;

use App\Models\Akun;
use App\Models\Pegawai;

class PegawaiService
{
    public function __construct(
        public AkunService $akunService
    ) {
    }

    public function save(Pegawai $pegawai)
    {
        $cekPegawai = $this->getByNIP($pegawai->nip);
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (!$cekPegawai->sukses) {
            $sukses = $pegawai->save();
            $rs->sukses = $sukses;
            if ($sukses) {
                $rs->pesan[] = 'Sukses tambah Pegawai';
                $rs->hasil->jumlah = 1;
                $rs->hasil->data = $pegawai;
            } else {
                $rs->pesan[] = 'Gagal tambah Pegawai';
            }
        } else {
            $rs->pesan[] = 'Gagal tambah Pegawai, NIP telah tersedia';
        }

        return $rs;
    }

    public function getAll()
    {
        $pegawai = Pegawai::all();
        $rs = new ResultSet();
        $jumlah = count($pegawai);
        $rs->hasil->jumlah = $jumlah;
        $rs->hasil->tipe = 'Array';
        if ($jumlah == 0) {
            $rs->pesan[] = 'Tidak ada data Pegawai';
        } else {
            $rs->sukses = true;
            foreach ($pegawai as $p) {
                $p->akun;
            }
            $rs->pesan[] = 'Data Pegawai ditemukan';
            $rs->hasil->data = $pegawai;
        }

        return $rs;
    }

    public function getAllAdmin()
    {
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Array';
        $admins = [];
        $akuns = $this->akunService->getByRole('ADMIN')->hasil->data;
        foreach ($akuns as $akun) {
            $admins[] = $akun->pegawai;
        }
        $jumlah = count($admins);
        $rs->hasil->jumlah = $jumlah;
        if ($jumlah == 0) {
            $rs->pesan[] = 'Tidak ada data Admin';
        } else {
            // foreach ($admins as $admin) {
            //     $admin->akun;
            // }
            $rs->sukses = true;
            $rs->pesan[] = 'Data Admin ditemukan';
            $rs->hasil->data = $admins;
        }
        return $rs;
    }

    public function getAllFrontOffice()
    {
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Array';
        $fo = [];
        $akuns = $this->akunService->getByRole('FRONT OFFICE')->hasil->data;
        foreach ($akuns as $akun) {
            $fo[] = $akun->pegawai;
        }
        $jumlah = count($fo);
        $rs->hasil->jumlah = $jumlah;
        if ($jumlah == 0) {
            $rs->pesan[] = 'Tidak ada data Front Office';
        } else {
            // foreach ($fo as $o) {
            //     $o->akun;
            // }
            $rs->sukses = true;
            $rs->pesan[] = 'Data Front Office ditemukan';
            $rs->hasil->data = $fo;
        }
        return $rs;
    }

    public function getById($id)
    {
        $pegawai = Pegawai::where('id', '=', $id)->first();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (is_null($pegawai)) {
            $rs->pesan[] = 'Pegawai dengan id ' . $id . ' tidak terdaftar';
        } else {
            $rs->sukses = true;
            $rs->hasil->jumlah = 1;
            $pegawai->akun;
            $rs->pesan[] = 'Pegawai ditemukan';
            $rs->hasil->data = $pegawai;
        }

        return $rs;
    }

    public function getByNIP($nip)
    {
        $pegawai = Pegawai::where('nip', '=', $nip)->first();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (is_null($pegawai)) {
            $rs->pesan[] = 'Pegawai dengan NIP ' . $nip . ' tidak terdaftar';
        } else {
            $rs->sukses = true;
            $rs->hasil->jumlah = 1;
            $pegawai->akun;
            $rs->pesan[] = 'Pegawai ditemukan';
            $rs->hasil->data = $pegawai;
        }

        return $rs;
    }

    public function getByNama($nama)
    {
        $pegawai = Pegawai::where('nama', 'LIKE', '%' . $nama . '%')->get();
        $rs = new ResultSet();
        $jumlah = count($pegawai);
        $rs->hasil->jumlah = $jumlah;
        $rs->hasil->tipe = 'Array';
        if ($jumlah == 0) {
            $rs->pesan[] = 'Tidak ada data Pegawai dengan nama '.$nama;
        } else {
            $rs->sukses = true;
            foreach ($pegawai as $p) {
                $p->akun;
            }
            $rs->pesan[] = 'Data Pegawai ditemukan';
            $rs->hasil->data = $pegawai;
        }

        return $rs;
    }

    public function getByNullAkun()
    {
        $pegawai = Pegawai::whereNull('id_akun')->get();
        $rs = new ResultSet();
        $jumlah = count($pegawai);
        $rs->hasil->jumlah = $jumlah;
        $rs->hasil->tipe = 'Array';
        if ($jumlah == 0) {
            $rs->pesan[] = 'Tidak ada data ';
        } else {
            $rs->sukses = true;
            foreach ($pegawai as $p) {
                $p->akun;
            }
            $rs->pesan[] = 'Data Pegawai ditemukan';
            $rs->hasil->data = $pegawai;
        }

        return $rs;
    }

    public function update($id, $attributes = [])
    {
        $pegawai = Pegawai::where('id', '=', $id)->first();
        $newNIP = $attributes['nip'];
        $cekPegawai = $this->getByNIP($newNIP);
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (!is_null($pegawai)) {
            if (!$cekPegawai->sukses || $pegawai->nip == $newNIP) {
                $update = $pegawai->update($attributes);
                $rs->sukses = true;
                $rs->pesan[] = 'Sukses update Profil';
                $rs->hasil->jumlah = 1;
                $rs->hasil->data = $pegawai;
            } else {
                $rs->pesan[] = 'Gagal update Profil, NIP telah tersedia';
            }
        } else {
            $rs->pesan[] = 'Gagal update Profil, id tidak ditemukan';
        }

        return $rs;
    }

    public function delete($id)
    {
        $pegawai = Pegawai::where('id', '=', $id)->first();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        $akun = null;
        if (is_null($pegawai)) {
            $rs->pesan[] = 'Gagal delete Pegawai, id tidak ditemukan';
        } else {
            $delete = Pegawai::where('id', '=', $id)->delete();
            if ($delete) {
                $akun = Akun::where('id', '=', $pegawai->id_akun)->first();
                if (!is_null($akun)) {
                    $akun->delete();
                }
                $rs->sukses = true;
                $rs->pesan[] = 'Sukses delete Pegawai';
                $rs->hasil->jumlah = 1;
            } else {
                $rs->pesan[] = 'Gagal delete Pegawai';
            }
        }
        $data['pegawai'] = $pegawai;
        $data['akun'] = $akun;
        $rs->hasil->data = $data;
        return $rs;
    }
}
