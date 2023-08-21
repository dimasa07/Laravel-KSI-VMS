<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Tamu;
use App\Services\AkunService;
use App\Services\PegawaiService;
use App\Services\ResultSet;
use App\Services\TamuService;
use Illuminate\Http\Request;

use Hash;

class UserController extends Controller
{

    public function __construct(
        public AkunService $akunService,
        public TamuService $tamuService,
        public PegawaiService $pegawaiService
    ) {
    }

    public function formLogin(Request $request)
    {
        return view('user.login');
    }

    public function formDaftar(Request $request)
    {
        return view('user.daftar');
    }

    public function login(Request $request)
    {
        // $this->validate(
        //     $request,
        //     [
        //         'username' => 'required',
        //         'password' => 'required'
        //     ],
        //     [
        //         'username.required' => 'Username tidak boleh kosong',
        //         'password.required' => 'Password tidak boleh kosong'
        //     ]
        // );
        $username = $request->input('username');
        $password = $request->input('password');

        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        $rsAkun = $this->akunService->getByUsernameAndPassword($username, $password);
        if ($rsAkun->sukses) {
            $akun = $rsAkun->hasil->data;
            $akun->pegawai;
            $akun->tamu;
            $rs->pesan[] = 'Sukses Login';
            $rs->sukses = true;
            $rs->hasil->jumlah = 1;
            $rs->hasil->data = $akun;
            $request->session()->put('username', $akun->username);
            $request->session()->put('role', $akun->role);
            $id = 0;
            $route = "";
            if ($akun->role == "ADMIN") {
                if (!is_null($akun->pegawai)) {
                    $request->session()->put('nip', $akun->pegawai->nip);
                    $request->session()->put('nama', $akun->pegawai->nama);
                    $id = $akun->pegawai->id;
                }
                $route = "admin.index";
            } else if ($akun->role == "TAMU") {
                if (!is_null($akun->tamu)) {
                    $request->session()->put('nik', $akun->tamu->nik);
                    $request->session()->put('nama', $akun->tamu->nama);
                    $id = $akun->tamu->id;;
                }
                $route = "tamu.index";
            } else if ($akun->role == "FRONT OFFICE") {
                if (!is_null($akun->pegawai)) {
                    $request->session()->put('nip', $akun->pegawai->nip);
                    $request->session()->put('nama', $akun->pegawai->nama);
                    $id = $akun->pegawai->id;
                }
                $route = "fo.index";
            }
            $request->session()->put('id', $id);
            return redirect()->route($route)->with('info', 'Selamat datang ' . $request->session()->get('nama', $akun->username));
        } else {
            $rs->pesan[] = 'Gagal Login, ' . $rsAkun->pesan[0];
            return back()->with('gagal', $rs->pesan[0]);
        }

        //return response()->json($rs);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('id');
        $request->session()->forget('nik');
        $request->session()->forget('nip');
        $request->session()->forget('username');
        $request->session()->forget('role');
        $request->session()->forget('nama');

        return redirect()->route('beranda');
    }

    public function daftar(Request $request)
    {
        // $rs = new ResultSet();
        // $rs->hasil->tipe = 'Object';
        // $tamu = new Tamu();
        // $tamu->fill($request->input());
        // $cekTamu = $this->tamuService->getByNIK($tamu->nik);
        // if ($cekTamu->sukses) {
        //     $rs->pesan[] = 'Gagal daftar, NIK sudah terdaftar';
        // } else {
        //     $akun = new Akun();
        //     $akun->fill($request->input());
        //     $saveAkun = $this->akunService->save($akun);
        //     if (!$saveAkun->sukses) {
        //         $rs->pesan = $saveAkun->pesan;
        //     } else {
        //         $tamu->id_akun = $akun->id;
        //         $saveTamu = $this->tamuService->save($tamu);
        //         $rs->sukses = $saveTamu->sukses;
        //         $rs->hasil->jumlah = 1;
        //         $rs->hasil->data['tamu'] = $tamu;
        //         $rs->hasil->data['akun'] = $akun;
        //         $rs->pesan[] = 'Sukses daftar';
        //         return redirect()->route('user.login');
        //     }
        // }


        $password = $request->input('password');
        $rePassword = $request->input('re_password');
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if ($password != $rePassword) {
            $rs->pesan[] = 'Password dan Re-password tidak sesuai.';
        } else {
            $akun = new Akun();
            $akun->fill($request->input());
            $akun->password = Hash::make($password);
            $rsSave = $this->akunService->save($akun);
            if ($rsSave->sukses) {
                $rs->pesan[] = 'Sukses daftar.';
                $rs->sukses = true;
                $rs->hasil->jumlah = 1;
                $rs->hasil->data = $akun;
                return redirect()->route('user.login')->with('sukses', $rs->pesan[0]);
            } else {
                $rs->pesan = $rsSave->pesan;
            }
        }
        return back()->with('eror', $rs->pesan[0]);
        // return response()->json($rs);
    }

    public function allUser()
    {
        $rs = $this->akunService->getAll();
        return response()->json($rs);
    }

    public function getByUsername(string $username)
    {
        $rs = $this->akunService->getByUsername($username);
        return response()->json($rs);
    }

    public function getByRole(string $role)
    {
        $rs = $this->akunService->getByRole($role);
        return response()->json($rs);
    }

    public function getTamuById($id)
    {
        $rs = $this->tamuService->getById($id);
        return response()->json($rs);
    }

    public function getTamuByNIK($nik)
    {
        $rs = $this->tamuService->getByNIK($nik);
        return response()->json($rs);
    }

    public function getTamuByNama($nama)
    {
        $rs = $this->tamuService->getByNama($nama);
        return response()->json($rs);
    }

    public function getPegawaiById($id)
    {
        $rs = $this->pegawaiService->getById($id);
        return response()->json($rs);
    }

    public function getPegawaiByNIP($nip)
    {
        $rs = $this->pegawaiService->getByNIP($nip);
        return response()->json($rs);
    }

    public function getPegawaiByNama($nama)
    {
        $rs = $this->pegawaiService->getByNama($nama);
        return response()->json($rs);
    }

    public function updateAkun(Request $request)
    {
        $rs = $this->akunService->update($request->input('id'), $request->input());
        return response()->json($rs);
    }

    public function updateTamu(Request $request)
    {
        $rs = $this->tamuService->update($request->input('id'), $request->input());
        return response()->json($rs);
    }

    public function updatePegawai(Request $request)
    {
        $rs = $this->pegawaiService->update($request->input('id'), $request->input());
        return response()->json($rs);
    }

    public function deleteAkun($id)
    {
        $rs = $this->akunService->delete($id);
        return response()->json($rs);
    }

    public function deleteTamu($id)
    {
        $rs = $this->tamuService->delete($id);
        return response()->json($rs);
    }

    public function deletePegawai($id)
    {
        $rs = $this->pegawaiService->delete($id);
        return response()->json($rs);
    }
}
