<?php

namespace App\Services;

use App\Models\Akun;

class AkunService
{
    public function save(Akun $akun)
    {
        $cekAkun = $this->getByUsername($akun->username);
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (!$cekAkun->sukses) {
            $sukses = $akun->save();
            $rs->sukses = $sukses;
            if ($sukses) {
                $rs->pesan[] = 'Sukses tambah Akun';
                $rs->hasil->jumlah = 1;
                $rs->hasil->data = $akun;
            } else {
                $rs->pesan[] = 'Gagal tambah Akun';
            }
        } else {
            $rs->pesan[] = 'Gagal tambah Akun, Username telah tersedia';
        }

        return $rs;
    }

    public function getAll()
    {
        $users = Akun::all();
        $rs = new ResultSet();
        $rs->sukses = true;
        $jumlah = count($users);
        $rs->hasil->jumlah = $jumlah;
        $rs->hasil->tipe = 'Array';
        if ($jumlah == 0) {
            $rs->pesan[] = 'Tidak ada data User';
        } else {
            foreach ($users as $user) {
                $user->tamu;
                $user->pegawai;
            }
            $rs->pesan[] = 'Data User ditemukan';
            $rs->hasil->data = $users;
        }

        return $rs;
    }

    public function getById($id)
    {
        $akun = Akun::where('id', '=', $id)->first();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (is_null($akun)) {
            $rs->pesan[] = 'Akun dengan id ' . $id . ' tidak terdaftar';
        } else {
            $rs->sukses = true;
            $rs->hasil->jumlah = 1;
            $rs->pesan[] = 'Akun ditemukan';
            $rs->hasil->data = $akun;
        }
        return $rs;
    }

    public function getByUsername($username)
    {
        $akun = Akun::where('username', '=', $username)->first();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (is_null($akun)) {
            $rs->pesan[] = 'Akun dengan Username ' . $username . ' tidak terdaftar';
        } else {
            $akun->pegawai;
            $akun->tamu;
            $rs->sukses = true;
            $rs->hasil->jumlah = 1;
            $rs->pesan[] = 'Akun ditemukan';
            $rs->hasil->data = $akun;
        }
        return $rs;
    }

    public function getByUsernameAndPassword($username, $password)
    {
        $akun = Akun::where([
            ['username', '=', $username],
            ['password', '=', $password]
        ])->first();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (is_null($akun)) {
            $rs->pesan[] = 'Akun dengan Username & Password tersebut tidak terdaftar';
        } else {
            $rs->sukses = true;
            $rs->hasil->jumlah = 1;
            $rs->pesan[] = 'Akun ditemukan';
            $rs->hasil->data = $akun;
        }
        return $rs;
    }

    public function getByRole($role)
    {
        $users = Akun::where('role', '=', $role)->get();
        $jumlah = count($users);
        $rs = new ResultSet();
        $rs->sukses = true;
        $rs->hasil->jumlah = $jumlah;
        $rs->hasil->tipe = 'Array';
        if ($jumlah == 0) {
            $rs->pesan[] = 'Tidak ada data User dengan Role ' . $role;
        } else {
            foreach ($users as $akun) {
                if ($role == 'TAMU')
                    $akun->tamu;
                else $akun->pegawai;
            }
            $rs->pesan[] = 'Data User dengan Role ' . $role . ' ditemukan';
            $rs->hasil->data = $users;
        }

        return $rs;
    }

    public function update($id, $attributes = [])
    {
        $akun = Akun::where('id', '=', $id)->first();
        $newUsername = $attributes['username'];
        $cekAkun = $this->getByUsername($newUsername);
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (!is_null($akun)) {
            if (!$cekAkun->sukses || $akun->username == $newUsername) {
                $update = $akun->update($attributes);
                $rs->sukses = true;
                $rs->pesan[] = 'Sukses update Akun';
                $rs->hasil->jumlah = 1;
                $rs->hasil->data = $akun;
            } else {
                $rs->pesan[] = 'Gagal update Akun, Username telah tersedia';
            }
        } else {
            $rs->pesan[] = 'Gagal update Akun, id tidak ditemukan';
        }

        return $rs;
    }

    public function delete($id)
    {
        $akun = Akun::where('id', '=', $id)->first();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (is_null($akun)) {
            $rs->pesan[] = 'Gagal delete Akun, id tidak ditemukan';
        } else {
            $delete = $akun->delete();
            if ($delete) {
                $rs->sukses = true;
                $rs->pesan[] = 'Sukses delete Akun';
                $rs->hasil->jumlah = 1;
            } else {
                $rs->pesan[] = 'Gagal delete Akun';
            }
        }
        $rs->hasil->data = $akun;
        return $rs;
    }

    public function deleteByUsername($username)
    {
        $akun = Akun::where('username', '=', $username)->first();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (is_null($akun)) {
            $rs->pesan[] = 'Gagal delete Akun, username tidak ditemukan';
        } else {
            $delete = $akun->delete();
            if ($delete) {
                $rs->sukses = true;
                $rs->pesan[] = 'Sukses delete Akun';
                $rs->hasil->jumlah = 1;
            } else {
                $rs->pesan[] = 'Gagal delete Akun';
            }
        }
        $rs->hasil->data = $akun;
        return $rs;
    }

    
}
