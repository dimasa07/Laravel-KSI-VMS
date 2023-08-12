<?php

namespace Database\Seeders;

use App\Models\Akun;
use App\Models\Pegawai;
use App\Models\Tamu;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('buku_tamu')->delete();
        DB::table('permintaan_bertamu')->delete();
        DB::table('pegawai')->delete();
        DB::table('akun')->delete();
        //DB::table('user')->delete();

        // SEED DATA ADMIN
        $akunAdmin = Akun::create([
            'role' => 'ADMIN',
            'username' => 'admin',
            'password' => 'admin'
        ]);
        $admin = Pegawai::create([
            'nip' => 1,
            'nama' => 'Admin Diskominfo',
            'no_telepon' => '081234567891',
            'email' => 'admin@gmail.com',
            'id_akun' => $akunAdmin->id
        ]);


        // SEED DATA FRONT OFFICE
        $akunFo = Akun::create([
            'role' => 'FRONT OFFICE',
            'username' => 'frontoffice',
            'password' => 'frontoffice'
        ]);
        $fo = Pegawai::create([
            'nip' => 101,
            'nama' => 'FO Diskominfo',
            'no_telepon' => '081234567101',
            'email' => 'fo@gmail.com',
            'id_akun' => $akunFo->id
        ]);

        // SEED DATA Pegawai
        $pegawai = Pegawai::create([
            'nip' => 1001,
            'nama' => 'Pegawai 1',
            'no_telepon' => '081234510001',
            'email' => 'pegawai@gmail.com'
        ]);
        $pegawai2 = Pegawai::create([
            'nip' => 1002,
            'nama' => 'Pegawai 2',
            'no_telepon' => '081234510002',
            'email' => 'pegawai2@gmail.com'
        ]);
        $pegawai3 = Pegawai::create([
            'nip' => 1003,
            'nama' => 'Pegawai 3',
            'no_telepon' => '081234510003',
            'email' => 'pegawai3@gmail.com'
        ]);

        // SEED DATA TAMU
        $akunTamu = Akun::create([
            'role' => 'TAMU',
            'username' => 'tamu',
            'password' => 'tamu'
        ]);
        $tamu = Tamu::create([
            'nik' => 10001,
            'nama' => 'TAMU 1',
            'no_telepon' => '081234561001',
            'email' => 'tamu@gmail.com',
            'id_akun' => $akunTamu->id
        ]);
    }
}
