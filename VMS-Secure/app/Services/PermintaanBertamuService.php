<?php

namespace App\Services;

use App\Models\PermintaanBertamu;

class PermintaanBertamuService
{

    public function save(PermintaanBertamu $permintaanBertamu)
    {
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        $sukses = $permintaanBertamu->save();
        $rs->sukses = $sukses;
        if ($sukses) {
            $rs->pesan[] = 'Sukses kirim Permintaan Bertamu';
            $rs->hasil->jumlah = 1;
            $rs->hasil->data = $permintaanBertamu;
        } else {
            $rs->pesan[] = 'Gagal kirim Permintaan Bertamu';
        }

        return $rs;
    }

    public function getAll()
    {
        $permintaan = PermintaanBertamu::where('status', '!=', 'KADALUARSA')->get();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Array';
        $jumlah = count($permintaan);
        $rs->hasil->jumlah = $jumlah;
        if ($jumlah == 0) {
            $rs->pesan[] = 'Tidak ada data Permintaan Bertamu';
        } else {
            $rs->sukses = true;
            foreach ($permintaan as $p) {
                $p->admin;
                $p->pegawai;
                $p->front_office;
                $p->tamu;
            }
            $rs->pesan[] = 'Data Permintaan Bertamu ditemukan';
        }
        $rs->hasil->data = $permintaan;

        return $rs;
    }

    public function getById($id)
    {
        $permintaan = PermintaanBertamu::where('id', '=', $id)->first();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (is_null($permintaan)) {
            $rs->pesan[] = 'Permintaan Bertamu dengan id ' . $id . ' tidak terdaftar';
        } else {
            $rs->sukses = true;
            $rs->hasil->jumlah = 1;
            $rs->pesan[] = 'Permintaan Bertamu ditemukan';
            $rs->hasil->data = $permintaan;
        }
        return $rs;
    }

    public function getByIdTamu($idTamu)
    {
        $permintaan = PermintaanBertamu::where([['id_tamu', '=', $idTamu], ['status', '<>', 'KADALUARSA']])->get();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Array';
        $jumlah = count($permintaan);
        $rs->hasil->jumlah = $jumlah;
        if ($jumlah == 0) {
            $rs->pesan[] = 'Tidak ada data Permintaan Bertamu dengan id tamu ' . $idTamu;
        } else {
            $rs->sukses = true;
            foreach ($permintaan as $p) {
                $p->admin;
                $p->pegawai;
                $p->tamu;
            }
            $rs->pesan[] = 'Data Permintaan Bertamu ditemukan';
        }
        $rs->hasil->data = $permintaan;

        return $rs;
    }

    public function getByStatus($status)
    {
        $permintaan = PermintaanBertamu::where('status', '=', $status)->get();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Array';
        $jumlah = count($permintaan);
        $rs->hasil->jumlah = $jumlah;
        if ($jumlah == 0) {
            $rs->pesan[] = 'Tidak ada data Permintaan Bertamu dengan status ' . $status;
        } else {
            $rs->sukses = true;
            foreach ($permintaan as $p) {
                $p->admin;
                $p->pegawai;
                $p->tamu;
                $p->buku_tamu;
            }
            $rs->pesan[] = 'Data Permintaan Bertamu ditemukan';
        }
        $rs->hasil->data = $permintaan;

        return $rs;
    }

    public function update($id, $attributes = [])
    {
        $permintaan = PermintaanBertamu::where('id', '=', $id)->first();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (!is_null($permintaan)) {
            $update = $permintaan->update($attributes);
            $rs->sukses = true;
            $rs->pesan[] = 'Sukses update Permintaan Bertamu';
            $rs->hasil->jumlah = 1;
            $rs->hasil->data = $permintaan;
        } else {
            $rs->pesan[] = 'Gagal update Permintaan Bertamu, id tidak ditemukan';
        }

        return $rs;
    }

    public function delete($id)
    {
        $permintaan = PermintaanBertamu::where('id', '=', $id)->first();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (is_null($permintaan)) {
            $rs->pesan[] = 'Gagal delete Permintaan Bertamu, id tidak ditemukan';
        } else {
            $delete = $permintaan->delete();
            if ($delete) {
                $rs->sukses = true;
                $rs->pesan[] = 'Sukses delete Permintaan Bertamu';
                $rs->hasil->jumlah = 1;
            } else {
                $rs->pesan[] = 'Gagal delete Permintaan Bertamu';
            }
        }
        $rs->hasil->data = $permintaan;
        return $rs;
    }
}
